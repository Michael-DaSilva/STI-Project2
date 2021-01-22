<?php
// utils.php
// Date de création : 27/09/2020
// Date de modification : 11/10/20
// Auteur : Michaël da Silva & Nenad Rajic
// Fonction : fonctions pour la base de données
// _______________________________
	try {
	  $db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
	  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
	  echo "Connection failed : ". $e->getMessage();
	}
?>