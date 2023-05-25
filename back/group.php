<?php
require_once './config/database.php';
require_once './app/function/requete.php';
require_once './app/function/filters.php';

$apprenants = selectLearner($bdd);

/**
 * Fonction pour créer des groupes avec ou sans options de filtrages.
 *
 * @param array $apprenants Les données des apprenants sous forme de tableau associatif.
 * @param int $groupSize Le nombre d'apprenants par groupe.
 * @param boolean $genderFilter Savoir si le filtre es actif.
 * @return array Les groupes formés avec les apprenants répartis avec le filtre.
 */
function createGroups($apprenants, $groupSize, $genderFilter) {
    // Mélanger les apprenants aléatoirement
    shuffle($apprenants);
    $groupSize = intval($groupSize);

    $ageFilter = false;
    $skillsFilter = false;

    if($genderFilter || $ageFilter || $skillsFilter){
        if($genderFilter){
            return genderFilter($apprenants, $groupSize);
        }
        if($ageFilter){
            //return ageFilter($apprenants, $groupSize);
        }
        if($skillsFilter){
            //return skillsFilter($apprenants, $groupSize);
        }
    }else{
        return groupsNoFilter($apprenants, $groupSize);
    }
    
}



// Récupérer le nombre maximum d'apprenants par groupe depuis les paramètres de la requête
$maxApprenantsPerGroup = isset($_GET['maxApprenantsPerGroup']) ? intval($_GET['maxApprenantsPerGroup']) : 0;
$genderFilter = isset($_GET['genderfilter']) ? filter_var($_GET['genderfilter'], FILTER_VALIDATE_BOOLEAN) : false;


// Vérifier la validité du nombre maximum d'apprenants par groupe
if ($maxApprenantsPerGroup <= 0) {
    die('Le nombre maximum d\'apprenants par groupe doit être un nombre entier positif.');
}

// Calculer le groupSize en fonction du nombre maximum d'apprenants par groupe et le nombre total d'apprenants
$groupSize = min($maxApprenantsPerGroup, count($apprenants));

// Créer les groupes
$groups = createGroups($apprenants, $groupSize, $genderFilter);

// Renvoyer les groupes sous forme de données JSON
header('Content-Type: application/json');
echo json_encode($groups);
?>