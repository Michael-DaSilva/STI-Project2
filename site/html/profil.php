<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
        header('location: login.php');
    }
    include("utils.php");
?>
<h3>Username :</h3>
<?php echo htmlentities($_SESSION['username']);?>
<h3>Role :</h3>
<?php echo htmlentities($_SESSION['role']);?>
<br/><br/>
<form method="post" action="changePass.php">
    Changer le mot de passe: <input type="password" name="password">
    <input type="submit" name="passChanged" value="Envoyer">
</form>
<?php if(isset($_SESSION['passEdited']) && $_SESSION['passEdited'] === true){
    echo "Nouveau mot de passe appliqué!";
    unset($_SESSION['passEdited']);
} ?>
<a href="index.php">Retour aux messages</a>


