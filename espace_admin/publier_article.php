<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('config.php');

if (!$_SESSION['pseudo']) {
    header('Location: connexion.php');
}

if (isset($_POST['valider'])) {
    $titre = htmlspecialchars($_POST['titre']);
    $contenu = nl2br(htmlspecialchars($_POST['contenu']));
    $id_categorie = htmlspecialchars($_POST['id_categorie']);
    if (!empty($titre) and !empty($contenu) and !empty($id_categorie)) {
        $req = $conn->prepare('INSERT INTO articles(titre, contenu, id_categorie) VALUES(?, ?, ?)');
        $req->execute(array($titre, $contenu, $id_categorie));
        echo "Votre article a bien été publié";
        
    } else {
        echo "Veuillez remplir tous les champs";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier un Article</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
    tinymce.init({
        selector: 'textarea[name=contenu]'
    });
    </script>
</head>

<body>
    <div class="container">
        <form method="POST" action="" class="mt-5">
            <div class="form-group">
                <h1>Publier un Article</h1>
                <label for="titre">Titre</label>
                <input type="text" name="titre" placeholder="Titre" class="form-control" id="titre">
            </div>
            <div class="form-group">
                <label for="contenu">Contenu</label>
                <textarea name="contenu" placeholder="Contenu" class="form-control" id="contenu"></textarea>
            </div>
            <div class="form-group">
                <label for="id_categorie">Categorie</label>
                <select name="id_categorie" class="form-control" id="id_categorie">
                    <?php
                    $categories = $conn->query("SELECT * FROM categories");
                    while ($categorie = $categories->fetch()) {
                        echo "<option value='" . $categorie['id_categorie'] . "'>" . $categorie['nom_categorie'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="valider" class="btn btn-primary">Submit</button>
            <a href="./Back-end/index.php" class="btn btn-secondary">Retour</a>
        </form>
    </div>
</body>



    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
