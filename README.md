# Dashboard

Le Dashboard de Titan-Beard est une application de gestion back-office conçue pour le site web titan-beard.com. Cette application offre aux administrateurs du site une interface intuitive et robuste pour gérer les différentes parties du site web.

## Fonctionnalités principales

1. **Gestion des utilisateurs :** Les administrateurs ont la possibilité de créer, de modifier et de supprimer des utilisateurs. Ils peuvent également attribuer différents rôles aux utilisateurs, tels qu'administrateur, contributeur et utilisateur.

2. **Gestion des articles :** Les administrateurs peuvent créer de nouveaux articles, les modifier et les supprimer. Cela offre un contrôle complet sur le contenu du site. Création article avec l'éditeur TinyMCE 'WYSIWYG' What You See Is What You Get

3. **Gestion des albums et des podcasts :** Outre les articles, les administrateurs peuvent également gérer les albums et les podcasts. Ils peuvent créer de nouveaux albums et podcasts, les modifier et les supprimer. Gestion des catégories.

4. **Visualisation de la base de données :** Les administrateurs ont une vue d'ensemble de la base de données, leur permettant de comprendre facilement la structure de la base de données et d'effectuer des modifications en conséquence.

docker-compose up -d

mysql -u root -pmy-secret-pw

Debeug:

```bash
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

![Screenshot du Dashboard](/espace_admin/img_maquette/dashboard.png)

![Screenshot du Dashboard](/espace_admin/img_maquette/dashboard1.png)

![Screenshot du Dashboard](/espace_admin/img_maquette/dashboard3.png)

![Screenshot du Dashboard](/espace_admin/img_maquette/form.png)

![Screenshot du Dashboard](/espace_admin/img_maquette/podcast.png)

![Screenshot du Dashboard](/espace_admin/img_maquette/tiny.png)

![Screenshot du Dashboard](/espace_admin/img_maquette/maquette.png)

![Screenshot du Dashboard](/espace_admin/img_maquette/mobil.png)

![Screenshot du Dashboard](/espace_admin/img_maquette/mobil2.png)

## Connexion à la BDD

Config.php

```bash
<?php
$servername = "localhost";
$username = "root";
$password = "my-secret-pw";
$dbname = "espace_admin_altameos";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
```

## Ajout d'une clé étrangère à la table articles

Pour permettre l'affichage du pseudo du membre qui a créé un article, nous avons besoin d'une référence à l'ID du membre dans la table articles. Pour ce faire, nous ajoutons une clé étrangère id_membre à la table articles qui fait référence à la clé primaire id dans la table membres.

Exécutez les commandes SQL suivantes pour ajouter la colonne id_membre à votre table articles et définir une contrainte de clé étrangère qui lie cette colonne à la colonne id dans la table membres. Cela ajoute une colonne id_membre à votre table articles et définit une contrainte de clé étrangère qui lie cette colonne à la colonne id dans la table membres.

Note : Pour que cette opération réussisse, la colonne id dans la table membres doit être déclarée comme une clé primaire. De plus, les types de données de id_membre et id doivent être les mêmes.

```bash
  ALTER TABLE articles ADD COLUMN id_membre INT;
  ALTER TABLE articles ADD FOREIGN KEY (id_membre) REFERENCES membres(id);
```

L'approche serait d'avoir une colonne id_membre dans votre table articles. Lorsqu'un membre crée un article, son ID de membre est stocké dans cette colonne. Cela vous permet de relier chaque article à son créateur.

Pour récupérer le pseudo de l'utilisateur qui a créé un article, vous pouvez faire une jointure entre les tables articles et membres basée sur id_membre. Voici comment cela pourrait se faire :

```bash
  $req = $conn->prepare("SELECT articles.*, membres.pseudo 
                       FROM articles 
                       INNER JOIN membres ON articles.id_membre = membres.id 
                       WHERE articles.statut='non valide'");
$req->execute();
$articles = $req->fetchAll();

foreach($articles as $article){
    echo "Titre : " . htmlspecialchars($article['titre']);
    echo "Contenu : " . nl2br(htmlspecialchars($article['contenu']));
    echo "Auteur : " . htmlspecialchars($article['pseudo']);
    // ...
}
```

![Screenshot du Dashboard](/espace_admin/img_maquette/bdd.png)

## Color Reference

| Color             | Hex                                                                |
| ----------------- | ------------------------------------------------------------------ |
| White             | ![#FFFFFF](https://via.placeholder.com/10/FFFFFF?text=+) #FFFFFF |
| Blue              | ![#0000FF](https://via.placeholder.com/10/0000FF?text=+) #0000FF |
| Green             | ![#008000](https://via.placeholder.com/10/008000?text=+) #008000 |
| Orange            | ![#FFA500](https://via.placeholder.com/10/FFA500?text=+) #FFA500 |
com/10/00b48a?text=+) #00d1a0 |

## Utilisation de HTML Purifier en PHP

Introduction
Dans les applications web, la gestion de la sécurité des entrées utilisateur est primordiale pour éviter les attaques de type Cross-Site Scripting (XSS). L'une des approches courantes est d'utiliser la fonction htmlspecialchars() de PHP, qui convertit les caractères spéciaux en entités HTML afin qu'ils soient affichés au lieu d'être interprétés par le navigateur.

Cependant, pour des situations où vous voulez permettre aux utilisateurs d'insérer un certain niveau de balisage HTML, comme pour un éditeur de texte riche, htmlspecialchars() ne suffira pas car il échappera tout le HTML.

Dans ce cas, une alternative est d'utiliser une bibliothèque comme HTML Purifier. Elle permet un certain niveau de balisage HTML tout en empêchant les attaques XSS.

### Comment utiliser HTML Purifier

Installation
Téléchargez et installez HTML Purifier via Composer :

```bash
composer require ezyang/htmlpurifier
```

### Utilisation

```bash
require_once __DIR__ . '/vendor/autoload.php';
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);
```

Nettoyez votre HTML avec la méthode purify() :

```bash
$clean_html = $purifier->purify($dirty_html);
```

$dirty_html est la variable contenant le HTML inséré par l'utilisateur que vous voulez nettoyer

### Configuration de HTMLpurify et ajout de '*style' et 'img' pour le bon functionnement et le nettoyage du code html

```bash
    $config = HTMLPurifier_Config::createDefault();
    $config->set('HTML.AllowedElements', array('img'));
    $config->set('HTML.AllowedAttributes', 'img.src', '*style');
    $purifier = new HTMLPurifier($config);
    $contenu = $purifier->purify($contenu);
```

Conclusion
HTML Purifier vous permet d'accepter du contenu HTML sécurisé de vos utilisateurs tout en bloquant toutes les tentatives d'attaque XSS.

Il est important de souligner qu'aucune solution n'est une garantie absolue en matière de sécurité. Tester votre application et rester à jour avec les dernières vulnérabilités et techniques d'attaque est crucial.

### Code complet publier_article.php

```bash
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

        $_SESSION['message'] = "Votre article a bien été publié";
    } else {
        $_SESSION['message'] = "Veuillez remplir tous les champs";
    }
}


if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    $_SESSION['message'] = '';  // Clear the message after displaying it
}


include('./include/header.php');

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
    <?php include('./include/footer.php') ?>
```

Voici ce que fait le code:
 Il démarre une session PHP et inclut votre fichier de configuration.
 Il vérifie si l'utilisateur est connecté en vérifiant si $_SESSION['pseudo'] est défini. Si ce n'est pas le cas, il redirige l'utilisateur vers la page de connexion.
 S'il y a des données POST (c'est-à-dire si l'utilisateur a soumis le formulaire), il récupère ces données, les échappe pour empêcher les attaques XSS, et utilise HTMLPurifier pour nettoyer le contenu de toute balise HTML dangereuse.
 Il vérifie si tous les champs requis sont remplis. Si c'est le cas, il insère le nouvel article dans la base de données. Sinon, il affiche un message d'erreur.
 Si un message est stocké dans $_SESSION['message'], il l'affiche et le supprime ensuite.

## Captcha fait maison

### Voici ce que fait ce script, étape par étape

Il démarre une nouvelle session PHP.
Il définit le type de contenu de la réponse à "image/png" avec header("Content-type: image/png");. Ceci est nécessaire pour que le navigateur comprenne qu'il reçoit une image et non du texte ou du HTML.
Il génère une chaîne de 5 caractères aléatoires à partir de l'alphabet en majuscules.
Il stocke cette chaîne dans la session PHP.
Il crée une nouvelle image de 200x50 pixels.
Il définit la couleur de fond de l'image à noir et la couleur du texte à blanc.
Il ajoute la chaîne générée aléatoirement à l'image à une position définie.
Il génère l'image en format PNG et l'envoie au navigateur.
Enfin, il libère la mémoire utilisée pour créer l'image.

### Fonctionnement du CAPTCHA

Le navigateur demande la page connexion.php au serveur.
Le serveur envoie le HTML de connexion.php au navigateur.
Le navigateur analyse le HTML et voit une balise ```bash <img src="captcha.php">```
Le navigateur fait une nouvelle requête au serveur pour captcha.php.
Le serveur exécute captcha.php, qui génère une image et l'envoie au navigateur.
Le navigateur reçoit les données de l'image et l'affiche à l'endroit où se trouve la balise ```bash <img>```

### Taches executées pour le bon fonctionnement du CAPTCHA

Ouvrez votre fichier php.ini. Vous pouvez généralement le trouver dans le répertoire où PHP est installé. Par exemple, pour XAMPP, il est généralement situé à C:\xampp\php\php.ini.
Recherchez la ligne qui ressemble à ;extension=gd2 (elle peut aussi être juste ;extension=gd).
Supprimez le point-virgule (;) au début de la ligne pour décommenter cette ligne et activer l'extension GD. La ligne doit maintenant ressembler à extension=gd2 ou extension=gd.
Sauvegardez le fichier php.ini et redémarrez votre serveur.

```bash
<?php
session_strart();

header("Content-type: image/png");

$code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5); // Générer une chaine aléatoire


$_SESSION["captcha"] = $code; // Stocker le code dans une session

$im = imagecreate(200, 50); // Créer une image

$background_color = imagecolorallocate($im, 0, 0, 0); // Définir la couleur de fond
$text_color = imagecolorallocate($im, 255, 255, 255); // Définir la couleur du texte

imagestring($im, 5, 70, 15,  $code, $text_color); // Ajouter le texte à l'image

imagepng($im); // Générer l'image
imagedestroy($im); // Libérer la mémoire
?>
```

## Installation  bibliothèque GD pour le Captcha

Sur Ubuntu/Debian :

```bash
sudo apt-get install php-gd
```

![Screenshot du Dashboard](/espace_admin/img_maquette/captcha.png)

## Docker

Création des images MySQL, PHPMYADMIN

```bash
  version: '3.1'

services:
  mysql:
    image: mysql:latest
    container_name: my-mysql
    command: --default-authentication-plugin=mysql_native_password
    environment:
      MYSQL_ROOT_PASSWORD: my-secret-pw
    ports:
      - 3306:3306
    volumes:
      - mysql-data:/var/lib/mysql

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    container_name: my-phpmyadmin
    depends_on:
      - mysql
    ports:
      - 8080:80
    environment:
      PMA_HOST: mysql
      PMA_USER: root
      PMA_PASSWORD: my-secret-pw

volumes:
  mysql-data:

```

## Run Locally

Clone the project

```bash
  git clone https://github.com/aless4ndro/BackOfficeRadioTitan.git
```

Go to the project directory

```bash
  cd espace_admin
```

Install dependencies

```bash
  Bootstrap cdn version 4.3.0 and 5.3.0
```

Start the server

```bash
  extension vscode php server
```

## Tech Stack

**Operating System:** Windows, Linux/Debien

**Client:** HTML5, CSS3, Bootstrap

**Server:** PHP, MySQL, PHPMYADMIN

**Config:** Docker

**Design:** Figma
