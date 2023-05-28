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
function createGroups($apprenants, $groupSize, $genderFilter, $ageFilter, $skillsFilter) {

    // Mix learners randomly
    shuffle($apprenants);

    // Check if a filter has been applied
    if ($genderFilter && $ageFilter && $skillsFilter) {
        // return ...
    } elseif ($genderFilter && $ageFilter) {
        // return ...
    } elseif ($genderFilter && $skillsFilter) {
        // return ...
    } elseif ($ageFilter && $skillsFilter) {
        // return ...
    } elseif ($genderFilter) {
        return genderFilter($apprenants, $groupSize);
    } elseif ($ageFilter) {
        return groupsAge($apprenants, $groupSize);
    } elseif ($skillsFilter) {
        return skillsFilter($apprenants, $groupSize);
    } else {
        return groupsNoFilter($apprenants, $groupSize);
    };

};

// Retrieve the desired number of learners per group
$maxApprenantsPerGroup = isset($_GET['maxApprenantsPerGroup']) ? intval($_GET['maxApprenantsPerGroup']) : 0;

// Retrieve filter checkbox values
$genderFilter = isset($_GET['genderFilter']) ? filter_var($_GET['genderFilter'], FILTER_VALIDATE_BOOLEAN) : false;
$ageFilter = isset($_GET['ageFilter']) ? filter_var($_GET['ageFilter'], FILTER_VALIDATE_BOOLEAN) : false;
$skillsFilter = isset($_GET['skillsFilter']) ? filter_var($_GET['skillsFilter'], FILTER_VALIDATE_BOOLEAN) : false;

// Check that the number of learners is not negative, or 0
if ($maxApprenantsPerGroup <= 0) {
    die('Le nombre maximum d\'apprenants par groupe doit être un nombre entier positif.');
};

// Ensure that the desired number of learners per group does not exceed the total number of learners in the database
$groupSize = min($maxApprenantsPerGroup, count($apprenants));

// Create groups
$groups = createGroups($apprenants, $groupSize, $genderFilter, $ageFilter, $skillsFilter);

// Return groups as JSON data
header('Content-Type: application/json');
echo json_encode($groups);
?>