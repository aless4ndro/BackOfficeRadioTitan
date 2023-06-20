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
    $id_categorie = $_POST['id_categorie'];
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
                $req = $conn->prepare('INSERT INTO podcast (title, file_path, rubrique, emission, intervue, id_categorie) VALUES (?, ?, ?, ?, ?, ?)');
                $req->execute([$podcast_title, $podcast_file_destination, $rubrique, $emission, $intervue, $id_categorie]); //execute — Exécute une requête préparée

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
//include — Inclut et exécute le fichier spécifié en argument
include('./include/header.php');
?>

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
            <select name="id_categorie">
            <?php
            $categories = $conn->query("SELECT * FROM categories");
            while ($categorie = $categories->fetch()) {
                echo "<option value='" . $categorie['id_categorie'] . "'>" . $categorie['nom_categorie'] . "</option>";
            }
            ?>

            <br>
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
<?php include('./include/footer.php'); ?>




<!--$_FILES pour accéder au fichier téléchargé et le déplacer à l'endroit désiré sur le serveur
Ce script tente de déplacer le fichier uploadé vers le répertoire "uploads" sur le serveur. Si le fichier est déplacé avec succès, il insère une nouvelle ligne dans la table "podcasts" de la base de données avec le titre du podcast et le chemin du fichier.


Modifier le fichier php.ini et augmenter la valeur de upload_max_filesize et post_max_size. Par exemple, pour augmenter la limite à 100M :

upload_max_filesize = 100M
post_max_size = 100M
Ensuite, vous devrez redémarrer votre serveur web pour que les modifications prennent effet.
-->