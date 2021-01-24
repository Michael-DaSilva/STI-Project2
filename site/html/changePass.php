<!--
STI-Project2 2021
Groupe: Michaël da Silva & Guillaume Schranz

Changement apporté:
- Prepare statement contre les injections SQL
-->
<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
    header('location: login.php');
}

include('utils.php');
include('checkPass.php');

try{
    if(isset($_POST['passChanged']) && !empty($_POST['password'])){

        if(!check_mdp_format($_POST['password'])) {
            $_SESSION['badPass'] = true;
			header('location: profil.php');
			exit();
        }

		$stmt = $db->prepare('UPDATE account SET password=? WHERE username=?');
		$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$stmt->bindParam(1, $hash);
		$stmt->bindParam(2, $_SESSION['username']);
		$stmt->execute();
        $_SESSION['passEdited'] = true;
    }
} catch(PDOException $e){
    echo $e->getMessage();
}

header('location: profil.php');

?>