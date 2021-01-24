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

try{
	$stmt = $db->prepare("INSERT INTO messages (sender, receiver, subject, messageContent) VALUES (?,?,?,?)");
	
	$stmt->bindParam(1,$_SESSION['username']);
	$stmt->bindParam(2,$_SESSION['newEmailreceiver']);
	$stmt->bindParam(3,$_SESSION['newEmailsubject']);
	$stmt->bindParam(4,$_SESSION['newEmailcontent']);
	$stmt->execute();
	
    $_SESSION['emailSent'] = true;
    unset($_SESSION['newEmailreceiver']);
    unset($_SESSION['newEmailsubject']);
    unset($_SESSION['newEmailcontent']);
    header('location: newEmail.php');
} catch(PDOException $e){
    echo $e->getMessage();
}