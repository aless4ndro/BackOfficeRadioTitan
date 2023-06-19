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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier Categorie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css">
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>
</html>

<!--Dans ce code, une liste de toutes les catégories est affichée avec un bouton pour modifier chaque catégorie. Lorsque vous cliquez sur le bouton de modification d'une catégorie, vous êtes redirigé vers la même page,
mais avec l'ID de la catégorie en paramètre GET dans l'URL. Si cet ID est défini et n'est pas vide,
alors le formulaire de modification de la catégorie apparaît avec le nom de la catégorie déjà rempli. Si vous soumettez le formulaire, le nom de la catégorie sera mis à jour dans la base de données.-->