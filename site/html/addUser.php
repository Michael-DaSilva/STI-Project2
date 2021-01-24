<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
    header('location: login.php');
}

include('utils.php');

try{
	$stmt = $db->prepare('INSERT INTO account (username, password, validity, role_id) VALUES (?,?,?,?)');
	$stmt->bindParam(1, $_SESSION['newUsername']);
	$stmt->bindParam(2, $_SESSION['newUserpass']);
	$stmt->bindParam(3, $_SESSION['newUservalidity']);
	$stmt->bindParam(4, $_SESSION['newUserrole']);
	$stmt->execute();
    
	$_SESSION['userAdded'] = true;
    unset($_SESSION['newUsername']);
    unset($_SESSION['newUserpass']);
    unset($_SESSION['newUservalidity']);
    unset($_SESSION['newUserrole']);
    header('location: manageUser.php');
} catch(PDOException $e){
    echo $e->getMessage();
}