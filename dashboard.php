<?php

include('inc/headerback.php');
include('inc/pdo.php');
include('inc/functions.php');

$sql = "SELECT * FROM movies_full LIMIT 100";
$query = $pdo->prepare($sql);
$query->execute();
$movies = $query->fetchAll();

$sql = "SELECT * FROM users LIMIT 100";
$query = $pdo->prepare($sql);
$query->execute();
$users = $query->fetchAll();
?>


<body>
    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">

          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2" id=stats>Statistiques d'affluence</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
            </div>
          </div>

          <canvas class="my-4 chartjs-render-monitor" id="myChart" width="819" height="345" style="display: block; width: 819px; height: 345px;"></canvas>

          <h2 id=gestionf>Gestions des films</h2>
          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Titre</th>
                  <th>Année</th>
                  <th>Note</th>
                  <th>Action(s)</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($movies as $movie) { ?>
                <tr>
                  <td><?php echo $movie['id']; ?> </td>
                  <td><?php echo $movie['title']; ?> </td>
                  <td><?php echo $movie['year']; ?></td>
                  <td><?php echo $movie['rating']; ?></td>
                  <td><button class="btn btn-info my-2 my-sm-0 btn-sm" href="index.php?id=<?php echo $movie['id']; ?>">Voir sur le site</button>
                    <button class="btn btn-secondary my-2 my-sm-0 btn-sm" href="edit.php?id=<?php echo $movie['id']; ?>">Editer</button>
                    <button class="btn btn-sm btn-danger my-2 my-sm-0" href="delete.php?id=<?php echo $movie['id']; ?>">Supprimer</button></td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
          <h2 id="gestionu">Gestions des utilisateurs</h2>
          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Email</th>
                  <th>Mot de passe</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($users as $user) { ?>
                  <tr>
                  <td><?php echo $user['id'] ?></td>
                  <td><?php echo $user['name'] ?></td>
                  <td><?php echo $user['password'] ?></td>
                  <td><?php echo $user['grade'] ?></td>
                  <td><button class="btn btn-secondary my-2 my-sm-0 btn-sm" href="edit.php?id=<?php echo $movie['id']; ?>">Editer</button>
                    <button class="btn btn-sm btn-danger my-2 my-sm-0" href="delete.php?id=<?php echo $movie['id']; ?>">Supprimer</button></td>
                  </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../../../assets/js/vendor/popper.min.js"></script>
    <script src="../../../../dist/js/bootstrap.min.js"></script>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>

    <!-- Graphs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script>
      var ctx = document.getElementById("myChart");
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
          datasets: [{
            data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            borderWidth: 4,
            pointBackgroundColor: '#007bff'
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: false
              }
            }]
          },
          legend: {
            display: false,
          }
        }
      });
    </script>


</body>


<?php
include('inc/footerback.php');
