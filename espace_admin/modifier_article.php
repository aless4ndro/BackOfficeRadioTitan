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


include('include/header.php');
include('include_sidebar/index.php');
include('include_breadcrump/index.php');

$req = $conn->query('SELECT * FROM articles');
?>

<div class="container mt-4">
    <?php while ($article = $req->fetch()): ?>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($article['titre']) ?></h5>
                <p class="card-text"><?= nl2br(htmlspecialchars($article['contenu'])) ?></p>
                <a href="modifier_article.php?id=<?= $article['id'] ?>" class="btn btn-primary">Modifier cet article</a>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php if(isset($_GET['id']) and !empty($_GET['id'])): ?>
    <!-- Formulaire de modification de l'article avec les classes Bootstrap -->
    <div class="container mt-4">
        <form method="POST" action="">
            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre">
            </div>
            <div class="mb-3">
                <label for="contenu" class="form-label">Contenu</label>
                <textarea class="form-control" id="contenu" name="contenu" placeholder="Contenu"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="valider">Valider</button>
        </form>
    </div>
<?php endif; ?>

<?php include('include/footer.php'); ?>



<!--Donc, en résumé, cette page peut être utilisée à la fois pour afficher une liste de tous les articles avec des liens pour les modifier, et pour afficher et traiter un formulaire de modification pour un article spécifique.--