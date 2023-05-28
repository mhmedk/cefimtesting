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

    // Alternates between the 2 groups
    if (count($maleLearners) > count($femaleLearners)) {
        $toPick = 'man';
    } else {
        $toPick = 'woman';
    };

    // Index for each group
    $manI = 0;
    $womanI = 0;

    for ($i=0; $i < $numGroups; $i++) {

        $group = array();

        for ($j=0; $j < $groupSize; $j++) {

            // If there are more men than women, we start with the group of men and add him to the group
            if ($toPick === 'man') {
                $group[] = $maleLearners[$manI];
                $toPick = 'woman';
                $manI++;
            } else {
                // If there are more women than men, we check that the learner exists and add her to the group
                if (isset($femaleLearners[$womanI])) {
                    $group[] = $femaleLearners[$womanI];
                    $toPick = 'man';
                    $womanI++;
                } elseif (isset($maleLearners[$manI])) {
                    // Otherwise, if it was the women's turn and there were none left, add another man
                    $group[] = $maleLearners[$manI];
                    $toPick = 'woman';
                    $manI++;
                }
            }

        }

        $groups[] = $group;

    }

    return $groups;
}

/**
 * Fonction pour créer des groupes mixtes en répartissant les apprenants par compétences.
 *
 * @param array $apprenants Les données des apprenants sous forme de tableau associatif.
 * @param int $groupSize Le nombre d'apprenants par groupe.
 * @return array Les groupes mixtes formés avec les apprenants répartis par compétences.
 */
function skillsFilter ($apprenants, $groupSize) {
    // Trier les apprenants par compétences
    $apprenantsBack = array_filter($apprenants, function($apprenant) {
        return $apprenant['skills'] === 'PHP' || $apprenant['skills'] === 'JAVA';
    });
    $apprenantsFront = array_filter($apprenants, function($apprenant) {
        return $apprenant['skills'] === 'HTML' || $apprenant['skills'] === 'CSS';
    });

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

/**
 * Fonction pour créer des groupes mixtes en répartissant les apprenants par ages.
 *
 * @param array $apprenantsAge Les données des apprenants sous forme de tableau associatif trier ages.
 * @param int $groupSize Le nombre d'apprenants par groupe.
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