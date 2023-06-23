<?php
session_start();
include('config.php');

if (!isset($_SESSION['pseudo']) || empty($_SESSION['pseudo'])) {
    header('Location: connexion.php');
    exit;
}

if(isset($_GET['id']) && trim($_GET['id']) != '') {
    $getid = intval($_GET['id']);

    $req = $conn->prepare('SELECT * FROM categories WHERE id_categorie = ?');
    $req->execute(array($getid));
    if($req->rowCount() == 1) {
        $donnees = $req->fetch();
        if(isset($_POST['submit'])) {
            $nom_categorie = htmlspecialchars($_POST['nom_categorie']);

            if(!empty($nom_categorie)) {
                $req = $conn->prepare('UPDATE categories SET nom_categorie = ? WHERE id_categorie = ?');
                $req->execute(array($nom_categorie, $getid));
                header('Location: edit_categorie.php');
            } else {
                echo "Veuillez remplir tous les champs";
            }
        }
    } else {
        echo "Cette categorie n'existe pas";
    }
}

$req = $conn->query('SELECT * FROM categories');
$categories = $req->fetchAll();
include('./include/header.php')
?>

<head>
    <title>Modifier Categorie</title>
</head>
<body>
    <div class="container mt-5">
        <?php foreach($categories as $categorie): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($categorie['nom_categorie']); ?></h5>
                    <a href="?id=<?= $categorie['id_categorie']; ?>" class="btn btn-primary">Modifier cette categorie</a>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if(isset($_GET['id']) and !empty($_GET['id'])): ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nom_categorie">Nom Categorie</label>
                    <input type="text" class="form-control" id="nom_categorie" name="nom_categorie" placeholder="Nom Categorie" value="<?php echo $donnees['nom_categorie']; ?>">
                </div>
                <button type="submit" class="btn btn-primary mt-3" name="submit">Modifier</button>
            </form>
        <?php endif; ?>
    </div>
<?php include('./include/footer.php') ?>

<!--Dans ce code, une liste de toutes les catégories est affichée avec un bouton pour modifier chaque catégorie. Lorsque vous cliquez sur le bouton de modification d'une catégorie, vous êtes redirigé vers la même page,
mais avec l'ID de la catégorie en paramètre GET dans l'URL. Si cet ID est défini et n'est pas vide,
alors le formulaire de modification de la catégorie apparaît avec le nom de la catégorie déjà rempli. Si vous soumettez le formulaire, le nom de la catégorie sera mis à jour dans la base de données.-->