<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('config.php');

if(!isset($_SESSION['pseudo'])) {
    header('Location: connexion.php');
    exit;
}

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $getid = $_GET['id'];

    $req = $conn->prepare('SELECT * FROM categorie WHERE id = ?');
    $req->execute(array($getid));
    if($req->rowCount() == 1) {
        $donnees = $req->fetch();
    } else {
        die("Cet article n'existe pas");
    }
} else {
    die("L'id n'est pas recuperé");
}

if(isset($_POST['valider'])) {
    $title = htmlspecialchars($_POST['title']);
    $date = htmlspecialchars($_POST['date']);
    $description = nl2br(htmlspecialchars($_POST['description']));
    $code_color = htmlspecialchars($_POST['code_color']);
}
    

    if (isset($_FILES['img_illustration']) && $_FILES['img_illustration']['error'] == 0) {
        $tmpName = $_FILES['img_illustration']['tmp_name'];
        $name = $_FILES['img_illustration']['name'];
        $size = $_FILES['img_illustration']['size'];
        $error = $_FILES['img_illustration']['error'];

        $tabExtension = explode('.', $name);
        $extension = strtolower(end($tabExtension));

        $extensions = ['jpg', 'png', 'jpeg', 'gif'];

        $maxSize = 4000000;

        if (in_array($extension, $extensions) && $size <= $maxSize) {
            $uniqueName = uniqid('', true);
            $file = $uniqueName . "." . $extension;
            move_uploaded_file($tmpName, './img_categorie/' . $file);
            $img_illustration = './img_categorie/' . $file;
        } else {
            die('Le fichier n\'est pas une image ou il est trop gros');
        }
    } else {
        die('Fichier non uploadé');
    }

    if(!empty($title) AND !empty($date) AND !empty($description) AND !empty($code_color) AND !empty($img_illustration)) {
        $req = $conn->prepare('UPDATE categorie SET title = ?, date = ?, description = ?, code_color = ?, img_illustration = ? WHERE id = ?');
        $req->execute(array($title, $date, $description, $code_color, $img_illustration, $getid));
        header('Location: categories.php');
        exit;
    } else {
        echo "Veuillez remplir tous les champs";
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une catégorie</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Titre" value="<?php echo $donnees['title']; ?>" required><br>
        <input type="date" name="date" value="<?php echo $donnees['date']; ?>" required><br>
        <textarea name="description" placeholder="Description" required><?php echo $donnees['description']; ?></textarea><br>
        <input type="color" name="code_color" value="<?php echo $donnees['code_color']; ?>" required><br>
        <input type="file" name="img_illustration" required><br>
        <input type="submit" name="valider">
    </form>
</body>
</html>

