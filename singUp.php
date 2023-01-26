<?php 
include 'header.php';

if (isset($_POST['email'])) {
  var_dump('Hello');
  if (empty($_POST['email']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['password'])) {
    var_dump('Hello 2');
    $msgError = 'Merci de renseigner tout les champs obligatoire';
    
  } else {
    
    try {
      $request = $bd->prepare('INSERT INTO user 
      (user_firstname,user_lastname,user_email,user_password,user_gender)
      VALUES (?,?,?,?,?)');

// ? est une valeur nul qui sera attribué dans le execute 

      $passwordHash = password_hash($_POST['password'],PASSWORD_DEFAULT);

      $request->execute([
        $_POST['firstname'],       
        $_POST['lastname'],        
        $_POST['email'],        
        $passwordHash,  
        $_POST['civility'],       
      ]);

      //  request execute donne la valeur aux ?

    header('Location: index.php');

      $_SESSION['user'] = [
        'firstname' =>  $_POST['firstname'],
        'email' => $_POST['email'],
        'isAdmin' => false
      ];
      
    } catch (Exception $e) {
      
      var_dump($e->getMessage());
      
    }
    
  }
}
  var_dump($msgError);
  include 'popup.php';
  ?> 
  
  <div class="content">
  <form method="post" action="">
  <div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">Prénom</label>
  <input name="firstname" type="text" class="form-control" id="name">
  </div>
  <div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">Nom</label>
  <input name="lastname" type="text" class="form-control" id="lastname">
  </div>
  <div class="mb-3">
  <label for="exampleInputEmail1" class="form-label">Email </label>
  <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
  <input name="password" type="password" class="form-control" id="password">
  </div>
  <div class="mb-3">
  <label for="civility" class="form-label">Civilité</label>
  <select name="civility" class="form-select" aria-label="Default select example">
  <option selected>Choisissez votre civilité</option>
  <option value="1">Homme</option>
  <option value="2">Femme</option>
  <option value="3">Autre</option>
  </select>
  </div>
  <button type="submit" class="btn btn-primary">Valider</button>
  </form>
  </div>
  
  <?php
  include 'footer.php';
  ?>