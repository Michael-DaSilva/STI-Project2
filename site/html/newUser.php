<!--
STI-Project2 2021
Groupe: Michaël da Silva & Guillaume Schranz

Changement apporté:
- Prepare statement contre les injections SQL
- htmlentities contre les attaques XSS
- accès restreint à l'admin
- Getion des mots de passe forts (checkPass.php)
-->
<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
        header('location: login.php');
    }
	
	if(!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] === false){
		header('location: index.php');
    }

    $user = $password = $validity = $role = "";
    $user_err = $password_err = "";

    include("utils.php");
    include('checkPass.php');

    if(isset($_POST['submitNewUser'])){
		$stmt = $db->prepare("SELECT * FROM account WHERE username=?");
		$stmt->bindParam(1, $_POST['user']);
		$stmt->execute();
		$checkuser = $stmt->fetch();
		
        if(!empty($_POST['user'])){
            if(!$checkuser){
                $user = htmlentities($_POST['user']);
            } else {
                $user_err = "Utilisateur déjà existant !";
            }
        } else {
            $user_err = "Nom d'utilisateur requis !";
        }

        if(!empty($_POST['password'])){
            $password = htmlentities($_POST['password']);
            if(!check_mdp_format($_POST['password'])) {
                $password_err = "Erreur: mot de passe faible (8 caracters minimum, majuscules, minuscules et chiffres)!";
            }
            $hash = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $password_err = "Mot de passe requis !";
        }

        $validity = htmlentities($_POST['validity']);
        $role = htmlentities($_POST['role']);

        if(empty($user_err) && empty($password_err)){
            $_SESSION['newUsername'] = $user;
            $_SESSION['newUserpass'] = $hash;
            $_SESSION['newUservalidity'] = $validity;
            $_SESSION['newUserrole'] = $role;
			header("location: addUser.php");
        }
    }
    include('header.php');
?>
<div class="row px-5 mx-5">
    <form class="mx-5 px-4">
        <div class="form-row">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" class="form-control" id="username" name="user" placeholder="Nom d'utilisateur">
        </div>
		<?php
		if(!empty($user_err)){
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Erreur: </strong>'.$user_err.'
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>';
		}
		?>
        <div class="form-row">
            <label for="pass">Password:</label>
            <input type="password" class="form-control" id="pass" name="password" placeholder="Mot de passe">
        </div>
		<?php
		if(!empty($password_err)){
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <strong>Erreur: </strong>'.$password_err.'
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>';
		}
		?>
        <div class="form-row">
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" id="validN" name="validity" value="0" checked>
                <label class="form-check-label" for="validN">Compte inactif</label>
                <input type="radio" class="form-check-input" id="validY" name="validity" value="1">
                <label class="form-check-label" for="validY">Compte actif</label>
            </div>
        </div>
        <div class="form-row">
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" id="roleC" name="role" value="1" checked>
                <label class="form-check-label" for="roleC">Collaborateur</label>
                <input type="radio" class="form-check-input" id="roleA" name="role" value="2">
                <label class="form-check-label" for="roleA">Administrateur</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" formmethod="post" name="submitNewUser">Ajouter l'utilisateur</button>
        <a href="manageUser.php" class="btn btn-primary" role="button">Annuler</a>
    </form>
</div>
<?php include('footer.php') ?>