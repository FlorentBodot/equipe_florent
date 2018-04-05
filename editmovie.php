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
<?php include('inc/headerback.php'); ?>

<div class="col-md-8 order-md-1">
          <h4 class="mb-3">Billing address</h4>
          <form class="needs-validation" novalidate="">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">First name</label>
                <input type="text" class="form-control" id="firstName" placeholder="" value="" required="">
                <div class="invalid-feedback">
                  Valid first name is required.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Last name</label>
                <input type="text" class="form-control" id="lastName" placeholder="" value="" required="">
                <div class="invalid-feedback">
                  Valid last name is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="username">Username</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">@</span>
                </div>
                <input type="text" class="form-control" id="username" placeholder="Username" required="">
                <div class="invalid-feedback" style="width: 100%;">
                  Your username is required.
                </div>
              </div>
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

            <div class="row">
              <div class="col-md-5 mb-3">
                <label for="country">Country</label>
                <select class="custom-select d-block w-100" id="country" required="">
                  <option value="">Choose...</option>
                  <option>United States</option>
                </select>
                <div class="invalid-feedback">
                  Please select a valid country.
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="state">State</label>
                <select class="custom-select d-block w-100" id="state" required="">
                  <option value="">Choose...</option>
                  <option>California</option>
                </select>
                <div class="invalid-feedback">
                  Please provide a valid state.
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="zip">Zip</label>
                <input type="text" class="form-control" id="zip" placeholder="" required="">
                <div class="invalid-feedback">
                  Zip code required.
                </div>
              </div>
            </div>
            <hr class="mb-4">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="same-address">
              <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="save-info">
              <label class="custom-control-label" for="save-info">Save this information for next time</label>
            </div>
            <hr class="mb-4">

            <h4 class="mb-3">Payment</h4>

            <div class="d-block my-3">
              <div class="custom-control custom-radio">
                <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked="" required="">
                <label class="custom-control-label" for="credit">Credit card</label>
              </div>
              <div class="custom-control custom-radio">
                <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required="">
                <label class="custom-control-label" for="debit">Debit card</label>
              </div>
              <div class="custom-control custom-radio">
                <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required="">
                <label class="custom-control-label" for="paypal">Paypal</label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="cc-name">Name on card</label>
                <input type="text" class="form-control" id="cc-name" placeholder="" required="">
                <small class="text-muted">Full name as displayed on card</small>
                <div class="invalid-feedback">
                  Name on card is required
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="cc-number">Credit card number</label>
                <input type="text" class="form-control" id="cc-number" placeholder="" required="">
                <div class="invalid-feedback">
                  Credit card number is required
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 mb-3">
                <label for="cc-expiration">Expiration</label>
                <input type="text" class="form-control" id="cc-expiration" placeholder="" required="">
                <div class="invalid-feedback">
                  Expiration date required
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="cc-expiration">CVV</label>
                <input type="text" class="form-control" id="cc-cvv" placeholder="" required="">
                <div class="invalid-feedback">
                  Security code required
                </div>
              </div>
            </div>
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
          </form>
        </div>







<?php include('inc/footer.php'); ?>
