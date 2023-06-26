<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('config.php');

if (!isset($_SESSION['pseudo'])) {
    header('Location: connexion.php');
    exit();
}

require_once __DIR__ . '/vendor/autoload.php';

$titre = '';
$contenu = '';
$heure = '';
$id_categorie = '';
$date = '';
$eventNumber = '';

if (isset($_POST['valider'])) {
    $titre = htmlspecialchars($_POST['titre']);
    $contenu = $_POST['contenu'];
    $heure = htmlspecialchars($_POST['heure']);
    $id_categorie = htmlspecialchars($_POST['id_categorie']);
    $date = $_POST['date'];




    $config = HTMLPurifier_Config::createDefault();
    $config->set('HTML.AllowedElements', array('img'));
    $config->set('HTML.AllowedAttributes', 'img.src', '*style');
    $purifier = new HTMLPurifier($config);
    $contenu = $purifier->purify($contenu);

    $is_approved = $_SESSION['role'] == 'admin' ? 1 : 0; //si l'utilisateur est un admin, alors il peut publier directement l'article

    if (!empty($titre) && !empty($contenu) && !empty($heure) && !empty($id_categorie) && !empty($date)) {
        if (!isset($_SESSION['id'])) {
            $_SESSION['message'] = "L'utilisateur n'est pas connecté";
            exit;
        } else {
            $id_membre = $_SESSION['id'];
        }

        $countReq = $conn->prepare('SELECT COUNT(*) as eventsCount FROM events WHERE id_membre = ?');
        $countReq->execute(array($id_membre));
        $result = $countReq->fetch();
        $eventNumber = $result['eventsCount'] + 1;


        date_default_timezone_set('Europe/Paris'); // Remplacer par le fuseau horaire approprié

        $date = date('Y-m-d', strtotime($date)); // Convertir la date en format MySQL

        $heure = date('H:i:s', strtotime($heure)); // Convertir l'heure en format MySQL

        $req = $conn->prepare('INSERT INTO events(titre, contenu, heure, date, id_categorie, id_membre, eventNumber) VALUES(?, ?, ?, ?, ?, ?, ?)');
        $insertResult = $req->execute(array($titre, $contenu, $heure, $date, $id_categorie, $id_membre, $eventNumber));

        if ($insertResult) {
            $_SESSION['message'] = "Votre opération a été conclue avec succès."; //variable de session qui permet d'afficher un message de confirmation dans index.php
            header('Location: ./Back-end/index.php');
            exit();
        } else {
            $_SESSION['message'] = "Une erreur s'est produite lors de l'insertion de l'événement.";
        }
    } else {
        $_SESSION['message'] = "Veuillez remplir tous les champs.";
    }
}

$date = $_GET['date'] ?? ''; // Ajouté pour récupérer la date depuis l'URL

include('./include/header.php');
?>

<head>
    <title>Publier un Article</title>
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/y0pve2mo0nyo3usityjjek5slbomk2co1v8ammbx4vgx183v/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({ // TinyMCE editor initialization code
            selector: 'textarea[name=contenu]'
        });
    </script>
</head>

<body>
    <div class="container">
        <h2>Les Evenements</h2>
        <?php

        // Récupération des événements de l'utilisateur connecté
        $events = $conn->prepare("SELECT * FROM events WHERE id_membre = ?");
        $events->execute(array($_SESSION['id']));

        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">Titre</th>';
        echo '<th scope="col">Heure</th>';
        echo '<th scope="col">Date</th>';
        echo '<th scope="col">Contenu</th>';
        echo '<th scope="col">Catégorie</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($event = $events->fetch()) {
            echo '<tr>';
            echo '<td>' . $event['titre'] . '</td>';
            echo '<td>' . $event['heure'] . '</td>';
            echo '<td>' . $event['date'] . '</td>';
            echo '<td>' . $event['contenu'] . '</td>';

            // Afficher la catégorie en utilisant id_categorie pour obtenir le nom de la catégorie
            $categorie = $conn->prepare("SELECT nom_categorie FROM categories WHERE id_categorie = ?");
            $categorie->execute(array($event['id_categorie']));
            if ($cat = $categorie->fetch()) {
                echo '<td>' . $cat['nom_categorie'] . '</td>';
            } else {
                echo '<td>Non défini</td>'; // Si pour une raison quelconque, la catégorie n'est pas disponible
            }
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

        ?>
        <hr>
        <form method="POST" action="" class="mt-5">
            <div class="form-group">
                <h2>Création de votre événement</h2>
                <label for="titre">Titre</label>
                <input type="text" name="titre" placeholder="Titre" class="form-control" id="titre">
            </div>
            <div class="form-group">
                <label for="contenu">Contenu</label>
                <textarea name="contenu" placeholder="Contenu" class="form-control" id="contenu"></textarea>
            </div>
            <div class="form-group">
                <label for="heure">Heure</label>
                <input type="time" name="heure" placeholder="Heure" class="form-control" id="heure">
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

            <div class="form-groupB">
                <input type="hidden" id="date" name="date" value="<?php echo $date; ?>"> <!-- Ajouté pour envoyer la date avec le formulaire -->
                <button type="submit" name="valider" class="btn btn-primary">Submit</button>
                <a href="./Back-end/index.php" class="btn btn-secondary">Retour</a>
            </div>

        </form>
    </div>
    <?php include('./include/footer.php') ?>