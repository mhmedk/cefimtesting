<?php
// Paramètres de connexion à la base de données
$serveur = "localhost"; // Serveur de la base de données
$utilisateur = "root"; // Nom d'utilisateur de la base de données
$motDePasse = ""; // Mot de passe de la base de données
$nomBaseDeDonnees = "bewved"; // Nom de la base de données

try {
    // Connexion à la base de données
    $dsn = "mysql:host=$serveur;dbname=$nomBaseDeDonnees;charset=utf8mb4";
    $bdd = new PDO($dsn, $utilisateur, $motDePasse);

    // Configurer le mode d'erreur de PDO sur Exception
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // En cas d'erreur de connexion
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}
?>
