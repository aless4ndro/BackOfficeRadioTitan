<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('config.php');

if(isset($_GET['id']) && trim($_GET['id']) != '') {
    $getid = $_GET['id'];

    $req = $conn->prepare('SELECT * FROM podcast WHERE id = ?');
    $req->execute(array($getid));
    if($req->rowCount() == 1) {
        $donnees = $req->fetch();
        if(isset($_POST['valider'])) {
            $titre = htmlspecialchars($_POST['title']);
            $file_path = htmlspecialchars($_POST['file_path']);
            $rubrique = htmlspecialchars($_POST['rubrique']);
            $emission = htmlspecialchars($_POST['emission']);
            $interview = htmlspecialchars($_POST['interview']);
            $id_categorie = htmlspecialchars($_POST['id_categorie']);

            if(!empty($titre) AND !empty($file_path) AND !empty($rubrique) AND !empty($emission) AND !empty($interview) AND !empty($id_categorie)) {
                $req = $conn->prepare('UPDATE podcasts SET title = ?, file_path = ?, rubrique = ?, emission = ?, interview = ?, id_categorie = ? WHERE id = ?');
                $req->execute(array($titre, $file_path, $rubrique, $emission, $interview, $id_categorie, $getid));
                header('Location: modifier_podcast.php');
            } else {
                echo "Veuillez remplir tous les champs";
            }
        }
    } else {
        echo "Ce podcast n'existe pas";
    }
}

$req = $conn->query('SELECT * FROM podcast');
$podcasts = $req->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Podcast</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <?php foreach($podcasts as $podcast): ?>
        <div class="container mt-4">
            <h2><?= htmlspecialchars($podcast['title']); ?></h2>
            <p><?= nl2br(htmlspecialchars($podcast['file_path'])); ?></p>
            <p><?= nl2br(htmlspecialchars($podcast['rubrique'])); ?></p>
            <p><?= nl2br(htmlspecialchars($podcast['emission'])); ?></p>
            <p><?= nl2br(htmlspecialchars($podcast['intervue'])); ?></p>
            <p><?= nl2br(htmlspecialchars($podcast['id_categorie'])); ?></p>
            <a href="?id=<?= $podcast['id']; ?>" class="btn btn-primary">Modifier ce podcast</a>
        </div>
        <hr>
    <?php endforeach; ?>

    <?php if(isset($_GET['id']) and !empty($_GET['id'])): ?>
        <div class="container mt-4">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Titre" value="<?php echo $donnees['title']; ?>">
                </div>
                <div class="form-group">
                    <label for="file_path">File Path</label>
                    <input type="file" class="form-control" id="file_path" name="file_path" placeholder="File Path">
                </div>
                <div class="form-group">
                    <label for="rubrique">Rubrique</label>
                    <input type="text" class="form-control" id="rubrique" name="rubrique" placeholder="Rubrique" value="<?php echo $donnees['rubrique']; ?>">
                </div>
                <div class="form-group">
                    <label for="emission">Emission</label>
                    <input type="text" class="form-control" id="emission" name="emission" placeholder="Emission" value="<?php echo $donnees['emission']; ?>">
                </div>
                <div class="form-group">
                    <label for="interview">Interview</label>
                    <input type="text" class="form-control" id="intervue" name="intervue" placeholder="Interview" value="<?php echo $donnees['intervue']; ?>">
                </div>
                <div class="form-group">
                    <label for="id_categorie">ID Categorie</label>
                    <input type="text" class="form-control" id="id_categorie" name="id_categorie" placeholder="ID Categorie" value="Categorie<?php echo $donnees['id_categorie']; ?>">
                </div>
                <button type="submit" class="btn btn-primary" name="valider">Valider</button>
            </form>
        </div>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
