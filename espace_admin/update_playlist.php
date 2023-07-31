<?php
// Connexion à la base de données
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('config.php');

// Récupération de l'ID de la piste audio et de son statut dans la playlist à partir de la requête POST
$id = $_POST['id'];//id de la piste audio
$inPlaylist = $_POST['inPlaylist'];//statut de la piste audio dans la playlist

// Préparation de la requête SQL pour mettre à jour le statut de la piste audio dans la playlist
$stmt = $conn->prepare("UPDATE audio SET lecteur = ? WHERE id = ?");//

// Exécution de la requête SQL avec les valeurs récupérées
$stmt->execute([$inPlaylist, $id]);//met à jour le statut de la piste audio dans la playlist
?>
