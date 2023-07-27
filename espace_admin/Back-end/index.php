<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (session_status() == PHP_SESSION_NONE) {
  // Si aucune session n'est active, on la démarre
  session_start();
}

$servername = "mysql";
$username = "root";
$password = "my-secret-pw";
$dbname = "espace_admin_altameos";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (isset($_SESSION['pseudo'])) {
} else {
  header('Location: ./BackOfficeRadioTitan/espace_admin/connexion.php');
  exit;
}

include ('../include/header.php');

include ('../include_sidebar/index.php');

include ('../include_breadcrump/index.php');

include ('../include_lobby/index.php');

include ('../include/footer.php');
?>