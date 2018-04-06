<?php session_start();
include('inc/pdo.php'); ?>
<?php include('inc/functions.php'); ?>

<?php
$error = array();
if(!empty($_POST['submitlogin'])) {
    // protection XSS
    $name     = failleXss($_POST['name']);
    $password  = failleXss($_POST['password']);
debug($error);
    ///////////////////////////////////////
    // Validation
    /////////////////////////////////////////
    if(empty($name) OR empty($password)) {
      $error['name'] = ' Veuillez renseigner les deux champs';
    } else {
        $sql = "SELECT * FROM users WHERE name = :name";
        $query = $pdo->prepare($sql);
        $query->bindValue(':name',$name,PDO::PARAM_STR);
        $query->execute();
        $users = $query->fetch();
        if(!empty($users)) {
            	if(password_verify($password,$users['password'])) {

                    // connexion, password ok , user ok
                        $_SESSION['users'] = array(
                            'id'       => $users['id'],
                            'name'     => $users['name'],
                            'grade'    => $users['grade'],
                            'ip'       => $_SERVER['REMOTE_ADDR']
                        );

                        header('Location: index.php');

              } else {
                    $error['password'] = 'Mauvais mot de passe';
              }
        } else {
          $error['name'] = 'Identifiant inconnu';
        }
    }
  }


?>
<?php include('inc/header.php'); ?>

<style>
    label {display:block}
</style>
<div class="register">

    <form action="connection.php" method="post">
        <span class="error"><?php if(!empty($error['login'])){echo $error['login'];} ?></span>
        <h1 style=" margin-top:5%; margin-bottom:2%; margin-left:5%;">Connectez-vous</h1>

        <label for="login"></label>
        <input class="bouton" type="text" name="name" id="name" value="<?php if(!empty($_POST['email'])){echo $_POST['email'];} ?>" placeholder="Pseudo">

        <label for="password"></label>
        <input class="bouton" type="password" name="password" id="password" value="" placeholder="Password">
        <span class="error"><?php if(!empty($error['password'])){echo $error['password'];} ?></span>
        <br>
        <br>
        <input class="boutonsubmit" type="submit" name="submitregister" value="envoyer">
    </form>
</div>

<?php include('inc/footersimple.php');
