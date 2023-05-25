<?php
require_once './config/database.php';
require_once './app/function/requete.php';

$apprenants = selectLearner($bdd);
$apprenantsAge = learnerAge($bdd);


// Fonction pour constituer les groupes
/* function createGroups($apprenants, $groupSize) {
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
} */
function createGroups($apprenantsAge, $groupSize, $ageFilter) {
    // Mélanger les apprenants aléatoirement
    $groupSize = intval($groupSize);

    if($ageFilter){
        return groupsAge($apprenantsAge, $groupSize);
    }else{
        shuffle($apprenantsAge);
        return groupsNoFilter($apprenantsAge, $groupSize);
    }
    
}
function groupsNoFilter($apprenants, $groupSize){
    // Calculer le nombre de groupes nécessaires
    $numGroups = ceil(count($apprenants) / $groupSize);

    $groups = array();

    // Générer les groupes
    for ($i = 0; $i < $numGroups; $i++) {
        $groups[] = array_slice($apprenants, $i * $groupSize, $groupSize);
    }

    return $groups;    
}
function groupsAge($apprenantsAge, $groupSize) {
    
    // Calculer le nombre de groupes nécessaires
    $numGroups = ceil(count($apprenantsAge) / $groupSize);

    //tableau vide
    $groupsAge = array();

    //tableau de jeune en découpant la liste $apprenantsAge et qui retourne 
    $young = array_filter($apprenantsAge, function($apprenant) {
        return $apprenant['age'] < 30;
    });

    //tableau de vieux en découpant la liste $apprenantsAge et qui retourne
    $old = array_filter($apprenantsAge, function($apprenant) {
        return $apprenant['age'] > 30;
    });
    var_dump($young);
    var_dump($old);


    for ($i = 0; $i < $numGroups; $i++) {
        $group = [];

        // Ajouter des apprenants jeune dans le groupe
        $youngCont = min(ceil($groupSize / 2), count($young));
        $group = array_merge($group, array_splice($young, 0, $youngCont));

        // Ajouter des apprenants vieux dans le groupe
        $oldCount = min($groupSize - count($group), count($old));
        $group = array_merge($group, array_splice($old, 0, $oldCount));

        // Ajouter le groupe à la liste des groupes
        $groupsAge[] = $group;
    }

    // Ajouter les apprenants restants à un dernier groupe
    $remainingGroup = array_merge($young, $old);
    if (!empty($remainingGroup)) {
        $groupsAge[] = $remainingGroup;
    }

    return $groupsAge;
}

// Récupérer le nombre maximum d'apprenants par groupe depuis les paramètres de la requête
$maxApprenantsPerGroup = isset($_GET['maxApprenantsPerGroup']) ? intval($_GET['maxApprenantsPerGroup']) : 0;

// Vérifier la validité du nombre maximum d'apprenants par groupe
if ($maxApprenantsPerGroup <= 0) {
    die('Le nombre maximum d\'apprenants par groupe doit être un nombre entier positif.');
}

// Calculer le groupSize en fonction du nombre maximum d'apprenants par groupe et le nombre total d'apprenants
$groupSize = min($maxApprenantsPerGroup, count($apprenantsAge));

// Créer les groupes
$ageFilter = isset($_GET['ageFilter']) ? filter_var($_GET['ageFilter'], FILTER_VALIDATE_BOOLEAN) : false;
$groups = createGroups($apprenantsAge, $groupSize, $ageFilter);

// Renvoyer les groupes sous forme de données JSON
//header('Content-Type: application/json');
//echo json_encode($groups);
?>
