<?php
session_start();
include('config.php');

if (isset($_GET['id']) and !empty($_GET['id'])) {
    $getid = $_GET['id'];
    $req = $conn->prepare('SELECT * FROM podcast WHERE id = ?');
    $req->execute(array($getid)); //on vérifie si l'id existe dans la base de données
    if ($req->rowCount() > 0) { //si l'id existe
        $delete = $conn->prepare('DELETE FROM podcast WHERE id = ?');
        $delete->execute(array($getid));
        header('Location: upload_podcast.php');
    } else {
        echo "Ce podcast n'existe pas";
    }
} else {
    echo "L'id n'est pas recuperé";
}
?>