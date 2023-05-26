<?php
require_once './config/database.php';
require_once './app/function/requete.php';
require_once './app/function/filters.php';

$apprenants = selectLearner($bdd);
$apprenantsAge = learnerAge($bdd);

/**
 * Fonction pour créer des groupes avec ou sans options de filtrages.
 *
 * @param array $apprenants Les données des apprenants sous forme de tableau associatif.
 * @param int $groupSize Le nombre d'apprenants par groupe.
 * @param boolean $genderFilter Savoir si le filtre es actif.
 * @return array Les groupes formés avec les apprenants répartis avec le filtre.
 */
function createGroups($apprenants, $groupSize, $genderFilter, $skillsFilter, $ageFilter, $apprenantsAge) {
    // Mélanger les apprenants aléatoirement
    shuffle($apprenants);
    $groupSize = intval($groupSize);

    if($genderFilter || $ageFilter || $skillsFilter){
        if($genderFilter){
            return genderFilter($apprenants, $groupSize);
        }
        if($skillsFilter){
            return skillsFilter($apprenants, $groupSize);
        }
        if($ageFilter){
            return groupsAge($apprenantsAge, $groupSize);
        }

        if($genderFilter && $ageFilter){
        }
        if($genderFilter && $skillsFilter){
            //return genderAndSkillsFilter($apprenants, $groupSize);
        }
        
       
        if($ageFilter && $skillsFilter){
        }
        if($genderFilter && $ageFilter && $skillsFilter){
        }

    }else{
        return groupsNoFilter($apprenants, $groupSize);
    }
}


// Récupérer le nombre maximum d'apprenants par groupe depuis les paramètres de la requête
$maxApprenantsPerGroup = isset($_GET['maxApprenantsPerGroup']) ? intval($_GET['maxApprenantsPerGroup']) : 0;
$genderFilter = isset($_GET['genderfilter']) ? filter_var($_GET['genderfilter'], FILTER_VALIDATE_BOOLEAN) : false;
$skillsFilter = isset($_GET['skillsFilter']) ? filter_var($_GET['skillsFilter'], FILTER_VALIDATE_BOOLEAN) : false;
$ageFilter = isset($_GET['ageFilter']) ? filter_var($_GET['ageFilter'], FILTER_VALIDATE_BOOLEAN) : false;

// Vérifier la validité du nombre maximum d'apprenants par groupe
if ($maxApprenantsPerGroup <= 0) {
    die('Le nombre maximum d\'apprenants par groupe doit être un nombre entier positif.');
}

// Calculer le groupSize en fonction du nombre maximum d'apprenants par groupe et le nombre total d'apprenants
$groupSize = min($maxApprenantsPerGroup, count($apprenants));

// Créer les groupes
$groups = createGroups($apprenants, $groupSize, $genderFilter, $skillsFilter, $ageFilter, $apprenantsAge);

// Renvoyer les groupes sous forme de données JSON
header('Content-Type: application/json');
echo json_encode($groups);
?>