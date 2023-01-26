<?php 
include 'header.php';
var_dump($_SESSION['user']);


if (!isset($_SESSION['user']) || !$_SESSION['user']['isAdmin']) {
    header('Location: index.php');
}

if (isset($_POST['category'])) {
  var_dump('hhh');
  if (empty($_POST['category'])) {
    var_dump('jjj');
    $msgError = 'Merci de renseigner tout les champs obligatoire';
    
  } else {
    
    try {
      $request = $bd->prepare('INSERT INTO category
      (category_name)
      VALUES (?)');

// ? est une valeur nul qui sera attribué dans le execute 

      $request->execute([
        $_POST['category'],          
      ]);

      //  request execute donne la valeur aux ?
      
    } catch (Exception $e) {
      
      var_dump($e->getMessage());
      
    }
    
  }
}

if (isset($_GET['action']) AND isset($_GET['id'])) {
    try {

        $request = $bd->prepare('UPDATE category SET category_is_activated = ? WHERE category_id = ?');
        $request->execute([
            $_GET['action'],
            $_GET['id']
        ]);

        $msgSuccess = 'Catégorie modifiée';


    }catch (Exception $e){
        var_dump($e->getMessage());
    }
}

try {
    $request = $bd->prepare('SELECT * FROM category ORDER BY category_is_activated DESC');
    $request->execute([]);
    $categories = $request->fetchall ();
    
   
} catch (Exception $e) {
      
    var_dump($e->getMessage());
}

  var_dump($msgError);
  include 'popup.php';
  ?> 
  
  <div class="content">
  <form method="post" action="">
  <div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">Ajouter une catégorie</label>
  <input name="category" type="text" class="form-control" id="category">
  </div>
  <button type="submit" class="btn btn-primary">Ajouter</button>
  </form>
  </div>

  <div class="content">
    <ul class="list-group">
        <?php for ($i=0; $i < count($categories); $i++) { ?>
            <li class="list-group-item <?php if ($categories[$i]['category_is_activated'] == 0) { echo 'op';} ?>">
                    <a href="category.php?action=<?= $categories[$i]['category_is_activated'] == 0 ? 1 : 0 ?>&id=<?= $categories[$i]['category_id']?>">
                        <img src="public/Picture/<?= $categories[$i]['category_is_activated'] == 1 ? 'switch-on' : 'switch-off' ?>.png">
                    </a>  
                <?= $categories[$i]['category_name'] ?></li>
            <?php } ?>
             
    </ul>
  </div>

<?php
include 'footer.php';
?>