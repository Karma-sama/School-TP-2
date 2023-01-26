<?php
session_start();
var_dump($_SESSION);

if  (isset($_GET['out'])) {
  $_SESSION = [];
  session_destroy();
}
var_dump($_SESSION);

$msgError = NULL;
$msgSuccess = NULL ;

try {
    
    $bd = new PDO ('mysql:dbname=moview;host=localhost;charset=utf8',
    'root', '',
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
} catch (Exception $e) {
    
    var_dump($e->getMessage());
    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Accueil</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="addMovie.php">Ajouter un film</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="listMovies.php">Ma collection</a>
        </li>
        <?php if (isset($_SESSION['user']['isAdmin']) && $_SESSION['user']['isAdmin'] === true) { ?>
              <li class="nav-item">
                <a class="nav-link" href="category.php">Catégorie</a>
              </li>
        <?php } ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Mon Profil
          </a>
          <ul class="dropdown-menu">
            <?php if (!isset($_SESSION['user'])) { ?>
            <li><a class="dropdown-item" href="singIn.php">Se connecter</a></li>
            <li><a class="dropdown-item" href="singUp.php">Créer un compte</a></li>
            <?php } else { ?>
              <?php if (isset($_SESSION['user'])) { ?> 
              <a class="nav-link disabled" href="#">Bonjour <?= $_SESSION['user']['firstname'] ?></a>
              <?php } ?>
            <li><a class="dropdown-item" href="index.php?out=true">Se déconnecter</a></li>
            <?php } ?>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<link rel="stylesheet" href="public\style\style.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>