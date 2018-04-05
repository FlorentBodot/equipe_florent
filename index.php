<?php

include('inc/header.php');
include('inc/pdo.php');
include('inc/functions.php');

$sql = "SELECT * FROM movies_full LIMIT 9";
$query = $pdo->prepare($sql);
$query->execute();
$movies = $query->fetchAll();




// print_r($movies);

?>

<main role="main">

      <section class="jumbotron text-center">
        <div class="container">
          <h1 class="display-4">Bienvenue sur InTheMovie</h1>
          <p class="lead text-muted">Vous retrouverez tout vos films favoris.</p>
        </div>
      </section>

      <div class="album py-5">
        <div class="container">
          <div class="row">
          <?php foreach ($movies as $movie) { ?>
            <div class="col-md-4">
            <div class="card mb-4 box-shadow">
              <?php uploadDataPictures( $movie['id']); ?>
            <div class="card-body">
            <p class="h5"><?php echo $movie['title']; ?></p>
            <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
            <a href="detail.php?id=<?php echo $movie['id'];?>">+ de détails</a>
           
            </div>
            <small class="text-muted">Il y'a <?php echo $movie['created']; ?></small>
          </div>
        </div>

      </div>
    </div>
          <?php } ?>

          </div>
        </div>
      </div>
    </main>
