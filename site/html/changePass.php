<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
    header('location: login.php');
}

include('utils.php');

try{
    if(isset($_POST['passChanged']) && !empty($_POST['password'])){
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
