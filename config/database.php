<?php

	try {
		$DB_DSN = 'mysql:host=localhost;dbname=matcha;charset=utf8';
		$DB_USER = 'root';
		$DB_PASSWORD = 'root';
		$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	catch(Exception $e) {
	    die('Erreur : '.$e->getMessage());
	}

	$link = mysqli_init();
	mysqli_real_connect($link, 'localhost', 'root', 'root', 'matcha');

?>