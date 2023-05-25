<?php
require_once './config/database.php';
require_once './app/function/requete.php';

$apprenants = selectLearner($bdd);

/**
 * Fonction pour créer des groupes avec ou sans options de filtrages.
 *
 * @param array $apprenants Les données des apprenants sous forme de tableau associatif.
 * @param int $groupSize Le nombre d'apprenants par groupe.
 * @param boolean $genderFilter Savoir si le filtre es actif.
 * @return array Les groupes formés avec les apprenants répartis avec le filtre.
 */
function createGroups($apprenants, $groupSize, $genderFilter, $skillsFilter) {
    // Mélanger les apprenants aléatoirement
    shuffle($apprenants);
    $groupSize = intval($groupSize);

    
    if ($genderFilter) {
        return genderFilter($apprenants, $groupSize);
    } else if ($skillsFilter) {
        return skillsFilter($apprenants, $groupSize);
    } else {
        return groupsNoFilter($apprenants, $groupSize);
    }
    
}

/**
 * Fonction pour créer des groupes sans options de filtrages.
 *
 * @param array $apprenants Les données des apprenants sous forme de tableau associatif.
 * @param int $groupSize Le nombre d'apprenants par groupe.
 * @return array Les groupes formés avec les apprenants.
 */
function groupsNoFilter($apprenants, $groupSize,){
    // Calculer le nombre de groupes nécessaires
    $numGroups = ceil(count($apprenants) / $groupSize);

    $groups = array();

    // Générer les groupes
    for ($i = 0; $i < $numGroups; $i++) {
        $groups[] = array_slice($apprenants, $i * $groupSize, $groupSize);
    }

    return $groups;    
}

/**
 * Fonction pour créer des groupes mixtes en répartissant les apprenants par genre.
 *
 * @param array $apprenants Les données des apprenants sous forme de tableau associatif.
 * @param int $groupSize Le nombre d'apprenants par groupe.
 * @return array Les groupes mixtes formés avec les apprenants répartis par genre.
 */
function genderFilter($apprenants, $groupSize) {
    // Trier les apprenants par genre
    $manApprenants = array_filter($apprenants, function($apprenant) {
        return $apprenant['gender'] === 'man';
    });
    $womanApprenants = array_filter($apprenants, function($apprenant) {
        return $apprenant['gender'] === 'woman';
    });

    // Mélanger les apprenants de chaque genre
    shuffle($manApprenants);
    shuffle($womanApprenants);

    // Créer les groupes mixtes
    $mixedGroup = [];
    $numGroups = ceil(count($apprenants) / $groupSize);

    for ($i = 0; $i < $numGroups; $i++) {
        $group = [];

        // Ajouter des apprenants de genre masculin dans le groupe
        $manCount = min(ceil($groupSize / 2), count($manApprenants));
        $group = array_merge($group, array_splice($manApprenants, 0, $manCount));

        // Ajouter des apprenants de genre féminin dans le groupe
        $womanCount = min($groupSize - count($group), count($womanApprenants));
        $group = array_merge($group, array_splice($womanApprenants, 0, $womanCount));

        // Ajouter le groupe à la liste des groupes
        $mixedGroup[] = $group;
    }

    // Ajouter les apprenants restants à un dernier groupe
    $remainingGroup = array_merge($manApprenants, $womanApprenants);
    if (!empty($remainingGroup)) {
        $mixedGroup[] = $remainingGroup;
    }

    return $mixedGroup;
}

/**
 * Fonction pour créer des groupes mixtes en répartissant les apprenants par compétences.
 *
 * @param array $apprenants Les données des apprenants sous forme de tableau associatif.
 * @param int $groupSize Le nombre d'apprenants par groupe.
 * @return array Les groupes mixtes formés avec les apprenants répartis par genre.
 */
function skillsFilter($apprenants, $groupSize) {
    // Trier les apprenants par compétences
    $apprenantsBack = array_filter($apprenants, function($apprenant) {
        return $apprenant['skills'] === 'PHP' || $apprenant['skills'] === 'JAVA';
    });
    $apprenantsFront = array_filter($apprenants, function($apprenant) {
        return $apprenant['skills'] === 'HTML' || $apprenant['skills'] === 'CSS';
    });

    // Mélanger les apprenants de chaque groupe
    shuffle($apprenantsBack);
    shuffle($apprenantsFront);

    // Créer les groupes mixtes
    $mixedGroup = [];
    $numGroups = ceil(count($apprenants) / $groupSize);

    for ($i = 0; $i < $numGroups; $i++) {
        $group = [];

        // Ajouter des apprenants back dans le groupe
        $backCount = min(ceil($groupSize / 2), count($apprenantsBack));
        $group = array_merge($group, array_splice($apprenantsBack, 0, $backCount));

        // Ajouter des apprenants front dans le groupe
        $frontCount = min($groupSize - count($group), count($apprenantsFront));
        $group = array_merge($group, array_splice($apprenantsFront, 0, $frontCount));

        // Ajouter le groupe à la liste des groupes
        $mixedGroup[] = $group;
    }

    // Ajouter les apprenants restants à un dernier groupe
    $remainingGroup = array_merge($apprenantsBack, $apprenantsFront);
    if (!empty($remainingGroup)) {
        $mixedGroup[] = $remainingGroup;
    }

    return $mixedGroup;
}

// Récupérer le nombre maximum d'apprenants par groupe depuis les paramètres de la requête
$maxApprenantsPerGroup = isset($_GET['maxApprenantsPerGroup']) ? intval($_GET['maxApprenantsPerGroup']) : 0;
// Récupérer les différents filtres depuis les paramètres de la requête
$genderFilter = isset($_GET['genderfilter']) ? filter_var($_GET['genderfilter'], FILTER_VALIDATE_BOOLEAN) : false;
$skillsFilter = isset($_GET['skillsFilter']) ? filter_var($_GET['skillsFilter'], FILTER_VALIDATE_BOOLEAN) : false;


// Vérifier la validité du nombre maximum d'apprenants par groupe
if ($maxApprenantsPerGroup <= 0) {
    die('Le nombre maximum d\'apprenants par groupe doit être un nombre entier positif.');
}

// Calculer le groupSize en fonction du nombre maximum d'apprenants par groupe et le nombre total d'apprenants
$groupSize = min($maxApprenantsPerGroup, count($apprenants));

// Créer les groupes
$groups = createGroups($apprenants, $groupSize, $genderFilter, $skillsFilter);

// var_dump($groups);

// // Renvoyer les groupes sous forme de données JSON
header('Content-Type: application/json');
echo json_encode($groups);
?>