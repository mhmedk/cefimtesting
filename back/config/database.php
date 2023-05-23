<?php
// Paramètres de connexion à la base de données
$serveur = "localhost"; // Serveur de la base de données
$utilisateur = "root"; // Nom d'utilisateur de la base de données
$motDePasse = "root"; // Mot de passe de la base de données
$nomBaseDeDonnees = "bewdev"; // Nom de la base de données

try {
    // Connexion à la base de données
    $dsn = "mysql:host=$serveur;dbname=$nomBaseDeDonnees;charset=utf8mb4";
    $bdd = new PDO($dsn, $utilisateur, $motDePasse);

    // Configurer le mode d'erreur de PDO sur Exception
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // La connexion a été établie avec succès
    echo "Connexion réussie à la base de données !";

    // ... Vous pouvez maintenant exécuter des requêtes SQL ou effectuer d'autres opérations sur la base de données ...
} catch (PDOException $e) {
    // En cas d'erreur de connexion
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}
?>
