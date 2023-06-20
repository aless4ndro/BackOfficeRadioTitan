<?php
session_start();
include('config.php');
require('permission_admin.php');

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

if (isset($_GET['id_categorie']) and !empty($_GET['id_categorie'])) {
    $getid = intval($_GET['id_categorie']);//intval — Retourne la valeur numérique entière équivalente d'une variable
    $req = $conn->prepare('SELECT * FROM categories WHERE id_categorie = ?');
    $req->execute(array($getid)); //on vérifie si l'id existe dans la base de données
    if ($req->rowCount() > 0) { //si l'id existe
        $delete = $conn->prepare('DELETE FROM categories WHERE id_categorie = ?');
        $delete->execute(array($getid));
        
    } else {
        echo "Ce podcast n'existe pas";
    }
} else {
    echo "L'id n'est pas recuperé";
}
?>