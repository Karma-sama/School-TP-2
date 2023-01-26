<?php 
include 'header.php';

try {
    if (isset($_POST['email'])) {

        if (empty($_POST['email']) || empty($_POST['password'])) {
        
            $msgError = 'Merci de renseigner tout les champs obligatoire';
        
        } else {
        
        
            $request = $bd->prepare('SELECT user_firstname,user_password,user_is_admin FROM user WHERE user_email = ?');

            $request->execute([$_POST['email']]);
            $user = $request->fetch();  
            
            if (!$user || !password_verify($_POST['password'], $user['user_password'])) {
                $msgError = 'Email ou mot de passe incorrect';

            } else {
                $isAdmin= $user['user_is_admin'] == '1' ? true : false; 
                $_SESSION['user'] = [
                    'firstname' => $user['user_firstname'],
                    'email' => $_POST['email'],
                    'isAdmin' => $isAdmin
                ];
                header('Location: index.php');
            }

    
        }    
    }
            
} catch (Exception $e) {
            
            var_dump($e->getMessage());
            
        }
        
        


    var_dump($msgError);
    include 'popup.php';
    ?> 

<div class="content">
  <form method="post" action="">
  <div class="mb-3">
  <label for="exampleInputEmail1" class="form-label">Email </label>
  <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
  <input name="password" type="password" class="form-control" id="password">
  </div>
  <button type="submit" class="btn btn-primary">Valider</button>
  </form>
  </div>

<?php
include 'footer.php';
?>