<?php
session_start();
include('inc/pdo.php');
include('inc/functions.php');

$sql = "SELECT * FROM movies_full ORDER BY RAND() LIMIT 100";
$query = $pdo->prepare($sql);
$query->execute();
$movies = $query->fetchAll();




// print_r($movies);
include('inc/header.php');
debug($_SESSION);

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
              <?php uploadDataPictures($movie['id']); ?>
              <div class="card-body">
                <p class="h5"><?php echo $movie['title']; ?></p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <a href="detail.php?id=<?php echo $movie['id']; ?>">+ de détails</a>
                  </div>
                  <small class="text-muted">Crée le <?php echo date('d/m/Y' . ' à ' . 'H:i', strtotime($movie['created'])); ?></small>
                </div>
              </div>
            </div>
          </div>
        <?php
        } ?>
      </div>
    </div>
  </div>
</main>


<?php include('inc/footer.php');
