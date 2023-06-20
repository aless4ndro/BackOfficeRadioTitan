<?php
session_start();
include('config.php');

if (!isset($_SESSION['pseudo']) || empty($_SESSION['pseudo'])) {
    header('Location: connexion.php');
    exit;
}

if (isset($_POST['submit'])) {
    $nom_categorie = htmlspecialchars($_POST['nom_categorie']);
    if (!empty($nom_categorie)) {
        $req = $conn->prepare('INSERT INTO categories (nom_categorie) VALUES (?)');
        $req->execute([$nom_categorie]);
        header('Location: index.php');
        exit;
    } else {
        echo "Le champ est vide";
    }
}

?>

<head>
    <title>Ajouter Categorie</title>
</head>

<?php include('./include/header.php') ?>
<div class="container mt-5">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 50vh;">
        <div class="col-md-6">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nom_categorie" class="form-label">Création Categorie</label>
                    <input type="text" name="nom_categorie" id="nom_categorie" class="form-control" required>
                </div>
                <div class="mb-3">
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item">Article</li>
                        <li class="list-group-item">Album</li>
                        <li class="list-group-item">Podcast</li>
                        <li class="list-group-item">Vidéo</li>
                    </ol>
                    <input type="submit" name="submit" value="Ajouter" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>


<?php include('./include/footer.php') ?>