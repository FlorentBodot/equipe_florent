<?php
include('inc/functions.php');
include('inc/pdo.php');

$error = array();
$success = false;

if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

//Requête de sélection de l'movie à afficher dépendant de l'identifiant passé en paramètre URL
    $sql = "SELECT * FROM movies_full WHERE id = :id ";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $movie = $query->fetch();

    
    if (empty($movie)) {
        header('Location: erreur.php');
    }

} else {
    header('Location: erreur.php');
}



include('inc/header.php'); ?>


<div>
    <div class="content">
        <div class="picture"><?php uploadDataPictures($movie['id']); ?></div>
        <div class="details">
            <p class="titre">Titre : <?php echo $movie['title']; ?> </p>
            <p class="titre">Paru en : <?php echo $movie['year']; ?> </p>
            <p class="auteur">Genre : <?php echo $movie['genres']; ?> </p>
            <p class="auteur">Réalisateur : <?php echo $movie['directors']; ?> </p>
            <p class="auteur">Acteur(s) : <?php echo $movie['cast']; ?> </p>
            <p class="contenu">Scénariste(s) : <?php echo $movie['writers']; ?> </p>
            <p class="contenu">Durée: <?php echo $movie['runtime']; ?> min</p>
            <p class="status">Synopsis : <?php echo $movie['plot']; ?> </p> 
            <br>     
        </div>       
    </div>                 
</div>


<footer class="footdetails">
      <div class="container">
        <p class="float-right">
          <a href="#">Retour en haut</a>
        </p>
        <p>Album example is © Bootstrap, but please download and customize it for yourself!</p>
        <p>New to Bootstrap? <a href="../../">Visit the homepage</a> or read our <a href="../../getting-started/">getting started guide</a>.</p>
      </div>
    </footer>









