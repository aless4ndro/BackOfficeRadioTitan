<?php
session_start();
include('config.php');

if(!$_SESSION['pseudo']) {
    header('Location: connexion.php');
}

if(isset($_POST['valider'])) {
    $titre = htmlspecialchars($_POST['titre']);
    $contenu = nl2br(htmlspecialchars($_POST['contenu'])) ;
    if(!empty($titre) AND !empty($contenu)) {
        $req = $conn->prepare('INSERT INTO articles(titre, contenu) VALUES(?, ?)');
        $req->execute(array($titre, $contenu));
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