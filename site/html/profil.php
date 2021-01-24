<!--
STI-Project2 2021
Groupe: Michaël da Silva & Guillaume Schranz

Changement apporté:
- htmlentities contre les attaques XSS
- Getion des mots de passe forts (checkPass.php)
-->
<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
        header('location: login.php');
    }
    include("utils.php");
	include("header.php");
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
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
		  Nouveau mot de passe appliqué !
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>';
	unset($_SESSION['passEdited']);
}
if(isset($_SESSION['badPass']) && $_SESSION['badPass'] === true){
	echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
		  <strong>Erreur: </strong>mot de passe faible (8 caracters minimum, majuscules, minuscules, chiffres et caractères spéciaux)!
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>';
	unset($_SESSION['badPass']);
}
?>
<a href="index.php">Retour aux messages</a>
<?php include('footer.php') ?>