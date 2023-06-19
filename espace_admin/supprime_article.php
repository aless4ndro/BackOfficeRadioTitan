<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('config.php');
require('permission_admin.php');

if(isset($_GET['id']) and !empty($_GET['id'])) {
    $getid = $_GET['id'];
    $req = $conn->prepare('SELECT * FROM articles WHERE id = ?');
    $req->execute(array($getid));//on vérifie si l'id existe dans la base de données
    if($req->rowCount() > 0) {
        $delete = $conn->prepare('DELETE FROM articles WHERE id = ?');
        $delete->execute(array($getid));
        echo "L'article a bien été supprimé";
        echo "<a href='./Back-end/index.php'>Retour à l'accueil</a>";
    } else {
        echo "Cet article n'existe pas";
    }
}else {
    echo "L'id n'est pas recuperé";
}  
?>