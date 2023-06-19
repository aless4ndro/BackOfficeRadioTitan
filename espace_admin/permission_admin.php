<?php
// Vérifiez d'abord si l'utilisateur est connecté
if (!isset($_SESSION['pseudo']) || empty($_SESSION['pseudo'])) {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header('Location: connexion.php');
    exit;
}

// Ensuite, vérifiez si l'utilisateur est un administrateur
if ($_SESSION['role'] !== 'admin') {
    // Si l'utilisateur n'est pas un administrateur, redirigez-le vers une autre page
    echo "Vous n'avez pas le droit d'accéder à cette page";
    exit;
}
?>