<?php include('inc/pdo.php'); ?>
<?php include('inc/functions.php'); ?>

<?php
$error = [];
// formulaire soumis
if(!empty($_POST['submitregister'])) {
  // faille xss
    $name    = trim(strip_tags($_POST['name']));
    $email     = trim(strip_tags($_POST['email']));
    $password1 = trim(strip_tags($_POST['password1']));
    $password2 = trim(strip_tags($_POST['password2']));
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

    // name
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
        $hassPassword = password_hash($password1, PASSWORD_DEFAULT);
        $token = generateRandomString(50);

        $sql = "INSERT INTO users (name,email,password,grade)
                VALUES (:name,:email,:pass,'Membre')";
        $query = $pdo->prepare($sql);
        $query->bindValue(':name',$name,PDO::PARAM_STR);
        $query->bindValue(':email',$email,PDO::PARAM_STR);
        $query->bindValue(':pass',$hassPassword,PDO::PARAM_STR);
        $query->bindValue(':grade',$grade,PDO::PARAM_STR);
        $query->execute();
        // redirection vers connexion
        header('Location: connexion.php');
  }
}

?>
<?php include('inc/header.php'); ?>

<style>
    label {display:block}
</style>
<div class="register">
  
  <form action="" method="post">
    <h1 style="margin-top:5%; margin-bottom:2%; margin-left:2%">Edition de l'utilisateur</h1>

    <label for="name"></label>
    <span class="error"><?php if(!empty($errors['name'])) { echo $errors['name']; } ?></span>
    <input class="bouton" type="text" name="name" value="<?php if(!empty($_POST['name'])) { echo $_POST['name']; } ?>" placeholder="Name">

    <label for="email"></label>
    <span class="error"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
    <input class="bouton" type="text" name="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>" placeholder="Email">

    <label for="password1"></label>
    <span class="error"><?php if(!empty($errors['password'])) { echo $errors['password']; } ?></span>
    <input class="bouton" type="text" name="password1" value="" placeholder="Password">

    <label for="password2"></label>
    <input class="bouton" type="text" name="password2" value="" placeholder="RePassword">
    <br>
    <br>
    <input class="boutonsubmit" type="submit" name="submitregister" value="envoyer">
  </form>
</div>







<?php include('inc/footersimple.php'); ?>
