<?php
/**
 * Function to create groups without filtering options
 *
 * @param array $apprenants Learners data in the form of an associative table
 * @param int $groupSize Number of learners per group
 * @return array Groups formed with learners
 */
function groupsNoFilter ($apprenants, $groupSize){

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
 * Function to create mixed groups of learners according to their gender
 *
 * @param array $apprenants Learners data in the form of an associative table
 * @param int $groupSize Number of learners per group
 * @return array Groups formed with learners by gender
 */
function genderFilter ($apprenants, $groupSize) {

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
 * Function to create mixed groups of learners according to their age
 *
 * @param array $apprenants Learners data in the form of an associative table
 * @param int $groupSize Number of learners per group
 * @return array Groups formed with learners by age
 */
function ageFilter ($apprenants, $groupSize) {

    // Separate learners by age into 2 array
    $youngerLearners = array();
    $olderLearners = array();

    foreach ($apprenants as $apprenant) {
        if ($apprenant['age'] <= 30) {
            $youngerLearners[] = $apprenant;
        } else {
            $olderLearners[] = $apprenant;
        }
    }

    // Create final array empty
    $groups = array();

    // Calculate the number of groups required
    $numGroups = ceil(count($apprenants) / $groupSize);

    // Pick the biggest group to start with
    if (count($youngerLearners) > count($olderLearners)) {
        $toPick = 'young';
    } else {
        $toPick = 'old';
    };

    // Index for each group
    $youngI = 0;
    $oldI = 0;

    for ($i=0; $i < $numGroups; $i++) {

        $group = array();

        for ($j=0; $j < $groupSize; $j++) {

            // If there are more young than old, we start with the group of young and add one to the group
            if ($toPick === 'young' && isset($youngLearners[$youngI])) {
                $group[] = $youngLearners[$youngI];
                $toPick = 'old';
                $youngI++;
            } else {
                // If there are more old than young, we check that the learner exists and add him to the group
                if (isset($oldLearners[$oldI])) {
                    $group[] = $oldLearners[$oldI];
                    $toPick = 'old';
                    $oldI++;
                } elseif (isset($youngLearners[$youngI])) {
                    // Otherwise, if it was the old's turn and there were none left, add another young
                    $group[] = $youngLearners[$youngI];
                    $toPick = 'old';
                    $youngI++;
                }
            }
        }

        $groups[] = $group;

    }
    return $groups;

}

?>