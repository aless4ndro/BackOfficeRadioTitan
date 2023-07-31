<?php
session_start();
include('config.php');
require('permission_admin.php');

// Vérifie si le paramètre 'id' est défini et non vide
if(isset($_GET['id']) && trim($_GET['id']) != '') {// trim() supprime les espaces en début et fin de chaîne
    $getid = $_GET['id'];// On récupère l'id de l'article envoyé dans l'URL

    $req = $conn->prepare('SELECT * FROM articles WHERE id = ?');// On prépare la requête pour vérifier si l'article existe
    $req->execute(array($getid));// On exécute la requête
    if($req->rowCount() == 1) {// Si l'article existe
        $donnees = $req->fetch();// On récupère les données de l'article
        if(isset($_POST['valider'])) {// Si le formulaire a été envoyé
            $titre = htmlspecialchars($_POST['titre']);// On récupère les données du formulaire
            $contenu = nl2br(htmlspecialchars($_POST['contenu']));// nl2br() insère un retour à la ligne HTML (<br /> ou <br>) avant chaque nouvelle ligne
            if(!empty($titre) AND !empty($contenu)) {// Si les données ne sont pas vides
                $req = $conn->prepare('UPDATE articles SET titre = ?, contenu = ? WHERE id = ?');// On prépare la requête pour modifier l'article
                $req->execute(array($titre, $contenu, $getid));// On exécute la requête
                header('Location: articles.php');// On redirige l'utilisateur vers la page des articles
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