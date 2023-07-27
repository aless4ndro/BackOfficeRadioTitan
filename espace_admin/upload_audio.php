<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    // If no session is active, we start it
    session_start();
}

include('config.php');

$error_file = fopen("errors.txt", "w");

if(isset($_POST['submit'])) {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);//filter_var($_POST['title'], FILTER_SANITIZE_STRING); ceci est une fonction qui permet de filtrer les données entrées par l'utilisateur afin d'éviter les injections SQL
    $date = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $code_color = filter_var($_POST['code_color'], FILTER_SANITIZE_STRING);
    $id_categorie = filter_var($_POST['id_categorie'], FILTER_SANITIZE_NUMBER_INT);

    $audio_target_dir = "upload_audio/";
    $audio_target_file = $audio_target_dir . basename($_FILES["file_path"]["name"]);
    $audio_filetype = strtolower(pathinfo($audio_target_file,PATHINFO_EXTENSION));
    $allowed_audio_types = array("mp3", "wav", "ogg");

    $img_target_dir = "upload_images/";
    $img_target_file = $img_target_dir . basename($_FILES["img_illustration"]["name"]);
    $img_filetype = strtolower(pathinfo($img_target_file,PATHINFO_EXTENSION));
    $allowed_img_types = array("jpg", "png", "jpeg");

    // Create directories if they do not exist
    if (!file_exists($audio_target_dir) || !is_writable($audio_target_dir)) {
        mkdir($audio_target_dir, 0755, true);
    }
    if (!file_exists($img_target_dir) || !is_writable($img_target_dir)) {
        mkdir($img_target_dir, 0755, true);
    }

    if (in_array($audio_filetype, $allowed_audio_types) && in_array($img_filetype, $allowed_img_types)) {
        fwrite($error_file, "Les types de fichiers sont autorisés.\n");
        if (move_uploaded_file($_FILES["audio_file"]["tmp_name"], $audio_target_file)) {
            fwrite($error_file, "Fichier audio déplacé avec succès.\n");
        } else {
            fwrite($error_file, "Erreur lors du déplacement du fichier audio.\n");
        }

        if (move_uploaded_file($_FILES["img_illustration"]["tmp_name"], $img_target_file)) {
            fwrite($error_file, "Image déplacée avec succès.\n");
        } else {
            fwrite($error_file, "Erreur lors du déplacement de l'image.\n");
        }

        try {
            $stmt = $conn->prepare("INSERT INTO audio (title, file_path, date, description, code_color, img_illustration, id_categorie) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $audio_target_file, $date, $description, $code_color, $img_target_file, $id_categorie]);
            fwrite($error_file, "L'audio a été ajouté avec succès.\n");
        } catch(PDOException $e) {
            fwrite($error_file, "Erreur lors de l'insertion dans la base de données : " . $e->getMessage() . "\n");
        }
    } else {
        fwrite($error_file, "Type de fichier non autorisé.\n");
    }
} else {
    fwrite($error_file, "Le formulaire n'a pas été soumis.\n");
}

fclose($error_file);

?>


<?php
include('./include/header.php');
include('./include_sidebar/index.php');
include('./include_breadcrump/index.php');
?>


    <title>Upload audio</title>

    <form method="post" enctype="multipart/form-data">
    Titre : <input type="text" name="title"><br>
    Date : <input type="date" name="date"><br>
    Description : <textarea name="description"></textarea><br>
    Code couleur : <input type="color" name="code_color"><br>
    Catégorie ID : <input type="number" name="id_categorie"><br>
    Fichier audio : <input type="file" name="audio_file"><br>
    Image d'illustration : <input type="file" name="img_illustration"><br>
    <input type="submit" value="Upload" name="submit">
</form>
    <?php include('./include/footer.php'); ?>




 <!--
Configuration initiale et démarrage de la session :
php
Copy code
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('config.php');
Ces lignes de code sont utilisées pour configurer l'affichage des erreurs et démarrer la session PHP. La session est nécessaire pour garder trace de l'utilisateur à travers les différentes pages du site web. include('config.php'); est utilisé pour inclure le fichier config.php qui contient probablement les informations de connexion à la base de données.

Traitement du formulaire :
php
Copy code
if(isset($_POST['submit'])) {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $date = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $code_color = filter_var($_POST['code_color'], FILTER_SANITIZE_STRING);
    $id_categorie = filter_var($_POST['id_categorie'], FILTER_SANITIZE_NUMBER_INT);
Ces lignes de code vérifient si le formulaire a été soumis. Si c'est le cas, les données du formulaire sont récupérées et nettoyées à l'aide de la fonction filter_var() pour éviter les injections SQL.

Préparation des chemins de destination pour les fichiers téléchargés et vérification des types de fichiers :
php
Copy code
$audio_target_dir = "upload_audio/";
$audio_target_file = $audio_target_dir . basename($_FILES["audio_file"]["name"]);
$audio_filetype = strtolower(pathinfo($audio_target_file,PATHINFO_EXTENSION));
$allowed_audio_types = array("mp3", "wav", "ogg");

$img_target_dir = "upload_images/";
$img_target_file = $img_target_dir . basename($_FILES["img_illustration"]["name"]);
$img_filetype = strtolower(pathinfo($img_target_file,PATHINFO_EXTENSION));
$allowed_img_types = array("jpg", "png", "jpeg");
Ces lignes de code préparent les chemins de destination pour les fichiers téléchargés et vérifient les types de fichiers. Elles vérifient que les types de fichiers sont dans les types autorisés définis dans les tableaux $allowed_audio_types et $allowed_img_types.

Déplacement des fichiers téléchargés et insertion des informations dans la base de données :
php
Copy code
if (in_array($audio_filetype, $allowed_audio_types) && in_array($img_filetype, $allowed_img_types)) {
    if (move_uploaded_file($_FILES["audio_file"]["tmp_name"], $audio_target_file) && move_uploaded_file($_FILES["img_illustration"]["tmp_name"], $img_target_file)) {
        $stmt = $conn->prepare("INSERT INTO audio (title, file_path, date, description, code_color, img_illustration, id_categorie) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $audio_target_file, $date, $description, $code_color, $img_target_file, $id_categorie]);
    }
}
Ces lignes de code vérifient si les types de fichiers sont autorisés. Si c'est le cas, elles déplacent les fichiers téléchargés vers les destinations préparées. Si le déplacement est réussi, elles préparent une requête SQL pour insérer les informations dans la base de données et exécutent la requête.

Affichage du formulaire :
php
Copy code
<form method="post" enctype="multipart/form-data">
    Titre : <input type="text" name="title"><br>
    Date : <input type="date" name="date"><br>
    Description : <textarea name="description"></textarea><br>
    Code couleur : <input type="color" name="code_color"><br>
    Catégorie ID : <input type="number" name="id_categorie"><br>
    Fichier audio : <input type="file" name="audio_file"><br>
    Image d'illustration : <input type="file" name="img_illustration"><br>
    <input type="submit" value="Upload" name="submit">
</form>
Enfin, le script affiche un formulaire HTML permettant à l'utilisateur de télécharger un fichier audio. Le formulaire contient plusieurs champs pour les différentes informations nécessaires, et deux champs de type file pour le téléchargement de l'audio et de l'image. Lorsque l'utilisateur soumet le formulaire, les données sont envoyées à la même page pour traitement par le script PHP en haut de la page.


DIFFERENCES entre :

`filter_var` et `htmlspecialchars` sont deux fonctions PHP qui sont souvent utilisées pour nettoyer les données entrantes et prévenir les attaques de type injection.

`htmlspecialchars` est une fonction qui convertit les caractères spéciaux en entités HTML. Par exemple, elle convertit le caractère `<` en `&lt;`, `>` en `&gt;`, `"` (double citation) en `&quot;`, `'` (apostrophe) en `&#039;` et `&` (ampersand) en `&amp;`. Cette fonction est souvent utilisée pour prévenir les attaques de type cross-site scripting (XSS) lorsque vous affichez des données dans une page HTML.

`filter_var`, en revanche, est une fonction plus générale qui peut être utilisée pour filtrer et valider les données. Elle peut prendre un deuxième argument qui spécifie le type de filtre à appliquer. Par exemple, `FILTER_SANITIZE_STRING` supprime les balises et peut également supprimer ou encoder les caractères spéciaux. `FILTER_SANITIZE_NUMBER_INT` supprime tous les caractères sauf les chiffres et les signes plus et moins. Il existe de nombreux autres filtres pour des tâches spécifiques comme la validation des adresses email, des URL, etc.

En résumé, `htmlspecialchars` est spécifique à la prévention des attaques XSS dans le contexte HTML, tandis que `filter_var` est une fonction de nettoyage et de validation des données plus générale.
-------------------------------------------------
    
    
    $_FILES pour accéder au fichier téléchargé et le déplacer à l'endroit désiré sur le serveur
Ce script tente de déplacer le fichier uploadé vers le répertoire "uploads" sur le serveur. Si le fichier est déplacé avec succès, il insère une nouvelle ligne dans la table "podcasts" de la base de données avec le titre du podcast et le chemin du fichier.


Modifier le fichier php.ini et augmenter la valeur de upload_max_filesize et post_max_size. Par exemple, pour augmenter la limite à 100M :

upload_max_filesize = 100M
post_max_size = 100M
Ensuite, vous devrez redémarrer votre serveur web pour que les modifications prennent effet.
-->