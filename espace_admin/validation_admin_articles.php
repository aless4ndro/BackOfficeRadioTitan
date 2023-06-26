<?php
session_start();
include('config.php');
require('permission_admin.php');

if (!isset($_SESSION['pseudo']) || empty($_SESSION['pseudo'])) {
    header('Location: connexion.php');
    exit;
}

// Suppose you have the article's ID
$article_id = $_GET['id'];

// Update the article's approval status to approved (1)
$req = $conn->prepare("UPDATE articles SET is_approved = 1 WHERE id = ?");
$req->execute(array($article_id));

header('Location: ./Back-end/index.php');
exit();
?>

<!--Il démarre une session et inclut votre fichier de configuration.
Il requiert le fichier permission_admin.php pour s'assurer que seul l'administrateur peut approuver des articles.
Il vérifie si l'utilisateur est connecté. Sinon, il le redirige vers la page de connexion.
Il récupère l'ID de l'article à partir du paramètre GET 'id'.
Il prépare et exécute une requête SQL pour mettre à jour le statut d'approbation de l'article en question.
Enfin, il redirige l'utilisateur vers la page d'accueil de l'espace administrateur.-->