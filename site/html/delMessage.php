<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
    header('location: login.php');
}

include('utils.php');

try{
    $receiver = $db->query("SELECT receiver FROM messages WHERE id=".$_GET['id'])->fetch();
    if($receiver['receiver'] === $_SESSION['username']){
        $db->query("DELETE FROM messages WHERE id=".$_GET['id']);
        $_SESSION['messageDeleted'] = true;
    } else {
        $_SESSION['messageDeleted'] = false;
    }
} catch(PDOException $e){
    echo $e->getMessage();
}

header("location: index.php");