<?php
session_start();

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


<!--
###Voici ce que fait votre script, étape par étape :

Il démarre une nouvelle session PHP.
Il définit le type de contenu de la réponse à "image/png" avec header("Content-type: image/png");. Ceci est nécessaire pour que le navigateur comprenne qu'il reçoit une image et non du texte ou du HTML.
Il génère une chaîne de 5 caractères aléatoires à partir de l'alphabet en majuscules.
Il stocke cette chaîne dans la session PHP.
Il crée une nouvelle image de 200x50 pixels.
Il définit la couleur de fond de l'image à noir et la couleur du texte à blanc.
Il ajoute la chaîne générée aléatoirement à l'image à une position définie.
Il génère l'image en format PNG et l'envoie au navigateur.
Enfin, il libère la mémoire utilisée pour créer l'image.


###Fonctionnement du CAPTCHA

Le navigateur demande la page connexion.php au serveur.
Le serveur envoie le HTML de connexion.php au navigateur.
Le navigateur analyse le HTML et voit une balise <img src="captcha.php">.
Le navigateur fait une nouvelle requête au serveur pour captcha.php.
Le serveur exécute captcha.php, qui génère une image et l'envoie au navigateur.
Le navigateur reçoit les données de l'image et l'affiche à l'endroit où se trouve la balise <img>.


###Taches executées pour le bon fonctionnement du CAPTCHA

Ouvrez votre fichier php.ini. Vous pouvez généralement le trouver dans le répertoire où PHP est installé. Par exemple, pour XAMPP, il est généralement situé à C:\xampp\php\php.ini.
Recherchez la ligne qui ressemble à ;extension=gd2 (elle peut aussi être juste ;extension=gd).
Supprimez le point-virgule (;) au début de la ligne pour décommenter cette ligne et activer l'extension GD. La ligne doit maintenant ressembler à extension=gd2 ou extension=gd.
Sauvegardez le fichier php.ini et redémarrez votre serveur.
-->