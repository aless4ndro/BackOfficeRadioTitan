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
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="membres.php">Affichier les membres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="publier_article.php">Publier un article</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="articles.php">Affichier tous les articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="upload_podcast.php">Podcast</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
