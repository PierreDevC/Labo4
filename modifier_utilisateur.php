<?php
require_once 'connexion.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = htmlspecialchars($_POST['nom']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        
        try {
            $sql = "UPDATE utilisateurs SET nom = ?, email = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom, $email, $id]);
            echo "Utilisateur modifié avec succès!";
        } catch(PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }
    
    // recuperer les données actuelles
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php require_once 'navbar.php'; ?>
    <div class="container mt-5">
        <h2>Modifier l'utilisateur</h2>
        <?php 
        if(isset($user)): 
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($e)) {
                echo '<div class="alert alert-success" role="alert">Utilisateur modifié avec succès! <a href="liste_utilisateurs.php">Retour à la liste</a></div>';
                // recuperer les données actuelles
                $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
                $stmt->execute([$id]);
                $user = $stmt->fetch();
            } elseif (isset($e)) {
                echo '<div class="alert alert-danger" role="alert">Erreur: ' . $e->getMessage() . '</div>';
            }
        ?>
        <form method="POST">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href="liste_utilisateurs.php" class="btn btn-secondary">Annuler</a>
        </form>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">Utilisateur non trouvé ou ID manquant.</div>
            <a href="liste_utilisateurs.php" class="btn btn-primary">Retour à la liste</a>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
