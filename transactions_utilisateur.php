<!DOCTYPE html>
<html>
<head>
    <title>Transactions de l'utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php require_once 'navbar.php'; ?>
    <div class="container mt-5">
        <?php
        require_once 'connexion.php';

        if(isset($_GET['utilisateur_id'])) {
            $utilisateur_id = $_GET['utilisateur_id'];
            
            try {
                // recuperer le nom de l'utilisateur
                $stmt_user = $pdo->prepare("SELECT nom FROM utilisateurs WHERE id = ?");
                $stmt_user->execute([$utilisateur_id]);
                $user = $stmt_user->fetch();
                $nom_utilisateur = $user ? htmlspecialchars($user['nom']) : 'Utilisateur inconnu';

                $sql = "SELECT t.type_transaction, t.montant, t.date_transaction 
                        FROM transactions t 
                        WHERE t.utilisateur_id = ?
                        ORDER BY t.date_transaction DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$utilisateur_id]);
                
                echo "<h2>Transactions de " . $nom_utilisateur . "</h2>";

                if ($stmt->rowCount() > 0) {
                    echo "<table class='table table-striped table-bordered'>
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>";
                    
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['type_transaction']) . "</td>
                                <td>" . htmlspecialchars(number_format($row['montant'], 2, ',', ' ')) . " €</td>
                                <td>" . htmlspecialchars(date('d/m/Y H:i', strtotime($row['date_transaction']))) . "</td>
                            </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo '<div class="alert alert-info" role="alert">Aucune transaction trouvée pour cet utilisateur.</div>';
                }

            } catch(PDOException $e) {
                echo '<div class="alert alert-danger" role="alert">Erreur: ' . $e->getMessage() . '</div>';
            }
        } else {
            echo '<div class="alert alert-warning" role="alert">ID utilisateur non spécifié.</div>';
        }
        ?>
        <a href="liste_utilisateurs.php" class="btn btn-secondary mt-3">Retour à la liste des utilisateurs</a>
        <a href="ajouter_transaction.php" class="btn btn-primary mt-3">Ajouter une transaction</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
