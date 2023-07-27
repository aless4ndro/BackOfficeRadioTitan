<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('config.php');

$error_file = fopen("errors.txt", "w");

if (!isset($_SESSION['pseudo']) || empty($_SESSION['pseudo'])) {
    header('Location: connexion.php');
    exit;
}

$images_target_dir = "upload_images/";
if (!file_exists($images_target_dir) || !is_writable($images_target_dir)) {
    mkdir($images_target_dir, 0755, true);
}

if (isset($_POST['submit'])) {
    $albumTitle = htmlspecialchars($_POST['album_title']);
    $albumCover = htmlspecialchars($_FILES['album_cover']['name']);
    $albumCoverTmp = $_FILES['album_cover']['tmp_name'];
    $albumCoverSize = $_FILES['album_cover']['size'];
    $albumCoverError = $_FILES['album_cover']['error'];

    $albumCoverParts = explode('.', $albumCover);
    $albumCoverExt = strtolower(end($albumCoverParts));
    $allowedImage = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($albumCoverExt, $allowedImage)) {
        if ($albumCoverError === 0) {
            if ($albumCoverSize < 2000000) {
                $albumCoverNameNew = uniqid('', true) . "." . $albumCoverExt;
                $albumCoverDestination = $images_target_dir . $albumCoverNameNew;
                move_uploaded_file($albumCoverTmp, $albumCoverDestination);

                $req = $conn->prepare('INSERT INTO albums (title, cover_image_path) VALUES (?, ?)');
                $req->execute([$albumTitle, $albumCoverDestination]);

                $albumId = $conn->lastInsertId();

                if(isset($_POST['audio_id']) && is_array($_POST['audio_id'])) {
                    foreach ($_POST['audio_id'] as $audioId) {
                        $req = $conn->prepare('UPDATE audio SET album_id = ? WHERE id = ?');
                        $req->execute([$albumId, $audioId]);
                    }
                }

                header('Location: ./Back-end/index.php');
                exit;
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "Error while uploading the file!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }
}
fclose($error_file);
?>



<?php
include('./include/header.php');
include('./include_sidebar/index.php');
include('./include_breadcrump/index.php');
?>

<section class="vh-100 px-3 px-md-5 mx-auto" style="background-color: #eee;">
    <div class="container-fluid h-100">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12 col-xl-11">
                <!-- Supprimer ou réduire la marge supérieure négative -->
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Création Album</p>

                                <form method="POST" action="creation_album.php" enctype="multipart/form-data" class="mx-1 mx-md-4">

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label for="albumTitle">Titre de l'album</label>
                                            <input type="text" class="form-control" id="albumTitle" name="album_title" required>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label for="albumCover">Image de couverture</label>
                                            <input type="file" class="form-control-file" id="albumCover" name="album_cover" required>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <label for="audioId">Audios à lier</label>
                                <select class="form-control" id="audioId" name="audio_id[]" multiple>
                                    <?php
                                    $req = $conn->query('SELECT * FROM audio WHERE album_id IS NULL');
                                    while ($donnees = $req->fetch()) {
                                    ?>
                                        <option value="<?= $donnees['id']; ?>">
                                            <?= htmlspecialchars($donnees['title']); ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                            <button type="submit" name="submit" class="btn btn-primary">Créer</button>
                        </div>
                        </form>
                    </div>

                    <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Titre</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Image de couverture</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $req = $conn->query('SELECT * FROM albums');
                                while ($album = $req->fetch()) {
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($album['title']); ?></td>
                                        <td><?= htmlspecialchars($album['description']); ?></td>
                                        <td><img src="<?= htmlspecialchars($album['cover_image_path']); ?>" class="img-fluid" alt="Image de couverture"></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp" class="img-fluid" alt="Sample image" style="margin-top: -50px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include('./include/footer.php'); ?>