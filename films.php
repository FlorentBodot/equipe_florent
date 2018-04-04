<?php 
include('inc/headerback.php');
include('inc/pdo.php');
include('inc/functions.php');


$sql = "SELECT * FROM movies_full LIMIT 100";
$query = $pdo->prepare($sql);
$query->execute();
$movies = $query->fetchAll();
?>


<?php foreach ($movies as $movie) { ?>
<table class="table table-dark">
    <tbody>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Titre</th>
            <th scope="col">Année</th>
            <th scope="col">Note</th>
        </tr>
   
        <th><?php echo $movie['id']; ?> </td>
        <td><?php echo $movie['title']; ?> </td>
        <td><?php echo $movie['year']; ?></td>
        <td><?php echo $movie['rating']; ?></td>
        <br>
    </tbody>
</table>


<?php } ?>




