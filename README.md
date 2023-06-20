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

![Screenshot du Dashboard](/espace_admin/img_maquette/bdd.png)

## Color Reference
## Color Reference

| Color             | Hex                                                                |
| ----------------- | ------------------------------------------------------------------ |
| White             | ![#FFFFFF](https://via.placeholder.com/10/FFFFFF?text=+) #FFFFFF |
| Blue              | ![#0000FF](https://via.placeholder.com/10/0000FF?text=+) #0000FF |
| Green             | ![#008000](https://via.placeholder.com/10/008000?text=+) #008000 |
| Orange            | ![#FFA500](https://via.placeholder.com/10/FFA500?text=+) #FFA500 |
com/10/00b48a?text=+) #00d1a0 |

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
