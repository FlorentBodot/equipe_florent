<?php 
session_start();
include('inc/pdo.php'); ?>
<?php include('inc/functions.php'); ?>


<?php
$error = array();
$success = false;

// formulaire soumis
if(!empty($_POST['submitregister'])) {
  // faille xss
    $name      = failleXss($_POST['name']);
    $email     = failleXss($_POST['email']);
    $password1 = failleXss($_POST['password1']);
    $password2 = failleXss($_POST['password2']);

    /////////////////////////////
    // Validation
    ///////////////////////////////////
    // name
    if(!empty($name)) {
          if(strlen($name) < 3) {
                $error['name'] = 'min 3';
          } elseif(strlen($name) > 100) {
                $error['name'] = 'max 100';
          } else {
                $sql = "SELECT id FROM users WHERE name = :name";
                $query = $pdo->prepare($sql);
                $query->bindValue(':name',$name,PDO::PARAM_STR);
                $query->execute();
                $nameExist = $query->fetch();
                if(!empty($nameExist)) {
                  $error['name'] = 'name existe deja';
                }
          }
    } else {
      $error['name'] = 'Veuillez renseigner un name';
    }

    // mail
    if(!empty($email)) {
          if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $error['email'] = 'email invalide';
          } else {
                $sql = "SELECT id FROM users WHERE email = :email";
                $query = $pdo->prepare($sql);
                $query->bindValue(':email',$email,PDO::PARAM_STR);
                $query->execute();
                $emailExist = $query->fetch();
                if(!empty($emailExist)) {
                  $error['email'] = 'email existe deja';
                }
          }
    } else {
      $error['email'] = 'Veuillez renseigner un email';
    }
    // password
    if(!empty($password1) && !empty($password2)) {
          if($password1 != $password2) {
              $error['password'] = 'les mots de passe doivent etre identiques';
          } elseif(strlen($password1) < 6) {
            $error['password'] = 'mot de passe trop court';
          }
    } else {
      $error['password'] = 'Veuillez renseigner un password';
    }/////////////////////////////////
    // insert into nouvelle inscription
    ///////////////////////////////////
    if(count($error) == 0) {
      $success = true;

        $hassPassword = password_hash($password1, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users ( name, email ,  password, grade)
                           VALUES (:name, :email , :password,   :grade)";
        $query = $pdo->prepare($sql);
        $query->bindValue(':name',$name,PDO::PARAM_STR);
        $query->bindValue(':email',$email,PDO::PARAM_STR);
        $query->bindValue(':password',password_hash($password, PASSWORD_DEFAULT),PDO::PARAM_STR);
        $query->bindValue(':grade','Membre',PDO::PARAM_STR);
        $query->execute();
        // redirection vers connexion
        header('Location: register.php');
  }
}

?>
<?php include('inc/header.php'); ?>

<style>
    label {display:block}
</style>
<div class="register">
  <h1 style="margin-left:7%; margin-top:5%; margin-bottom:2%;">Inscription</h1>

  <form action="" method="post" >
    <label for="name"></label>
    <input class="bouton" type="text" name="name" value="<?php if(!empty($_POST['name'])) { echo $_POST['name']; } ?>" placeholder="Votre Nom">
    <span class="error"><?php if(!empty($error['name'])) { echo $error['name']; } ?></span>

    <label for="email"></label>
    <input class="bouton" type="text" name="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>" placeholder="Votre Email">
    <span class="error"><?php if(!empty($error['email'])) { echo $error['email']; } ?></span>

    <label for="password1"></label>
    <input class="bouton" type="password" name="password1" value="<?php if(!empty($_POST['password'])) { echo $_POST['password']; } ?>" placeholder="Saisissez votre mot de pass">
    <span class="error"><?php if(!empty($error['password'])) { echo $error['password']; } ?></span>

    <label for="password2"></label>
    <input class="bouton" type="password" name="password2" value="<?php if(!empty($_POST['password2'])) { echo $_POST['password2']; } ?>" placeholder="Saisissez votre mot de pass de nouveau">
    <span class="error"><?php if(!empty($error['password2'])) { echo $error['password2']; } ?></span>
    <br>
    <input class="boutonsubmit" type="submit" name="submitregister" value="envoyer">
  </form>
</div>







<?php include('inc/footersimple.php'); ?>
