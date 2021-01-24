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
	$stmt = $db->prepare('SELECT receiver FROM messages WHERE id=?');
	$stmt->bindParam(1, $_GET['id']);
	$stmt->execute();
	$receiver = $stmt->fetch();
    if($receiver['receiver'] === $_SESSION['username']){
		$stmt = $db->prepare('DELETE FROM messages WHERE id=?');
		$stmt->bindParam(1, $_GET['id']);
		$stmt->execute();
        $_SESSION['messageDeleted'] = true;
    } else {
        $_SESSION['messageDeleted'] = false;
    }
} catch(PDOException $e){
    echo $e->getMessage();
}

header("location: index.php");