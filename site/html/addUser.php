<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
    header('location: login.php');
}

include('utils.php');

try{
    $db->query("INSERT INTO account (username, password, validity, role_id) VALUES ('".$_SESSION['newUsername']."','".$_SESSION['newUserpass']."',".$_SESSION['newUservalidity'].",".$_SESSION['newUserrole'].")");
    $_SESSION['userAdded'] = true;
    unset($_SESSION['newUsername']);
    unset($_SESSION['newUserpass']);
    unset($_SESSION['newUservalidity']);
    unset($_SESSION['newUserrole']);
    header('location: manageUser.php');
} catch(PDOException $e){
    echo $e->getMessage();
}