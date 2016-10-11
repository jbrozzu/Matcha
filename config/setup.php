<?php

require_once 'database.php';
$setup_database = $bdd->prepare(file_get_contents('matcha.sql'));
$setup_database->execute();

?>