<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
    header('location: login.php');
}
if(!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] === false){
    header('location: index.php');
}


include('utils.php');

try{
	$stmt = $db->prepare('SELECT username FROM account WHERE username=?');
	$stmt->bindParam(1, $_GET['username']);
	$stmt->execute();
	$user = $stmt->fetch();
    if(!empty($user['username'])){
		$stmt = $db->prepare('DELETE FROM account WHERE username=?');
		$stmt->bindParam(1, $_GET['username']);
		$stmt->execute();
        $_SESSION['userDeleted'] = true;
    } else {
        $_SESSION['userDeleted'] = false;
    }
} catch(PDOException $e){
    echo $e->getMessage();
}

header("location: manageUser.php");