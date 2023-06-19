<?php   
session_start();
include('config.php');
require('permission_admin.php');

if(isset($_GET['id']) and !empty($_GET['id'])) {
    $getid = $_GET['id'];
    $req = $conn->prepare('SELECT * FROM membres WHERE id = ?');
    $req->execute(array($getid));//on vérifie si l'id existe dans la base de données
    if($req->rowCount() > 0) {//si l'id existe
        $delete = $conn->prepare('DELETE FROM membres WHERE id = ?');
        $delete->execute(array($getid));
        echo "Le membre a bien été supprimé";
        echo "<a href='./Back-end/index.php'>Retour à l'accueil</a>";
    } else {
        echo "Ce membre n'existe pas";
    }
}else {
    echo "L'id n'est pas recuperé";
}
?>