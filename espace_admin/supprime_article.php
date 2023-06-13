<?php
session_start();
include('config.php');

if(isset($_GET['id']) and !empty($_GET['id'])) {
    $getid = $_GET['id'];
    $req = $conn->prepare('SELECT * FROM articles WHERE id = ?');
    $req->execute(array($getid));//on vérifie si l'id existe dans la base de données
    if($req->rowCount() > 0) {
        $delete = $conn->prepare('DELETE FROM articles WHERE id = ?');
        $delete->execute(array($getid));
        header('Location: articles.php');
    } else {
        echo "Cet article n'existe pas";
    }
}else {
    echo "L'id n'est pas recuperé";
}  
?>