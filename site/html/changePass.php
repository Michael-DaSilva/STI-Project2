<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
    header('location: login.php');
}

include('utils.php');

try{
    if(isset($_POST['passChanged']) && !empty($_POST['password'])){
        $db->query("UPDATE account SET password=".'"'.$_POST['password'].'"'." WHERE username=".'"'.$_SESSION['username'].'"');
        $_SESSION['passEdited'] = true;
    }
} catch(PDOException $e){
    echo $e->getMessage();
}

header('location: profil.php');
