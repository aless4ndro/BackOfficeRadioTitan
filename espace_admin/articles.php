<?php
session_start();
include('config.php');
if (!$_SESSION['pseudo']) {
    header('Location: connexion.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichier les articles</title>
</head>

<body>
    <?php
    $req = $conn->query('SELECT * FROM articles');
    while ($donnees = $req->fetch()) { //fetch() fetches the next row from a result set
    ?>
        <div class="article" style="border: 1px solid black;">
            <h2><?= $donnees['titre']; ?></h2>
            <p><?= $donnees['contenu']; ?></p>
            <a href="supprime_article.php?id=<?= $donnees['id']; ?>">
                <button style="color:red; text-decoration: none;">Supprimé l'article</button>
            </a>
            <a href="modifier_article.php?id=<?= $donnees['id']; ?>">
                <button style="color:red; text-decoration: none;">Modifié l'article</button>
            </a>
            <a href="upload_podcast.php">
                <button style="color:red; text-decoration: none;">Upload un podcast</button>
            </a>

        </div>
        <br>
    <?php
    }
    ?>
</body>

</html>