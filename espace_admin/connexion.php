<?php
session_start();
include('config.php');

if (isset($_POST['valider'])) {
    if (!empty($_POST['pseudo']) and !empty($_POST['pass'])) {

        $pseudo_saisi = htmlspecialchars($_POST['pseudo']);
        $password_saisi = htmlspecialchars($_POST['pass']);

        // Interroger la base de données pour l'utilisateur
        $stmt = $conn->prepare("SELECT * FROM membres WHERE pseudo = ?");
        $stmt->execute([$pseudo_saisi]);
        $user = $stmt->fetch();//fetch() fetches the next row from a result set

        if ($user && password_verify($password_saisi, $user['pass'])) {//password_verify() verifie si le mot de passe correspond au hachage
            // Le pseudo et le mot de passe sont corrects
            $_SESSION['pseudo'] = $pseudo_saisi;
            $_SESSION['role'] = $user['role'];
            header('Location: index.php');
            exit;
        } else {
            echo "Mauvais pseudo ou mot de passe";
        }
    } else {
        echo "Veuillez remplir tous les champs";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>

<body>
    <form method="POST" action="" align="center">
        <input type="text" name="pseudo" placeholder="pseudo">
        <br>
        <input type="password" name="pass" placeholder="password">
        <br>
        <br>
        <input type="submit" name="valider">
    </form>
</body>

</html>