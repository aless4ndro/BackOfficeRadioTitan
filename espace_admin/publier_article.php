<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('config.php');

if(!$_SESSION['pseudo']) {
    header('Location: connexion.php');
}

if(isset($_POST['valider'])) {
    $titre = htmlspecialchars($_POST['titre']);
    $contenu = nl2br(htmlspecialchars($_POST['contenu']));
    $id_categorie = htmlspecialchars($_POST['id_categorie']);
    if(!empty($titre) AND !empty($contenu) AND !empty($id)) {
        $req = $conn->prepare('INSERT INTO articles(titre, contenu, id_categorie) VALUES(?, ?, ?)');
        $req->execute(array($titre, $contenu, $id_categorie));
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plublier un Article</title>
</head>
<body>
    <form method="POST" action="" align="center">
        <input type="text" name="titre" placeholder="Titre">
        <br>
        <textarea name="contenu" placeholder="Contenu"></textarea>
        <br>
        <input type="submit" name="valider">
</body>
</html>