<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
    header('location: login.php');
}

include('utils.php');

try{
    $user = $db->query("SELECT username FROM account WHERE username=".'"'.$_GET['username'].'"')->fetch();
    if(!empty($user['username'])){
        $db->query("DELETE FROM account WHERE username=".'"'.$_GET['username'].'"');
        $_SESSION['userDeleted'] = true;
    } else {
        $_SESSION['userDeleted'] = false;
    }
} catch(PDOException $e){
    echo $e->getMessage();
}

header("location: manageUser.php");