<?php session_start();
include('inc/pdo.php'); ?>
<?php include('inc/functions.php'); ?>

<?php
$error = [];
if(!empty($_POST['submitlogin'])) {
    // protection XSS
    $name     = trim(strip_tags($_POST['name']));
    $password  = trim(strip_tags($_POST['password']));

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
        $user = $query->fetch();
        if(!empty($user)) {
            	if(password_verify($password,$user['password'])) {

                    // connexion, password ok , user ok
                        $_SESSION['user'] = array(
                            'id'     => $user['id'],
                            'name' => $user['name'],
                            'grade'   => $user['grade'],
                            'ip'     => $_SERVER['REMOTE_ADDR']
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

<form action="connection.php" method="post">
<span class="error"><?php if(!empty($error['login'])){echo $error['login'];} ?></span>

    <label for="login"> Pseudo </label>
        <input type="text" name="name" value="<?php if(!empty($_POST['email'])){echo $_POST['email'];} ?>">

    <label for="password">Password</label>
        <input type="password" name="password" id="password" value="">
        <span class="error"><?php if(!empty($error['password'])){echo $error['password'];} ?></span>

    <input type="submit" name="submitlogin" value="Envoyer">
</form>

<?php include('inc/footer.php');
