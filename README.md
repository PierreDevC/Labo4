# Gestionnaire de Base de Données PHP

Application PHP simple permettant de gérer des utilisateurs et leurs transactions.

## Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache, Nginx, etc.)

## Installation

1. Clonez le dépôt :
```bash
git clone https://github.com/PierreDevC/Labo4.git
```

2. Créez une base de données MySQL et importez le schéma :
```sql
CREATE TABLE utilisateurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    type_transaction ENUM('achat', 'vente') NOT NULL,
    date_transaction DATETIME NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);
```

3. Configurez la connexion à la base de données dans `connexion.php` :
```php
$host = 'localhost';
$dbname = 'votre_base_de_donnees';
$username = 'votre_utilisateur';
$password = 'votre_mot_de_passe';
```

4. Placez les fichiers dans votre répertoire web

## Utilisation

1. Accédez à `index.php` dans votre navigateur
2. Commencez par créer un utilisateur
3. Gérez les transactions pour chaque utilisateur
4. Consultez les statistiques dans la section totaux

## Fonctionnalités

- Gestion CRUD des utilisateurs
- Ajout et consultation des transactions
- Calcul des totaux par utilisateur
- Interface simple et intuitive
