<?php
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

?>