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
    $title = htmlspecialchars($_POST['title']);
    $date = $_POST['date'];
    $description = htmlspecialchars($_POST['description']);
    $code_color = $_POST['code_color'];
    $id_categorie = intval($_POST['id_categorie']);

    // Processing the album file
    $album_file = $_FILES['album_file']['name'];
    $album_file_tmp = $_FILES['album_file']['tmp_name'];
    $album_file_size = $_FILES['album_file']['size'];
    $album_file_error = $_FILES['album_file']['error'];
    $album_file_ext = strtolower(end(explode('.', $album_file)));
    $allowed_album = array('mp3', 'wav', 'ogg');

    // Processing the image file
    $img_illustration = $_FILES['img_illustration']['name'];
    $img_illustration_tmp = $_FILES['img_illustration']['tmp_name'];
    $img_illustration_size = $_FILES['img_illustration']['size'];
    $img_illustration_error = $_FILES['img_illustration']['error'];
    $img_illustration_ext = strtolower(end(explode('.', $img_illustration)));
    $allowed_image = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($album_file_ext, $allowed_album) && in_array($img_illustration_ext, $allowed_image)) {
        if ($album_file_error === 0 && $img_illustration_error === 0) {
            if ($album_file_size < 10000000 && $img_illustration_size < 1000000) {
                $album_file_name_new = uniqid('', true) . "." . $album_file_ext;
                $album_file_destination = 'upload_albums/' . $album_file_name_new;
                move_uploaded_file($album_file_tmp, $album_file_destination);

                $img_illustration_name_new = uniqid('', true) . "." . $img_illustration_ext;
                $img_illustration_destination = 'upload_images/' . $img_illustration_name_new;
                move_uploaded_file($img_illustration_tmp, $img_illustration_destination);

                $req = $conn->prepare('INSERT INTO albums (title, date, description, code_color, img_illustration, file_path, id_categorie) VALUES (?, ?, ?, ?, ?, ?, ?)');
                $req->execute([$title, $date, $description, $code_color, $img_illustration_destination, $album_file_destination, $id_categorie]);

                header('Location: index.php');
                exit;
            } else {
                echo "Your file or image is too big!";
            }
        } else {
            echo "Error while uploading the file or image!";
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
                <label for="title" class="form-label">Titre:</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date:</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="code_color" class="form-label">Code couleur:</label>
                <input type="color" name="code_color" id="code_color" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="img_illustration" class="form-label">Image d'illustration :</label>
                <input type="file" name="img_illustration" id="img_illustration" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="album_file" class="form-label">Fichier album :</label>
                <input type="file" name="album_file" id="album_file" class="form-control" required>
            </div>
            <div class="mb-3">
                <select name="id_categorie">
                    <?php
                    $categories = $conn->query("SELECT * FROM categories");
                    while ($categorie = $categories->fetch()) {
                        echo "<option value='" . $categorie['id_categorie'] . "'>" . $categorie['nom_categorie'] . "</option>";
                    }
                    ?>
                </select>

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