<?php
// Inclure le fichier de configuration
require_once '../../config/database.php';
require_once '../function/requete.php';

// Récupérer les données du formulaire
if ($_POST['promotion']){
    if(learnerCount($bdd) < 25){
        $promotion = $_POST['promotion'];
        $name = $_POST['name'];
        $firstname = $_POST['firstname'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $skills = $_POST['skills'];
        
        insertLearner($promotion, $name, $firstname, $gender, $age, $skills, $bdd);
        header("Location: ../../index.php?reg_err=addLearner");
        exit(); 
    }else {
        header("Location: ../../index.php?reg_err=session");
    }
} else{
    // Vérifier si le nombre d'apprenants est inférieur à 25
    if(learnerCount($bdd) < 25){
        $targetDir = '../uploads/';
        $targetFile = $targetDir . basename($_FILES['jsonFile']['name']);
        $uploadOk = true;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Vérifier si le fichier est au format JSON
        if ($fileType !== 'json') {
            echo "Seuls les fichiers JSON sont autorisés.";
            $uploadOk = false;
        }

        // Vérifier si l'envoi du fichier s'est bien passé
        if ($uploadOk) {
            if (move_uploaded_file($_FILES['jsonFile']['tmp_name'], $targetFile)) {
                $jsonData = file_get_contents($targetFile);
                $decodedData = json_decode($jsonData, true);
                foreach ($decodedData as $count) {
                    $promotion = $count['promotion'];
                    $name = $count['name'];
                    $firstname = $count['firstname'];
                    $gender = $count['gender'];
                    $age = $count['age'];
                    $skills = $count['skills'];
                
                    // Vérifier si le nombre d'apprenants est inférieur à 25
                    insertLearner($promotion, $name, $firstname, $gender, $age, $skills, $bdd);
                }
                header("Location: ../../index.php?reg_err=addLearner");
                exit(); 
            } else {
                echo "Erreur lors de la lecture du fichier JSON.";
            }
        } else {
            echo "Une erreur s'est produite lors du téléchargement du fichier.";
        }
    }
}


?>
