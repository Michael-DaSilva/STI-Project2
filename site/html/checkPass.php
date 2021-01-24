<!--
STI-Project2 2021
Groupe: Michaël da Silva & Guillaume Schranz

Création de document: gestion de la création de mot de passe fort
-->
<?php
function check_mdp_format($mdp)
{
	$majuscule = preg_match('@[A-Z]@', $mdp);
	$minuscule = preg_match('@[a-z]@', $mdp);
	$chiffre = preg_match('@[0-9]@', $mdp);
	$specialChars = preg_match('@[^\w]@', $mdp);
	
	if(!$majuscule || !$minuscule || !$chiffre || !$specialChars || strlen($mdp) < 8)
		return false;
	else 
		return true;
}

?>