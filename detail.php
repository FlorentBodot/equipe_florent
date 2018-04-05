<?php
include('inc/function.php');
include('inc/pdo.php');

$error = array();
$success = false;

if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

//Requête de sélection de l'article à afficher dépendant de l'identifiant passé en paramètre URL
    $sql = "SELECT * FROM movies_full WHERE id = :id ";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $movie = $query->fetch();

    //Protection contre les requêtes malveillantes visant à afficher un article inexistant
    if (empty($movie)) {

    //Redirection vers la page erreur.php contenant simplement un message d'erreur
        header('Location: erreur.php');
    }

} else {
    header('Location: erreur.php');
}



include('inc/header.php');

















include('inc/footer.php');
