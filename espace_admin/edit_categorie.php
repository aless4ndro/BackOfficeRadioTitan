<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('config.php');

if (!$_SESSION['pseudo']) {
    header('Location: connexion.php');
}

if (isset($_POST['valider'])) {
    $title = htmlspecialchars($_POST['title']);
    $date = nl2br(htmlspecialchars($_POST['date']));
    $description = nl2br(htmlspecialchars($_POST['description']));
    $code_color = nl2br(htmlspecialchars($_POST['code_color']));

    if (isset($_FILES['img_illustration']) && $_FILES['img_illustration']['error'] == 0) {
        $tmpName = $_FILES['img_illustration']['tmp_name'];
        $name = $_FILES['img_illustration']['name'];
        $size = $_FILES['img_illustration']['size'];
        $error = $_FILES['img_illustration']['error'];

        $tabExtension = explode('.', $name);
        $extension = strtolower(end($tabExtension));

        $extensions = ['jpg', 'png', 'jpeg', 'gif']; // Les extensions autorisées

        $maxSize = 4000000; // Taille max en octets du fichier

        if (in_array($extension, $extensions) && $size <= $maxSize) {
            $uniqueName = uniqid('', true);
            $file = $uniqueName . "." . $extension;
            move_uploaded_file($tmpName, './img_categorie' . $file); // Déplace le fichier dans votre répertoire d'images
            $img_illustration = './img_categorie' . $file;
            header('Location: index.php');
        } else {
            echo 'Le fichier n\'est pas une image ou il est trop gros';
        }
    } else {
        echo 'Fichier non uploadé';
    }

    if (!empty($title) and !empty($date) and !empty($description) and !empty($code_color) and !empty($img_illustration)) {
        $req = $conn->prepare('INSERT INTO categorie(title, date, description, code_color, img_illustration, id) VALUES(?, ?, ?, ?, ?)');
        $req->execute(array($title, $date, $description, $code_color, $img_illustration));
        echo "Votre article a bien été publié";
    } else {
        echo "Veuillez remplir tous les champs";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edition de la catégorie</title>
</head>

<body>
    <form method="POST" action="" align="center" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Titre">
        <br>
        <input type="date" name="date" placeholder="Date">
        <br>
        <textarea name="description" placeholder="Description"></textarea>
        <br>
        <input type="text" name="code_color" placeholder="Code couleur">
        <br>
        <input type="file" name="img_illustration">
        <br>
        <input type="submit" name="valider">
        <br>
        <button><a href="modifier_categorie.php">Modifier</a></button>

        <?php
        $req = $conn->prepare('SELECT * FROM categorie');
        $req->execute();
        while ($donnees = $req->fetch()) {
        ?>
            <p>
                <strong>Catégorie</strong> : <?php echo $donnees['title']; ?><br />
                <strong>Date</strong> : <?php echo $donnees['date']; ?><br />
                <strong>Description</strong> : <?php echo $donnees['description']; ?><br />
                <strong>Code couleur</strong> : <?php echo $donnees['code_color']; ?><br />
                <strong>Image d'illustration</strong> : <img src="<?php echo $donnees['img_illustration']; ?>" alt="Image d'illustration" style="width: 100px;"><br />
            </p>
        <?php
        }
        $req->closeCursor();// Termine le traitement de la requête
        ?>
    </form>
</body>

</html>