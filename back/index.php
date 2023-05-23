<?php
if(isset($_GET['reg_err']))
{
    $err = htmlspecialchars($_GET['reg_err']);

    switch($err)
    {
        case 'success':
            echo "Seccess";
        break;

        case 'down':
            echo "Erreur BDD";
            break;
        
        case 'Bug':
            echo "Bug post";
            break;
        
        case 'session':
            echo "Session pleinne";
            break;
        
        case 'addLearner':
            echo "Apprenant ajouté avec succès.";
            break;
        
        case '!addLearner':
            echo "Erreur lors de l'ajout de l'apprenant.";
            break;
        
        case 'Learner':
            echo "cette apprenant est deja dans la session.";
            break;   

    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un apprenant</title>
</head>
<body>
    <h1>Ajouter un apprenant</h1>

    <form action="/app/controllers/learnerControllers.php" method="POST">
        <label for="promotion">Promotion :</label>
        <input type="text" name="promotion" id="promotion" required>
        
        <label for="nom">Nom :</label>
        <input type="text" name="name" id="name" required>
        
        <label for="prenom">Prénom :</label>
        <input type="text" name="firstname" id="firstname" required>
        
        <label for="sexe">Sexe :</label>
        <select name="gender" id="gender" required>
            <option value="Masculin">Masculin</option>
            <option value="Féminin">Féminin</option>
        </select>
        
        <label for="age">Âge :</label>
        <input type="number" name="age" id="age" required>
        
        <label for="competences">Compétences :</label>
        <input type="text" name="skills" id="skills" required>
        
        <input type="submit" value="Ajouter">
    </form>
    <br>
    <br>
    <br>

    <h2>Formulaire d'envoi de fichier JSON</h2>
    <form action="back/app/controllers/test.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="jsonFile" accept=".json" required>
        <br><br>
        <input type="submit" value="Envoyer">
    </form>
</body>
</html>
