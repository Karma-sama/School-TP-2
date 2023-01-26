<?php 
include 'header.php';

if (!isset($_SESSION['user']) || !$_SESSION['user']) {
  header('Location: index.php');
}

try {
    $request = $bd->prepare('SELECT * FROM category WHERE category_is_activated = ?');
    $request->execute([1]);
    $categories = $request->fetchall();
} catch (Exception $e) {
        
    var_dump($e->getMessage());
    
}

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}


if (isset($_POST['movieName'])) {

    if (empty($_POST['movieName']) || empty($_POST['dateCreate']) || empty($_POST['movieDuration']) 
        || empty($_POST['movieActor'])|| empty($_POST['category'])) {
      $msgError = 'Merci de renseigner tout les champs obligatoire';
      
    } else {

      try {


        $file = null;
        $uploadOk = false;

        if (!empty($_FILES['moviePicture']['name'])) {

            $uploadOk = true;
            $now = date('d-m-Y H-i-s');
            $imageFileType = strtolower(pathinfo($_FILES['moviePicture']['name'],PATHINFO_EXTENSION));
            $targetDir = 'public/picture/';
            $targetFile =$targetDir . $_POST['movieName'] . '-' . '.' . $imageFileType;
            $check = getimagesize($_FILES['moviePicture']['tmp_name']);
            var_dump(77777);
            var_dump($uploadOk);
            if ($check === false || empty($imageFileType)) {

                $uploadOk = false;
                $msgError = "Votre fichier n'est pas valide";
            }

            if (file_exists($targetFile)) {
              $uploadOk = false;
              $msgError = "Un fichier du même nom existe déjà";
            }

            if ($_FILES['moviePicture']['size'] > 500000) {
              $uploadOk = false;
              $msgError = "Votre image dépasse la taille limite de 500 Ko";
            }

            if ($imageFileType != 'jpg' && $imageFileType != 'png') {
              $uploadOk = false;
              $msgError = "Votre fichier n'est pas de type image";
            }

            if ($uploadOk === true) {
              if (move_uploaded_file($_FILES['moviePicture']['tmp_name'],$targetFile)) {
                $file = $_POST['movieName'] . '-' . $now . '.' . $imageFileType;
              }else{
                $uploadOk = false;
                $msgError = "Echec de l'upload";
              }
            }
        }
        

        $_POST['resum'] = empty($_POST['resum']) ? null : $_POST['resum'];
        $_POST['movieTrailer'] = empty($_POST['movieTrailer']) ? null : $_POST['movieTrailer'];
      

        $request = $bd->prepare('INSERT INTO movie
        (movie_name,movie_date,movie_duration,movie_resum,movie_actor,movie_trailer,id_category,movie_picture)
        VALUES (?,?,?,?,?,?,?,?)');
  
  // ? est une valeur nul qui sera attribué dans le execute 
  
        $request->execute([
          $_POST['movieName'],       
          $_POST['dateCreate'],        
          $_POST['movieDuration'],        
          $_POST['movieResum'],
          $_POST['movieActor'],       
          $_POST['movieTrailer'],           
          $_POST['category'],
          $file,        
        ]);

        $id = $bd->lastInsertId();

        $msgSuccess = "Le film {$_POST['movieName']} a bien été ajouté";
  
        //  request execute donne la valeur aux ?

        
        
      } catch (Exception $e) {
        
        var_dump($e->getMessage());
        
      }


      
    }
}

var_dump($categories);
include 'popup.php';
?> 

<div class="content">
  <form method="post" action="" enctype="multipart/form-data">
    <div class="mb-3">
    <label for="movieName" class="form-label">Nom du film</label>
    <input name="movieName" type="text" class="form-control" id="movieName">
    </div>
    <div class="mb-3">
    <label for="dateCreate" class="form-label">Date de Sortie</label>
    <input name="dateCreate" type="year" class="form-control" id="dateCreate">
    </div>
    <div class="mb-3">
    <label for="movieDuration" class="form-label">Durée du film</label>
    <input name="movieDuration" type="time" class="form-control" id="movieDuration">
    </div>
    <div class="mb-3">
    <label for="" class="form-label">Résumé du film</label>
    <input name="movieResum" type="Text" class="form-control" id="movieResum">
    </div>
    <div class="mb-3">
    <label for="movieActor" class="form-label">Nom des acteurs</label>
    <input name="movieActor" type="text" class="form-control" id="movieActor">
    </div>
    <div class="mb-3">
    <label for="movieTrailer" class="form-label">Bande annonce du film</label>
    <input name="movieTrailer" type="text" class="form-control" id="movieTrailer">
    </div>
    <div class="mb-3">
        <label for="moviePicture" class="form-label">Miniature du film</label>
        <input name="moviePicture" class="form-control" type="file" id="moviePicture">
    </div>
    <div class="mb-3">
    <label for="category" class="form-label">Catégorie du film</label>
        <select name="category" class="form-select" aria-label="Default select example" id="category">
            <option selected>Choisir une catégorie</option>
                <?php for ($i=0; $i < count($categories); $i++) { 
                  echo  "<option value='{$categories[$i]['category_id']}'>
                        {$categories[$i]['category_name']}
                   </option>";
                  } ?>
            </select>      
    </div>
        <button type="submit" class="btn btn-primary">Valider</button>
  </form>
  </div>


<?php
include 'footer.php';
?>