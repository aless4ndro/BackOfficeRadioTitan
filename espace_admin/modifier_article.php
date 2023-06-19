<?php
session_start();
include('config.php');
require('permission_admin.php');

// Vérifie si le paramètre 'id' est défini et non vide
if(isset($_GET['id']) && trim($_GET['id']) != '') {
    $getid = $_GET['id'];

    $req = $conn->prepare('SELECT * FROM articles WHERE id = ?');
    $req->execute(array($getid));
    if($req->rowCount() == 1) {
        $donnees = $req->fetch();
        if(isset($_POST['valider'])) {
            $titre = htmlspecialchars($_POST['titre']);
            $contenu = nl2br(htmlspecialchars($_POST['contenu']));
            if(!empty($titre) AND !empty($contenu)) {
                $req = $conn->prepare('UPDATE articles SET titre = ?, contenu = ? WHERE id = ?');
                $req->execute(array($titre, $contenu, $getid));
                header('Location: articles.php');
            } else {
                echo "Veuillez remplir tous les champs";
            }
        }
    } else {
        echo "Cet article n'existe pas";
    }
}

$req = $conn->query('SELECT * FROM articles');
while ($donnees = $req->fetch()) {
    echo '<h2>'.htmlspecialchars($donnees['titre']).'</h2>';
    echo '<p>'.nl2br(htmlspecialchars($donnees['contenu'])).'</p>';
    echo '<a href="modifier_article.php?id='.$donnees['id'].'">Modifier cet article</a>';
    echo '<hr>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'article</title>
    <!-- Inclure les fichiers CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <?php foreach($articles as $article): ?>
        <div class="container mt-4">
            <h2><?= htmlspecialchars($article['titre']); ?></h2>
            <p><?= nl2br(htmlspecialchars($article['contenu'])); ?></p>
            <a href="?id=<?= $article['id']; ?>" class="btn btn-primary">Modifier cet article</a>
        </div>
        <hr>
    <?php endforeach; ?>

    <?php if(isset($_GET['id']) and !empty($_GET['id'])): ?>
        <!-- Formulaire de modification de l'article avec les classes Bootstrap -->
        <div class="container mt-4">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre" value="<?php echo $donnees['titre']; ?>">
                </div>
                <div class="form-group">
                    <label for="contenu">Contenu</label>
                    <textarea class="form-control" id="contenu" name="contenu" placeholder="Contenu"><?php echo $donnees['contenu']; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="valider">Valider</button>
            </form>
        </div>
    <?php endif; ?>

    <!-- Inclure les fichiers JS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>


<!--Donc, en résumé, cette page peut être utilisée à la fois pour afficher une liste de tous les articles avec des liens pour les modifier, et pour afficher et traiter un formulaire de modification pour un article spécifique.--