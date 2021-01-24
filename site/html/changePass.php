<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
    header('location: login.php');
}

include('utils.php');

try{
    if(isset($_POST['passChanged']) && !empty($_POST['password'])){

        if(!check_mdp_format($_POST['password'])) {
            echo ("Erreur mot de passe trop faible<br/>");
            echo ("<a href='profil.php'>retour</a>");
            die();
        }

		$stmt = $db->prepare('UPDATE account SET password=? WHERE username=?');
		$stmt->bindParam(1, $_POST['password']);
		$stmt->bindParam(2, $_SESSION['username']);
		$stmt->execute();
        $_SESSION['passEdited'] = true;
    }
} catch(PDOException $e){
    echo $e->getMessage();
}

header('location: profil.php');

function check_mdp_format($mdp)
{
	$majuscule = preg_match('@[A-Z]@', $mdp);
	$minuscule = preg_match('@[a-z]@', $mdp);
	$chiffre = preg_match('@[0-9]@', $mdp);
	
	if(!$majuscule || !$minuscule || !$chiffre || strlen($mdp) < 8)
		return false;
	else 
		return true;
}

?>