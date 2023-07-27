<?php
session_start();
include('config.php');

// Vérifie si le paramètre 'id' est défini et non vide
if(isset($_GET['id']) && trim($_GET['id']) != '') {
    $getid = $_GET['id'];

    $req = $conn->prepare('SELECT * FROM audio WHERE id = ?');
    $req->execute(array($getid));
    if($req->rowCount() == 1) {
        $donnees = $req->fetch();
        if(isset($_POST['valider'])) {
            $titre = htmlspecialchars($_POST['title']);
            $date = htmlspecialchars($_POST['date']);
            $description = nl2br(htmlspecialchars($_POST['description']));
            $code_color = htmlspecialchars($_POST['code_color']);

            if(isset($_FILES['img_illustration']) && $_FILES['img_illustration']['error'] == 0){
                $img_illustration = $_FILES['img_illustration']['name'];
                $img_illustration_tmp = $_FILES['img_illustration']['tmp_name'];
                $img_illustration_ext = strtolower(end(explode('.', $img_illustration)));
                $allowed_image = array('jpg', 'jpeg', 'png', 'gif');
                if (in_array($img_illustration_ext, $allowed_image)) {
                    $img_illustration_name_new = uniqid('', true) . "." . $img_illustration_ext;
                    $img_illustration_destination = 'upload_images/' . $img_illustration_name_new;
                    move_uploaded_file($img_illustration_tmp, $img_illustration_destination);
                    $img_illustration = $img_illustration_destination;
                } else {
                    echo "Vous ne pouvez pas télécharger des fichiers de ce type !";
                    exit;
                }
            } else {
                $img_illustration = $donnees['img_illustration'];
            }

            if(!empty($titre) AND !empty($date) AND !empty($description) AND !empty($code_color) AND !empty($img_illustration)) {
                $req = $conn->prepare('UPDATE audio SET title = ?, date = ?, description = ?, code_color = ?, img_illustration = ? WHERE id = ?');
                $req->execute(array($titre, $date, $description, $code_color, $img_illustration, $getid));
                header('Location: modifier_audio.php');
            } else {
                echo "Veuillez remplir tous les champs";
            }
        }
    } else {
        echo "Cet article n'existe pas";
    }
}

$req = $conn->query('SELECT * FROM audio');
?>

<head> 
    <title>Modifier l'article</title>
</head>

<?php
include('include/header.php');
include('include_sidebar/index.php');
include('include_breadcrump/index.php')
?>

    <?php while ($donnees = $req->fetch()): ?>
        <div class="container mt-4">
            <h2><?= htmlspecialchars($donnees['title']); ?></h2>
            <p><?= nl2br(htmlspecialchars($donnees['date'])); ?></p>
            <p><?= nl2br(htmlspecialchars($donnees['description'])); ?></p>
            <p><?= nl2br(htmlspecialchars($donnees['code_color'])); ?></p>
            <img src="<?= $donnees['img_illustration']; ?>" alt="Image d'illustration" width="100px">
            <a href="?id=<?= $donnees['id']; ?>" class="btn btn-primary">Modifier cet audio</a>
        </div>
        <hr>
    <?php endwhile; ?>

    <?php if(isset($_GET['id']) and !empty($_GET['id'])): ?><!-- Si le paramètre 'id' est défini et non vide -->
        <!-- Formulaire de modification de l'article avec les classes Bootstrap -->
        <div class="container mt-4">
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Titre" value="<?php echo $donnees['title']; ?>">
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" id="date" name="date" placeholder="Date" value="<?php echo $donnees['date']; ?>">
                </div>
                <div class="form-group">
                    <label for="contenu">Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="description"><?php echo $donnees['description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="code_color">Code couleur</label>
                    <input type="color" class="form-control" id="code_color" name="code_color" placeholder="Code couleur" value="<?php echo $donnees['code_color']; ?>">
                </div>
                <div class="form-group">
                    <label for="img_illustration">Image d'illustration</label>
                    <input type="file" class="form-control" id="img_illustration" name="img_illustration" placeholder="Image d'illustration">
                    <img src="<?= $donnees['img_illustration']; ?>" alt="Image actuelle d'illustration" width="100px">
                </div>
                <button type="submit" class="btn btn-primary" name="valider">Valider</button>
            </form>
        </div>
    <?php endif; ?>
<?php include('include/footer.php'); ?>
