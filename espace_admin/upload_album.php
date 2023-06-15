<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('config.php');

if (!isset($_SESSION['pseudo']) || empty($_SESSION['pseudo'])) {
    header('Location: connexion.php');
    exit;
}

if (isset($_POST['submit'])) {
    $album_title = $_POST['album_title'];
    $rubrique = $_POST['rubrique'];
    $emission = $_POST['emission'];
    $intervue = $_POST['intervue'];
    $id_categorie = $_POST['id_categorie'];
    
    $album_file = $_FILES['album_file']['name'];
    $album_file_tmp = $_FILES['album_file']['tmp_name'];
    $album_file_size = $_FILES['album_file']['size'];
    $album_file_error = $_FILES['album_file']['error'];
    $album_file_type = $_FILES['album_file']['type'];

    $album_file_ext = explode('.', $album_file);
    $album_file_actual_ext = strtolower(end($album_file_ext));

    $allowed = array('mp3', 'wav', 'ogg');

    if (in_array($album_file_actual_ext, $allowed)) {
        if ($album_file_error === 0) {
            if ($album_file_size < 10000000) {
                $album_file_name_new = uniqid('', true) . "." . $album_file_actual_ext;
                $album_file_destination = 'uploads/' . $album_file_name_new;
                move_uploaded_file($album_file_tmp, $album_file_destination);
                $req = $conn->prepare('INSERT INTO albums (title, file_path, rubrique, emission, intervue, id_categorie) VALUES (?, ?, ?, ?, ?, ?)');
                $req->execute([$album_title, $album_file_destination, $rubrique, $emission, $intervue, $id_categorie]);

                header('Location: index.php');
                exit;
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "Error: " . $album_file_error;
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
    <title>Upload album</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <div class="container mt-5">
        <form method="POST" action="upload_album.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="album_file" class="form-label">album File:</label>
                <input type="file" name="album_file" id="album_file" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="album_title" class="form-label">album Title:</label>
                <input type="text" name="album_title" id="album_title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="rubrique" class="form-label">Rubrique:</label>
                <input type="text" name="rubrique" id="rubrique" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="emission" class="form-label">Emission:</label>
                <input type="text" name="emission" id="emission" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="intervue" class="form-label">Intervue:</label>
                <textarea name="intervue" id="intervue" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="id_categorie" class="form-label">Category ID:</label>
                <input type="text" name="id_categorie" id="id_categorie" class="form-control" required>
            </div>
            <input type="submit" name="submit" value="Upload" class="btn btn-primary">
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