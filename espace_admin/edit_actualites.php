<?php

if (session_status() == PHP_SESSION_NONE) {
    // Si aucune session n'est active, on la démarre
    session_start();
}

include('./config.php');

if (!isset($_SESSION['pseudo']) || empty($_SESSION['pseudo'])) {
    header('Location: connexion.php');
    exit;
}

$titre = $contenu = "";
$errors = array();

if (isset($_POST['submit'])) {
    $titre = htmlspecialchars($_POST['titre']);
    $contenu = htmlspecialchars($_POST['contenu']);

    // Vérifie si le titre ou le contenu sont vides
    if (empty($titre) || empty($contenu)) {
        array_push($errors, "Titre et contenu ne peuvent pas être vides");
    }

    $img_illustration = htmlspecialchars($_FILES['actualites_cover']['name']);
    $imgTmp = $_FILES['actualites_cover']['tmp_name'];
    $imgSize = $_FILES['actualites_cover']['size'];
    $imgError = $_FILES['actualites_cover']['error'];
    $imgExt = strtolower(end(explode('.', $img_illustration)));
    $allowedImage = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($imgExt, $allowedImage)) {
        if ($imgError === 0) {
            if ($imgSize < 1000000) {
                $imgNameNew = uniqid('', true) . "." . $imgExt;
                $imgDestination = 'upload_images/' . $imgNameNew;
                if (move_uploaded_file($imgTmp, $imgDestination)) {
                    $sql = "INSERT INTO actualites (titre, contenu, date, img_illustration) VALUES (:titre, :contenu, :date, :img_illustration)";
                    $stmt = $conn->prepare($sql);
                    $result = $stmt->execute([
                        'titre' => $titre, 
                        'contenu' => $contenu, 
                        'date' => date('Y-m-d H:i:s'), 
                        'img_illustration' => $imgDestination,
                    ]);
                    if (!$result) {
                        array_push($errors, "Erreur d'insertion dans la base de données");
                    } else {
                        header('Location: ./Back-end/index.php'); // redirige vers la page de succès après l'insertion
                        exit;
                    }
                } else {
                    array_push($errors, "Erreur lors du téléchargement du fichier");
                }
            } else {
                array_push($errors, "Le fichier est trop grand");
            }
        } else {
            array_push($errors, "Erreur lors du téléchargement du fichier");
        }
    } else {
        array_push($errors, "Type de fichier non autorisé");
    }
}

// Le reste de votre code HTML et PHP suit ici
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

                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Création Actualités</p>

                                <form method="POST" action="edit_actualites.php" enctype="multipart/form-data" class="mx-1 mx-md-4">

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label for="albumTitle">Titre</label>
                                            <input type="text" name="titre" value=<?php echo $titre; ?>>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label for="albumTitle">Contenu</label>
                                            <input type="text" name="contenu" value=<?php echo $contenu; ?>>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label for="albumCover">Image de couverture</label>
                                            <input type="file" class="form-control-file" id="actualitesCover" name="actualites_cover">
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                            <button type="submit" name="submit" class="btn btn-primary">Créer</button>
                        </div>
                        </form>
                    </div>
                    <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp" class="img-fluid" alt="Sample image" style="margin-top: -50px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include('./include/footer.php'); ?>