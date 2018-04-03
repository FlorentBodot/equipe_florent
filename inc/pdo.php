<?php

try {
    $pdo = new PDO ('mysql:host=localhost;dbname=exercice',
    "root","", array(
        PDO::MYSQL_ATTR_INIT_COMMAND =>"SET NAMES utf8",
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
    ));
}
catch(PDOException $e) {
    echo 'Ereur de connexion : '. $e->getMessage();
}