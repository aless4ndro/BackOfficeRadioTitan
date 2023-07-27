<?php

if(session_status() == PHP_SESSION_NONE){
    // Si aucune session n'est active, on la démarre
    session_start();
}
include('config.php');

if (!isset($_SESSION['pseudo'])) {
    header('Location: connexion.php');
    exit();
}

require_once __DIR__ . '/vendor/autoload.php';

$titre = '';
$contenu = '';
$id_categorie = '';

if (isset($_POST['valider'])) {
    $titre = htmlspecialchars($_POST['titre']);
    $contenu = $_POST['contenu'];

    $id_categorie = htmlspecialchars($_POST['id_categorie']);

    $config = HTMLPurifier_Config::createDefault();
    $config->set('HTML.AllowedElements', array('img'));
    $config->set('HTML.AllowedAttributes', 'img.src', '*style');
    $purifier = new HTMLPurifier($config);
    $contenu = $purifier->purify($contenu);



    $is_approved = $_SESSION['role'] == 'admin' ? 1 : 0;

    if (!empty($titre) and !empty($contenu) and !empty($id_categorie)) {
        if (!isset($_SESSION['id'])) {
            $_SESSION['message'] = "L'utilisateur n'est pas connecté";
            exit;
        } else {
            $id_membre = $_SESSION['id'];
        }

        $req = $conn->prepare('INSERT INTO articles(titre, contenu, id_categorie, id_membre, is_approved) VALUES(?, ?, ?, ?, ?)');
        $req->execute(array($titre, $contenu, $id_categorie, $id_membre, $is_approved));

        $_SESSION['message'] = "Votre opération a été conclue avec succès.";//variable de session qui permet d'afficher un message de confirmation dans index.php
        header('Location: ./Back-end/index.php');
        exit();
    } else {
        $_SESSION['message'] = "Veuillez remplir tous les champs";
    }
}

//Voici ce que fait le code:
// Il démarre une session PHP et inclut votre fichier de configuration.
// Il vérifie si l'utilisateur est connecté en vérifiant si $_SESSION['pseudo'] est défini. Si ce n'est pas le cas, il redirige l'utilisateur vers la page de connexion.
// S'il y a des données POST (c'est-à-dire si l'utilisateur a soumis le formulaire), il récupère ces données, les échappe pour empêcher les attaques XSS, et utilise HTMLPurifier pour nettoyer le contenu de toute balise HTML dangereuse.
// Il vérifie si tous les champs requis sont remplis. Si c'est le cas, il insère le nouvel article dans la base de données. Sinon, il affiche un message d'erreur.
// Si un message est stocké dans $_SESSION['message'], il l'affiche et le supprime ensuite.


// En stockant le message dans la variable de session $_SESSION['message'], vous permettez au message d'être disponible pour la prochaine demande HTTP. C'est utile par exemple lorsque vous redirigez l'utilisateur vers une autre page après avoir traité un formulaire, et que vous voulez afficher un message sur cette autre page.

// Dans notre cas, vous affichez immédiatement le message dans la même requête HTTP où il a été défini. Donc, techniquement, vous n'auriez pas besoin d'utiliser $_SESSION['message'] pour cela, vous pourriez simplement utiliser une variable régulière comme $message. Cependant, utiliser $_SESSION['message'] ne fait pas de mal et pourrait être utile si vous décidez plus tard de rediriger l'utilisateur après l'insertion de l'article.

// Notez que vous réinitialisez $_SESSION['message'] à une chaîne vide après l'avoir affiché. C'est une bonne pratique car cela garantit que le message n'est affiché qu'une seule fois. Si vous ne le faisiez pas, le même message serait affiché à nouveau pour la prochaine requête HTTP, ce qui serait probablement déroutant pour l'utilisateur.
?>


<?php
    include('./include/header.php');
    include('./include_sidebar/index.php');
    include('./include_breadcrump/index.php') 
?>

<head>
    <title>Publier un Article</title>
    <script src="https://cdn.tiny.cloud/1/y0pve2mo0nyo3usityjjek5slbomk2co1v8ammbx4vgx183v/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({ // TinyMCE editor initialization code
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
    <br>
    <br>
    <?php include('./include/footer.php') ?>