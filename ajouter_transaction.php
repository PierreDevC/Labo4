<?php
require_once 'connexion.php';

// recuperer la liste des utilisateurs pour le menu déroulant
$stmt = $pdo->query("SELECT id, nom FROM utilisateurs");
$utilisateurs = $stmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $utilisateur_id = $_POST['utilisateur_id'];
    $montant = floatval($_POST['montant']);
    $type = $_POST['type_transaction'];
    $date = $_POST['date_transaction'];

    try {
        $sql = "INSERT INTO transactions (utilisateur_id, montant, type_transaction, date_transaction) 
                VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$utilisateur_id, $montant, $type, $date]);
        echo "Transaction ajoutée avec succès!";
    } catch(PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une transaction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php require_once 'navbar.php'; ?>
    <div class="container mt-5">
        <h2>Ajouter une nouvelle transaction</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($e)) {
            echo '<div class="alert alert-success" role="alert">Transaction ajoutée avec succès!</div>';
        } elseif (isset($e)) {
            echo '<div class="alert alert-danger" role="alert">Erreur: ' . $e->getMessage() . '</div>';
        }
        ?>
        <form method="POST">
            <div class="mb-3">
                <label for="utilisateur_id" class="form-label">Utilisateur</label>
                <select class="form-select" name="utilisateur_id" id="utilisateur_id" required>
                    <option selected disabled value="">Choisir un utilisateur...</option>
                    <?php foreach($utilisateurs as $user): ?>
                        <option value="<?php echo $user['id']; ?>">
                            <?php echo htmlspecialchars($user['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="montant" class="form-label">Montant</label>
                <input type="number" step="0.01" class="form-control" id="montant" name="montant" placeholder="Montant" required>
            </div>
            <div class="mb-3">
                <label for="type_transaction" class="form-label">Type de transaction</label>
                <select class="form-select" name="type_transaction" id="type_transaction" required>
                    <option selected disabled value="">Choisir un type...</option>
                    <option value="achat">Achat</option>
                    <option value="vente">Vente</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="date_transaction" class="form-label">Date</label>
                <input type="datetime-local" class="form-control" id="date_transaction" name="date_transaction" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter la transaction</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
