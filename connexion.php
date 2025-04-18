<?php
// parametres de connexion
$host = 'localhost';
$dbname = 'gestion_utilisateurs';
$username = 'root';
$password = '';

try {
    // connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // config erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie!";
} catch(PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}
?>
