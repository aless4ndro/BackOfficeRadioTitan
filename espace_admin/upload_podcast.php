<?php
session_start();
include('config.php');
if (!$_SESSION['pseudo']) {
    header('Location: connexion.php');
}

if (isset($_POST['submit'])) {
    $rubrique = $_POST['rubrique'];
    $emission = $_POST['emission'];
    $intervue = $_POST['intervue'];
    $podcast_title = $_POST['podcast_title']; ///$_POST — HTTP POST variables
    $podcast_file = $_FILES['podcast_file']['name']; //name — Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
    $podcast_file_tmp = $_FILES['podcast_file']['tmp_name']; //tmp_name — Le nom du fichier sur le serveur où le fichier téléchargé a été stocké.
    $podcast_file_size = $_FILES['podcast_file']['size']; //size — La taille en octets du fichier uploadé.
    $podcast_file_error = $_FILES['podcast_file']['error']; //error — Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.
    $podcast_file_type = $_FILES['podcast_file']['type']; //type — Le type du fichier. Par exemple, cela peut être « image/png ».

    $podcast_file_ext = explode('.', $podcast_file); //explode — Coupe une chaîne en segments
    $podcast_file_actual_ext = strtolower(end($podcast_file_ext)); //strtolower — Renvoie une chaîne en minuscules

    $allowed = array('mp3', 'wav', 'ogg'); //array — Crée un tableau, avec les valeurs passées en paramètres, comme éléments qui rapresente les extensions autorisées

    if (in_array($podcast_file_actual_ext, $allowed)) {
        if ($podcast_file_error === 0) { //0 = pas d'erreur
            if ($podcast_file_size < 10000000) { //10MB
                $podcast_file_name_new = uniqid('', true) . "." . $podcast_file_actual_ext; //uniqid — Génère un identifiant unique basé sur l'heure courante en microsecondes et sur un paramètre binaire optionnel, qui permet de le rendre encore plus unique parceque est important que le nom du fichier soit unique
                $podcast_file_destination = 'uploads/' . $podcast_file_name_new; //chemin de destination, true = si le dossier n'existe pas, il sera créé
                move_uploaded_file($podcast_file_tmp, $podcast_file_destination); //move_uploaded_file — Déplace un fichier téléchargé
                $req = $conn->prepare('INSERT INTO podcast (title, file_path, rubrique, emission, intervue) VALUES (?, ?, ?, ?, ?)');
                $req->execute([$podcast_title, $podcast_file_destination, $rubrique, $emission, $intervue]); //execute — Exécute une requête préparée

                header('Location: index.php');
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "Error: " . $podcast_file_error;
        }
    } else {
        echo "You cannot upload files of this type!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload Podcast</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Incluez la bibliothèque Font Awesome dans l'en-tête de votre document -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="./medias/radiotitanback-end.png" alt="logo" style="width: 105px; border-radius: 50%"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li>
                    <a class="nav-link" href="membres.php">
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
                    <a class="nav-link" href="afficher_articles.php">
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



    <div class="container mt-5">
        <form method="POST" action="upload_podcast.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="podcast_file" class="form-label">Podcast File:</label>
                <input type="file" name="podcast_file" id="podcast_file" class="form-control">
            </div>
            <div class="mb-3">
                <label for="podcast_title" class="form-label">Podcast Title:</label>
                <input type="text" name="podcast_title" id="podcast_title" class="form-control">
            </div>
            <div class="mb-3">
                <label for="rubrique" class="form-label">Rubrique:</label>
                <input type="text" name="rubrique" id="rubrique" class="form-control">
            </div>
            <div class="mb-3">
                <label for="emission" class="form-label">Emission:</label>
                <input type="text" name="emission" id="emission" class="form-control">
            </div>
            <div class="mb-3">
                <label for="intervue" class="form-label">Intervue:</label>
                <textarea name="intervue" id="intervue" class="form-control"></textarea>
            </div>
            <input type="submit" name="submit" value="Upload" class="btn btn-primary">

            <?php
            $req = $conn->query('SELECT * FROM podcast');
            while ($donnees = $req->fetch()) {
                echo '<div class="card mb-4">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $donnees['title'] . '</h5>';
                echo '<p class="card-text">Rubrique: ' . $donnees['rubrique'] . '</p>';
                echo '<p class="card-text">Emission: ' . $donnees['emission'] . '</p>';
                echo '<audio controls>';
                echo '<source src="' . $donnees['file_path'] . '" type="audio/mpeg">';
                echo '</audio>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>

</html>




<!--$_FILES pour accéder au fichier téléchargé et le déplacer à l'endroit désiré sur le serveur
Ce script tente de déplacer le fichier uploadé vers le répertoire "uploads" sur le serveur. Si le fichier est déplacé avec succès, il insère une nouvelle ligne dans la table "podcasts" de la base de données avec le titre du podcast et le chemin du fichier.


Modifier le fichier php.ini et augmenter la valeur de upload_max_filesize et post_max_size. Par exemple, pour augmenter la limite à 100M :

upload_max_filesize = 100M
post_max_size = 100M
Ensuite, vous devrez redémarrer votre serveur web pour que les modifications prennent effet.
-->