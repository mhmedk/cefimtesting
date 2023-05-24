<?php
require_once './config/database.php';
require_once './app/function/requete.php';

$apprenants = selectLearner($bdd);

// Fonction pour constituer les groupes
function createGroups($apprenants, $groupSize) {
    // Mélanger les apprenants aléatoirement
    shuffle($apprenants);

    // Calculer le nombre de groupes nécessaires
    $numGroups = ceil(count($apprenants) / $groupSize);

    $groups = array();

    // Générer les groupes
    for ($i = 0; $i < $numGroups; $i++) {
        $groups[] = array_slice($apprenants, $i * $groupSize, $groupSize);
    }

    return $groups;
}

// Récupérer le nombre maximum d'apprenants par groupe depuis les paramètres de la requête
$maxApprenantsPerGroup = isset($_GET['maxApprenantsPerGroup']) ? intval($_GET['maxApprenantsPerGroup']) : 0;

// Vérifier la validité du nombre maximum d'apprenants par groupe
if ($maxApprenantsPerGroup <= 0) {
    die('Le nombre maximum d\'apprenants par groupe doit être un nombre entier positif.');
}

// Calculer le groupSize en fonction du nombre maximum d'apprenants par groupe et le nombre total d'apprenants
$groupSize = min($maxApprenantsPerGroup, count($apprenants));

// Créer les groupes
$groups = createGroups($apprenants, $groupSize);

// Renvoyer les groupes sous forme de données JSON
header('Content-Type: application/json');
echo json_encode($groups);
?>
