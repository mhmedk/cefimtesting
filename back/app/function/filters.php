<?php
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
    //shuffle($manApprenants);
    //shuffle($womanApprenants);

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

    // Mélanger les apprenants de chaque groupe
    //shuffle($apprenantsBack);
    //shuffle($apprenantsFront);

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