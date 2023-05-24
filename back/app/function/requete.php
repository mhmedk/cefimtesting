<?php
require_once '../../config/database.php';
require_once '../controllers/learnerControllers.php';

/**
 * $apprenants = formatLearner();
 * Fonction pour compter le nombre total d'apprenants dans la base de données.
 * @param PDO $bdd L'objet de connexion à la base de données.
 * @return int Le nombre total d'apprenants.
 */
function learnerCount($bdd){
    try {
        // Préparer la requête PDO
        $sess = $bdd->prepare("SELECT COUNT(*) AS total FROM apprenants;");
        // Exécuter la requête
        $sess->execute();
        // Récupérer le nombre de personnes
        $result = $sess->fetch(PDO::FETCH_ASSOC);
        $total = $result['total'];
        return $total;
    } catch (PDOException $e) {
        echo "Erreur PDO lors de la préparation de la requête : " . $e->getMessage();
    }
}

/**
 * Fonction pour insérer les informations d'un nouvel apprenant dans la base de données.
 * @param string $promotion La promotion de l'apprenant.
 * @param string $name Le nom de l'apprenant.
 * @param string $firstname Le prénom de l'apprenant.
 * @param string $gender Le genre de l'apprenant.
 * @param int $age L'âge de l'apprenant.
 * @param string $skills Les compétences de l'apprenant.
 * @param PDO $bdd L'objet de connexion à la base de données.
 */
function insertLearner($promotion, $name, $firstname, $gender, $age, $skills, $bdd)
{
    try {
        // Préparer la requête PDO avec deux paramètres nommés ":nom" et ":prenom"
        $select = $bdd->prepare("SELECT name, firstname FROM apprenants WHERE name = :name AND firstname = :firstname");

        // Lier les valeurs des variables $nom et $prenom aux paramètres nommés ":nom" et ":prenom"
        $select->bindValue(':name', $name, PDO::PARAM_STR);
        $select->bindValue(':firstname', $firstname, PDO::PARAM_STR);

        // Exécuter la requête
        $select->execute();

        // Récupérer les résultats de la requête
        $resultats = $select->fetchAll(PDO::FETCH_ASSOC);

        // Vérifier si des données ont été récupérées
        if (empty($resultats)) {

            $select->execute();
            // Préparer la requête PDO
            $insert = $bdd->prepare("INSERT INTO apprenants (promotion, name, firstname, gender, age, skills) 
                                  VALUES (:promotion, :name, :firstname, :gender, :age, :skills)");

            
            // Exécuter la requête
            $insert->execute(array(
                ':promotion' => $promotion,
                ':name' => $name,
                ':firstname' => $firstname,
                ':gender' => $gender,
                ':age' => $age,
                ':skills' => $skills
            ));
        } else{
            header("Location: ../../../front/index.php?reg_err=Learner");
            exit(); 
        }
    } catch (PDOException $e) {
        header("Location: ../../../front/index.php");
        echo "Erreur PDO lors de la préparation de la requête : " . $e->getMessage();
        exit(); 
    }
}

function formatLearner(){
    require_once '../../config/database.php';
    $apprenantsResults = selectLearner($bdd);
    $apprenants = [];
    foreach ($apprenantsResults as $row) {
        $formattedRow = [
            'promotion' => $row['promotion'],
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'sexe' => $row['sexe'],
            'age' => intval($row['age']),
            'competences' => explode(',', $row['competences'])
        ];
        $apprenants[] = $formattedRow;
    }
    return $apprenants;
}

/**
 * Fonction pour sélectionner tous les apprenants dans la base de données.
 * @param PDO $bdd L'objet de connexion à la base de données.
 * @return array Les données des apprenants sous forme de tableau associatif.
 */
function selectLearner($bdd){
    try {
        // Préparer la requête PDO
        $select = $bdd->prepare("SELECT * FROM apprenants;");
        // Exécuter la requête
        $select->execute();
        // Récupérer le nombre de personnes
        $result = $select->fetch(PDO::FETCH_ASSOC);
       return $result;
    } catch (PDOException $e) {
        echo "Erreur PDO lors de la préparation de la requête : " . $e->getMessage();
    }
}


?>