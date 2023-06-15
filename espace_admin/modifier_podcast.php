<?php
session_start();
include('config.php');
if(isset($_GET['id']) and !empty($_GET['id'])) {
    $getid = $_GET['id'];

    $req = $conn->prepare('SELECT * FROM podcast WHERE id = ?');
    $req->execute(array($getid));//on vérifie si l'id existe dans la base de données
    if($req->rowCount() == 1) {
        $donnees = $req->fetch();
        if(isset($_POST['valider'])) {//on vérifie si le formulaire est bien envoyer
            $title = htmlspecialchars($_POST['title']);
            $rubrique = nl2br(htmlspecialchars($_POST['rubrique']));
            $emission = nl2br(htmlspecialchars($_POST['emission']));
            $intervue = nl2br(htmlspecialchars($_POST['intervue']));
            if(!empty($title) AND !empty($rubrique) AND !empty($emission) AND !empty($intervue)) {//on vérifie si les champs sont bien remplis
                $req = $conn->prepare('UPDATE podcast SET title = ?, rubrique = ?, emission = ?, intervue = ? WHERE id = ?');
                $req->execute(array($title, $rubrique, $emission, $intervue, $getid));
                header('Location: upload_podcast.php');
            } else {
                echo "Veuillez remplir tous les champs";
            }
        }
    } else {
        echo "Cet article n'existe pas";
    }
} else {
    echo "L'id n'est pas recuperé";
}  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'article</title>
</head>
<body>
    <form method="POST" action="" align="center">
        <input type="text" name="title" value="<?= $donnees['title']; ?>">
        <br>
        <textarea name="rubrique"><?= $donnees['rubrique']; ?></textarea>
        <br>
        <textarea name="emission"><?= $donnees['emission']; ?></textarea>
        <br>
        <textarea name="intervue"><?= $donnees['intervue']; ?></textarea>
        <br>
        <input type="submit" name="valider">
</body>
</html>