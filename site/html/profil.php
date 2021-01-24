<!--
STI-Project2 2021
Groupe: Michaël da Silva & Guillaume Schranz

Changement apporté:
- htmlentities contre les attaques XSS
-->
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
    echo "Nouveau mot de passe appliqué! <br/>";
    unset($_SESSION['passEdited']);
} 
if(isset($_SESSION['badPass']) && $_SESSION['badPass'] === true){
    echo "Erreur: mot de passe faible (8 caracters minimum, majuscules, minuscules et chiffres)! <br/>";
    unset($_SESSION['badPass']);
}?>
<a href="index.php">Retour aux messages</a>


