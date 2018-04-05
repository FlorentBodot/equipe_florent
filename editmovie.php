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
                $sql = "SELECT * FROM movies_full WHERE name = :name";
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
<?php include('inc/headerback.php'); ?>

<div class="col-md-8 order-md-1">
          <h4 class="display-4">Editer</h4>
          <form class="needs-validation" required>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">Editer le titre du film</label>
                <input type="text" class="form-control" id="firstName" placeholder="" value="" required="">

              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Modifier la date de sortie</label>
                <input type="text" class="form-control" id="lastName" placeholder="" value="" required="">
              </div>
            </div>

            <div class="form-group">
              <label for="exampleFormControlSelect1">Modifier le genre</label>
                <select class="form-control" id="exampleFormControlSelect1">
                  <option selected disabled>Choisir ...</option>
                  <option>Drame</option>
                  <option>Fantastique</option>
                  <option>Romance</option>
                  <option>Action</option>
                  <option>Comédie</option>
                  <option>Thriller</option>
                  <option>Aventure</option>
                  <option>Science-fiction</option>
                  <option>Mystère</option>
                  <option>Biographie</option>
                  <option>Horreur</option>
                </select>
              </div>

            <div class="mb-3">
              <label for="email">Email <span class="text-muted">(Optional)</span></label>
              <input type="email" class="form-control" id="email" placeholder="you@example.com">
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="mb-3">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="address" placeholder="1234 Main St" required="">
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="mb-3">
              <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
              <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
            </div>




            <button class="btn btn-primary btn-sm" type="submit">Editer le film</button>
          </form>
        </div>







<?php include('inc/footer.php'); ?>
