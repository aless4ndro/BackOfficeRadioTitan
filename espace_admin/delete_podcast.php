<?php
session_start();
include('config.php');
require('permission_admin.php');

if (isset($_GET['id_categorie']) and !empty($_GET['id_categorie'])) {
    $getid = intval($_GET['id_categorie']);
    $req = $conn->prepare('SELECT * FROM categories WHERE id_categorie = ?');
    $req->execute(array($getid));
    if ($req->rowCount() > 0) {
        $delete = $conn->prepare('DELETE FROM categories WHERE id_categorie = ?');
        $delete->execute(array($getid));
        header('Location: ./index.php'); //redirect to the homepage after deletion
        exit;
    } else {
        echo "Cette catégorie n'existe pas";
    }
} else {
    echo "L'id n'est pas recuperé";
}
?>
