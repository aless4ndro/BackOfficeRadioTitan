<?php
session_start();
include('config.php');
if(!$_SESSION['pseudo']) {
    header('Location: connexion.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Espace admin</title>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>
<body>
    <h1>Bienvenue <?= $_SESSION['pseudo']; ?></h1>
    <p><a href="logout.php" style="color:red; text-decoration: none;">Se déconnecter</a></p>
    <!-- Afficher un lien pour créer un nouveau membre -->
    <p><a href="creation_membre.php" style="color:green; text-decoration: none;">Créer un nouveau membre</a></p>

    <!-- Afficher tous les membres -->
    <?php
    $req = $conn->query('SELECT * FROM membres');
    while($donnees = $req->fetch()) {
        ?>
        <p><?= $donnees['pseudo']; ?> (<?= $donnees['role']; ?>) 
        <?php if ($donnees['pseudo'] !== $_SESSION['pseudo']) { ?>// Compare this line to the next line
            <a href="delete.php?id=<?= $donnees['id']; ?>" style="color:red; text-decoration: none;"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <i class="fas fa-trash-alt">
</i></a>
        <?php } ?>
        </p>

        <?php
    }
    ?>
</body>
</html>