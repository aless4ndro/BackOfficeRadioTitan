<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Incluez la bibliothèque Font Awesome dans l'en-tête de votre document -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="./medias/radiotitanback-end.png" alt="logo" style="width: 105px; border-radius: 50%"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li>
                    <a class="nav-link" href="creation_membre.php">
                        <i class="fas fa-users"></i>
                        Membres
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="publier_article.php">
                        <i class="fas fa-edit"></i>
                        Publier un article
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="articles.php">
                        <i class="fas fa-book"></i>
                        Afficher les articles
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="upload_podcast.php">
                        <i class="fas fa-microphone"></i>
                        Upload Podcast
                    </a>
                </li>
                </ul>
            </div>
        </div>
    </nav>