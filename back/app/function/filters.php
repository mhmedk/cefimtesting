<?php
/**
 * Function to create groups without filtering options
 *
 * @param array $apprenants Learners data in the form of an associative table
 * @param int $groupSize Number of learners per group
 * @return array Groups formed with learners
 */
function groupsNoFilter($apprenants, $groupSize){

    // Calculate the number of groups required
    $numGroups = ceil(count($apprenants) / $groupSize);

    // Create final array
    $groups = array();

    // Generate groups
    for ($i = 0; $i < $numGroups; $i++) {

        // Pour chaque groupe, extraire du tableau d'apprenants, le nombre d'apprenants souhaité
        $groups[] = array_slice($apprenants, $i * $groupSize, $groupSize);

    };

    return $groups;
}

/**
 * Function for creating mixed groups of learners by gender
 *
 * @param array $apprenants Learners data in the form of an associative table
 * @param int $groupSize Number of learners per group
 * @return array Groups formed with learners by gender
 */
function genderFilter($apprenants, $groupSize) {

    // Separate learners by gender into 2 array
    $maleLearners = array();
    $femaleLearners = array();

    foreach ($apprenants as $apprenant) {
        if ($apprenant['gender'] === 'man') {
            $maleLearners[] = $apprenant;
        } else {
            $femaleLearners[] = $apprenant;
        }
    }

    // Create final array empty
    $groups = array();

    // Calculate the number of groups required
    $numGroups = ceil(count($apprenants) / $groupSize);

    // Pick the biggest group to start with
    if (count($maleLearners) > count($femaleLearners)) {
        $toPick = 'man';
    } else {
        $toPick = 'woman';
    };

    // Index for each group
    $backI = 0;
    $frontI = 0;

    for ($i=0; $i < $numGroups; $i++) {

        $group = array();

        for ($j=0; $j < $groupSize; $j++) {

            // If there are more men than women, we start with the group of men and add one to the group
            if ($toPick === 'man' && isset($maleLearners[$backI])) {
                $group[] = $maleLearners[$backI];
                $toPick = 'woman';
                $backI++;
            } else {
                // If there are more women than men, we check that the learner exists and add her to the group
                if (isset($femaleLearners[$frontI])) {
                    $group[] = $femaleLearners[$frontI];
                    $toPick = 'man';
                    $frontI++;
                } elseif (isset($maleLearners[$backI])) {
                    // Otherwise, if it was the women's turn and there were none left, add another man
                    $group[] = $maleLearners[$backI];
                    $toPick = 'woman';
                    $backI++;
                }
            }
        }

        $groups[] = $group;

    }
    return $groups;
}

/**
 * Function to create mixed groups of learners according to their skills
 *
 * @param array $apprenants Learners data in the form of an associative table
 * @param int $groupSize Number of learners per group
 * @return array Groups formed with learners by skills
 */
function skillsFilter ($apprenants, $groupSize) {

    // Separate learners by skills into 2 array
    $backLearners = array();
    $frontLearners = array();

    foreach ($apprenants as $apprenant) {
        if ($apprenant['skills'] === 'PHP' || $apprenant['skills'] === 'JAVA') {
            $backLearners[] = $apprenant;
        } else {
            $frontLearners[] = $apprenant;
        }
    }

    // Create final array empty
    $groups = array();

    // Calculate the number of groups required
    $numGroups = ceil(count($apprenants) / $groupSize);

    // Pick the biggest group to start with
    if (count($backLearners) > count($frontLearners)) {
        $toPick = 'back';
    } else {
        $toPick = 'front';
    };

    // Index for each group
    $backI = 0;
    $frontI = 0;

    for ($i=0; $i < $numGroups; $i++) {

        $group = array();

        for ($j=0; $j < $groupSize; $j++) {

            // If there are more back than front, we start with the group of back and add one to the group
            if ($toPick === 'back' && isset($backLearners[$backI])) {
                $group[] = $backLearners[$backI];
                $toPick = 'front';
                $backI++;
            } else {
                // If there are more front than back, we check that the learner exists and add him to the group
                if (isset($frontLearners[$frontI])) {
                    $group[] = $frontLearners[$frontI];
                    $toPick = 'back';
                    $frontI++;
                } elseif (isset($backLearners[$backI])) {
                    // Otherwise, if it was the front's turn and there were none left, add another man
                    $group[] = $backLearners[$backI];
                    $toPick = 'front';
                    $backI++;
                }
            }
        }

        $groups[] = $group;

    }
    return $groups;
}

/**
 * Fonction pour créer des groupes mixtes en répartissant les apprenants par ages.
 *
 * @param array $apprenants Learners data in the form of an associative table
 * @param int $groupSize Number of learners per group
 * @return array Les groupes mixtes formés avec les apprenants répartis par ages.
 */
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

?>