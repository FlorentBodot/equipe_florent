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









<?php
include('inc/footer.php');
