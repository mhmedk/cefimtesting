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

<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BewVed - Gestion groupe</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/favicon/site.webmanifest">
    <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="img/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="img/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!-- /Favicons -->
  </head>

  <body class="d-flex flex-column h-100"> 
  <header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-body-tertiary ">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="img/logo_cefim.png" class="logo img-fluid" alt="Logo CEFIM"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Formulaire apprenant</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="groupCreation.html">Création groupe</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Begin page content -->
  <main class="flex-shrink-0">
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-5">
          <h2 class="mt-5 ">Formulaire de saisie des apprenants </h2>
          <form class="col-10 col-xs-5" method="post" action="../back/app/controllers/learnerControllers.php">
            <!--Nom-->
              <div class="mb-4 mt-4">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                      <label for="name" class="col-form-label">Nom : </label>
                    </div>
                    <div class="col-auto">
                      <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                  </div>
              </div>
              <!--Prénom-->
              <div class="mb-4 mt-4">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                      <label for="firstName" class="col-form-label">Prénom : </label>
                    </div>
                    <div class="col-auto">
                      <input type="text" name="firstname" id="firstname" class="form-control" required>
                    </div>
                  </div>
              </div>
              <!--Promotion-->
              <div class="mb-4 mt-4">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                      <label for="promotion" class="col-form-label">Promotion : </label>
                    </div>
                    <div class="col-auto">
                      <input type="number" name="promotion" id="promotion" class="form-control" required>
                    </div>
                  </div>
              </div>
              <!--Sexe-->
              <div class="mb-3">
                <label for="gender" class="form-label">Sexe : </label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="man" id="man">
                  <label class="form-check-label" for="man">
                    Homme
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="woman" id="woman">
                  <label class="form-check-label" for="woman">
                    Femme
                  </label>
                </div>
              </div>
              <!--Age-->
              <div class="mb-4 mt-4">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                      <label for="age" class="col-form-label">Âge : </label>
                    </div>
                    <div class="col-auto">
                      <input type="number" name="age" id="age" class="form-control" required>
                    </div>
                  </div>
              </div>
              <!--Compétences-->
              <div class="mb-3">
                <label for="skills" class="form-label">Compétences : </label>
                <input class="form-control"  name="skills" id="skills" rows="2" required>
              </div>
              <button type="submit" class="btn btn-primary">Envoyer</button>
          </form>
        </div>
        <div class="col-12 col-sm-2 text-center mt-5" >
          OU
        </div>
        <div class="col">
          <h2 class="mt-5 ">Improtation des apprenants </h2>
          <form class=" col-xs-5" action="../back/app/controllers/learnerControllers.php" method="post" enctype="multipart/form-data">
            <label for="import" class="mt-3">Le fichier importé doit obiligatoirement être au format JSON.</label>
            <div class="mb-3 mt-3">
              <input class="form-control" type="file" name="jsonFile" id="import" accept=".json">
            </div>
              <button type="submit" class="btn btn-primary">Envoyer</button>
          </form>
        </div>
      </div>

    </div>
  </main>
<!--Footer-->
  <footer class="footer mt-auto py-3 bg-body-tertiary">
    <div class="container text-center">
      <span class="text-body-secondary">@BewVed</span>
    </div>
  </footer>
  <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>
