<!DOCTYPE html>
<html>
<head>
    <title>Liste des utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php require_once 'navbar.php'; ?>
    <div class="container mt-5">
        <h2>Liste des utilisateurs</h2>
        <?php
        require_once 'connexion.php';

        try {
            $sql = "SELECT id, nom, email FROM utilisateurs";
            $stmt = $pdo->query($sql);
            
            echo "<table class='table table-striped table-bordered'>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>";
            
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['nom']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>
                            <a href='modifier_utilisateur.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Modifier</a>
                            <a href='supprimer_utilisateur.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet utilisateur ?\");'>Supprimer</a>
                            <a href='transactions_utilisateur.php?utilisateur_id=" . $row['id'] . "' class='btn btn-success btn-sm'>Voir Transactions</a>
                            <a href='totaux_utilisateur.php?utilisateur_id=" . $row['id'] . "' class='btn btn-info btn-sm'>Voir Totaux</a>
                        </td>
                    </tr>";
            }
            echo "</tbody></table>";
        } catch(PDOException $e) {
            echo '<div class="alert alert-danger" role="alert">Erreur: ' . $e->getMessage() . '</div>';
        }
        ?>
        <a href="ajouter_utilisateur.php" class="btn btn-primary">Ajouter un utilisateur</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
