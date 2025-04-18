<?php
require_once 'connexion.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $sql = "DELETE FROM utilisateurs WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        header("Location: liste_utilisateurs.php");
    } catch(PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}
?>
