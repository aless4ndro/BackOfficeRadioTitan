<?php
session_start();
if(!$_SESSION['pseudo']) {
    header('Location: connexion.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="membres.php">Affichier les membres</a>
    <br>
    <a href="publier_article.php">Publier un article</a>
    <br>
    <a href="articles.php">Affichier tous les articles</a>
    <br>
    <a href="upload_podcast.php">Podcast</a>
    <br>
    <a href="logout.php">Se déconnecter</a>
</body>
</html>