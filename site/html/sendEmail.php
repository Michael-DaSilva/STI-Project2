<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
    header('location: login.php');
}

include('utils.php');

try{
    $db->query("INSERT INTO messages (sender, receiver, subject, messageContent) VALUES ('".$_SESSION['username']."','".$_SESSION['newEmailreceiver']."',".'"'.$_SESSION['newEmailsubject'].'",'.'"'.$_SESSION['newEmailcontent'].'"'.")");
    $_SESSION['emailSent'] = true;
    unset($_SESSION['newEmailreceiver']);
    unset($_SESSION['newEmailsubject']);
    unset($_SESSION['newEmailcontent']);
    header('location: newEmail.php');
} catch(PDOException $e){
    echo $e->getMessage();
}