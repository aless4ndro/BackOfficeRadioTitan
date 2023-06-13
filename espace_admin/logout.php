<?php
session_start();// On démarre la session
$_SESSION = [];// On écrase le tableau de session
session_destroy();// On détruit la session
header('Location: connexion.php');// On redirige le visiteur vers la page de connexion

//ce script permet de se déconnecter de l'espace admin en détruisant la session en cours.
?>
