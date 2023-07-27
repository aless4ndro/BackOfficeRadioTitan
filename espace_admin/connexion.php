<?php
session_start();
include('config.php');

if (isset($_POST['valider'])) {
    if (!empty($_POST['pseudo']) and !empty($_POST['pass']) and !empty($_POST['captcha'])) {

        $pseudo_saisi = htmlspecialchars($_POST['pseudo']);
        $password_saisi = htmlspecialchars($_POST['pass']);
        $captcha_user = htmlspecialchars($_POST["captcha"]);

        if ($captcha_user != $_SESSION["captcha"]) {
            echo "Le CAPTCHA est incorrect !";
            exit;
        }

        // Interroger la base de données pour l'utilisateur
        $stmt = $conn->prepare("SELECT * FROM membres WHERE pseudo = ?");
        $stmt->execute([$pseudo_saisi]);
        $user = $stmt->fetch();

        if ($user && password_verify($password_saisi, $user['pass'])) {
            // Le pseudo et le mot de passe sont corrects
                $_SESSION['pseudo'] = $pseudo_saisi;
                $_SESSION['role'] = $user['role'];
                $_SESSION['id'] = $user['id'];
                header('Location: /Back-end/index.php');
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
    <!-- Ajouter la référence CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Connexion</h2>
                <form method="POST" action="">
                    <div class="mb-3">
                        <input type="text" name="pseudo" class="form-control" placeholder="Pseudo">
                    </div>
                    <div class="mb-3">
                        <input type="password" name="pass" class="form-control" placeholder="Mot de passe">
                    </div>
                    <div class="mb-3">
                        <img src="captcha.php" class="d-block mx-auto mb-2" alt="CAPTCHA">
                        <input type="text" name="captcha" class="form-control" placeholder="Veuillez entrer le CAPTCHA">
                    </div>
                    <div class="mb-3">
                        <input type="submit" name="valider" class="btn btn-primary w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Ajouter la référence JS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>
