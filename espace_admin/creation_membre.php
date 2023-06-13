<?php
session_start();
include('config.php');

if(isset($_POST['submit'])) {// Si le formulaire est soumis
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $pass = htmlspecialchars($_POST['pass']);
    $comfirmation_pass = htmlspecialchars($_POST['comfirmation_pass']);
    $role = htmlspecialchars($_POST['role']);
    

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {// Validate email address
        echo "Format d'e-mail invalide";
        exit;
    }

    if (strlen($pass) < 8) {
        echo "Le mot de passe doit comporter au moins 8 caractères";
        exit;
    } elseif (!preg_match("#[0-9]+#", $pass)) {
        echo "Le mot de passe doit contenir au moins un chiffre";
        exit;
    } elseif (!preg_match("#[a-zA-Z]+#", $pass)) {
        echo "Le mot de passe doit contenir au moins une lettre";
        exit;
    } elseif (!preg_match("#[A-Z]+#", $pass)) {
        echo "Le mot de passe doit contenir au moins une lettre majuscule";
        exit;
    } elseif (!preg_match("#\W+#", $pass)) {
        echo "Le mot de passe doit contenir au moins un caractère spécial";
        exit;
    } elseif ($pass != $comfirmation_pass) {
        echo "Les mots de passe ne correspondent pas";
        exit;
    } else {
        echo "Mot de passe valide";
    }
    
    $pass = password_hash($pass, PASSWORD_DEFAULT);// Hash password

    $stmt = $conn->prepare("INSERT INTO membres (pseudo, email, pass, role) VALUES (?, ?, ?, ?)");// Insertion des données dans la table membres
    $stmt->execute([$pseudo, $email, $pass, $role]);// Exécution de la requête

    echo "Membre créé avec succès.";
    header('Location: membres.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Espace admin</title>
</head>

<body>
    <form method="POST" action="">
        <input type="text" name="pseudo" placeholder="Pseudo">
        <br>
        <input type="email" name="email" placeholder="Email">
        <br>
        <input type="password" name="pass" placeholder="Password">
        <br>
        <input type="password" name="comfirmation_pass" placeholder="Password comfirm">
        <br>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="contributeur">Contributeur</option>
            <option value="user">Utilisateur</option>
            <input type="submit" name="submit" value="Créer">
        </select>
    </form>
</body>
</html>
