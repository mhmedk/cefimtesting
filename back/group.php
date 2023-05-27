<?php
require_once './config/database.php';
require_once './app/function/requete.php';
require_once './app/function/filters.php';

// Get learners in database
$apprenants = selectLearner($bdd);

/**
 * Function to create groups based on filters
 *
 * @param array $apprenants Learner data in the form of an associative table
 * @param int $groupSize Number of learners per group
 * @param boolean $genderFilter Find out if the filter is active
 * @param boolean $skillsFilter Find out if the filter is active
 * @param boolean $ageFilter Find out if the filter is active
 * @return array Groups formed with learners divided into
 */
function createGroups($apprenants, $groupSize, $genderFilter, $skillsFilter, $ageFilter) {

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
            return groupsAge($apprenants, $groupSize);
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
$genderFilter = isset($_GET['genderFilter']) ? filter_var($_GET['genderFilter'], FILTER_VALIDATE_BOOLEAN) : false;
$skillsFilter = isset($_GET['skillsFilter']) ? filter_var($_GET['skillsFilter'], FILTER_VALIDATE_BOOLEAN) : false;
$ageFilter = isset($_GET['ageFilter']) ? filter_var($_GET['ageFilter'], FILTER_VALIDATE_BOOLEAN) : false;

// Vérifier la validité du nombre maximum d'apprenants par groupe
if ($maxApprenantsPerGroup <= 0) {
    die('Le nombre maximum d\'apprenants par groupe doit être un nombre entier positif.');
}

// Calculer le groupSize en fonction du nombre maximum d'apprenants par groupe et le nombre total d'apprenants
$groupSize = min($maxApprenantsPerGroup, count($apprenants));

// Créer les groupes
$groups = createGroups($apprenants, $groupSize, $genderFilter, $skillsFilter, $ageFilter);

// Renvoyer les groupes sous forme de données JSON
header('Content-Type: application/json');
echo json_encode($groups);
?>