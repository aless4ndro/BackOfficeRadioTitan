<?php
session_start();
include('config.php');

if (isset($_GET['id']) and !empty($_GET['id'])) {
    $getid = $_GET['id'];
    $req = $conn->prepare('SELECT * FROM audio WHERE id = ?');
    $req->execute(array($getid)); //on vérifie si l'id existe dans la base de données
    if ($req->rowCount() > 0) { //si l'id existe
        $delete = $conn->prepare('DELETE FROM audio WHERE id = ?');
        $delete->execute(array($getid));

        header('Location: ./Back-end/index.php');
        
    } else {
        echo "Ce podcast n'existe pas";
    }
} else {
    echo "L'id n'est pas recuperé";
}
?>