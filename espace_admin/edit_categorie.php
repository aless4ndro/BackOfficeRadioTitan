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

if(isset($_POST['submit'])) {
    $nom_categorie = htmlspecialchars($_POST['nom_categorie']);
    if(!empty($nom_categorie)) {
        $req = $conn->prepare('INSERT INTO categories (nom_categorie) VALUES (?)');
        $req->execute([$nom_categorie]);
        header('Location: index.php');
        exit;
    } else {
        echo "Le champ est vide";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ajouter Categorie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <div class="container mt-5">
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nom_categorie" class="form-label">Nom Categorie:</label>
                <input type="text" name="nom_categorie" id="nom_categorie" class="form-control" required>
            </div>
            <input type="submit" name="submit" value="Ajouter" class="btn btn-primary">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>

</html>
