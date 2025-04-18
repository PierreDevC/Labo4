<!DOCTYPE html>
<html>
<head>
    <title>Totaux des transactions</title>
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
                // Récupérer le nom de l'utilisateur pour l'affichage
                $stmt_user = $pdo->prepare("SELECT nom FROM utilisateurs WHERE id = ?");
                $stmt_user->execute([$utilisateur_id]);
                $user = $stmt_user->fetch();
                $nom_utilisateur = $user ? htmlspecialchars($user['nom']) : 'Utilisateur inconnu';

                // Calcul du total des achats
                $sql_achats = "SELECT SUM(montant) as total_achats 
                              FROM transactions 
                              WHERE utilisateur_id = ? AND type_transaction = 'achat'";
                $stmt_achats = $pdo->prepare($sql_achats);
                $stmt_achats->execute([$utilisateur_id]);
                $total_achats = $stmt_achats->fetch()['total_achats'] ?? 0; // Default to 0 if null

                // Calcul du total des ventes
                $sql_ventes = "SELECT SUM(montant) as total_ventes 
                              FROM transactions 
                              WHERE utilisateur_id = ? AND type_transaction = 'vente'";
                $stmt_ventes = $pdo->prepare($sql_ventes);
                $stmt_ventes->execute([$utilisateur_id]);
                $total_ventes = $stmt_ventes->fetch()['total_ventes'] ?? 0; // Default to 0 if null

                $bilan = $total_ventes - $total_achats;
                $bilan_class = $bilan >= 0 ? 'text-success' : 'text-danger'; // Classe Bootstrap pour le bilan

                echo "<h2>Résumé des transactions pour " . $nom_utilisateur . "</h2>";
                echo '<ul class="list-group">';
                echo '<li class="list-group-item d-flex justify-content-between align-items-center">Total des achats: <span class="badge bg-danger rounded-pill">' . number_format($total_achats, 2, ',', ' ') . ' €</span></li>';
                echo '<li class="list-group-item d-flex justify-content-between align-items-center">Total des ventes: <span class="badge bg-success rounded-pill">' . number_format($total_ventes, 2, ',', ' ') . ' €</span></li>';
                echo '<li class="list-group-item d-flex justify-content-between align-items-center fw-bold">Bilan: <span class="' . $bilan_class . '">' . number_format($bilan, 2, ',', ' ') . ' €</span></li>';
                echo '</ul>';
                
            } catch(PDOException $e) {
                echo '<div class="alert alert-danger" role="alert">Erreur: ' . $e->getMessage() . '</div>';
            }
            // Ajout de liens de navigation
            echo '<div class="mt-3">';
            echo '<a href="transactions_utilisateur.php?utilisateur_id=' . $utilisateur_id . '" class="btn btn-info">Voir Transactions Détaillées</a> ';
            echo '<a href="liste_utilisateurs.php" class="btn btn-secondary">Retour à la liste</a>';
            echo '</div>';

        } else {
            echo '<div class="alert alert-warning" role="alert">ID utilisateur non spécifié.</div>';
            echo '<a href="liste_utilisateurs.php" class="btn btn-primary">Retour à la liste des utilisateurs</a>';
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
