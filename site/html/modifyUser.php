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
	$password_err = "";

    include("utils.php");
    include('checkPass.php');

    if(isset($_POST['submitModifiedUser'])){		
		$stmt = $db->prepare("UPDATE account SET validity=? WHERE username=?");
		$stmt->bindParam(1, $_POST['validity']);
		$stmt->bindParam(2, $_SESSION['user']);
		$stmt->execute();
		
        $stmt = $db->prepare("UPDATE account SET role_id=? WHERE username=?");
		$stmt->bindParam(1, $_POST['role']);
		$stmt->bindParam(2, $_SESSION['user']);
		$stmt->execute();
		
		if(!empty($_POST['password'])){
			$password = $_POST['password'];
			
			if(!check_mdp_format($password)) {
                $password_err = $password_err = "Erreur: mot de passe faible (8 caracters minimum, majuscules, minuscules, chiffres et caractères spéciaux)!";
            }
			
			if(empty($password_err)){
				$stmt = $db->prepare("UPDATE account SET password=? WHERE username=?");
				$hash = password_hash($password, PASSWORD_DEFAULT);
				$stmt->bindParam(1, $hash);
				$stmt->bindParam(2, $_SESSION['user']);
				$stmt->execute();	
			}
        }
		
        unset($_SESSION['user']);
		unset($_POST['password']);
        $_SESSION['userModified'] = true;
		if(empty($password_err)){
			header("location: manageUser.php");
			exit();
		}
    }

    if(isset($_GET['username'])){
		$stmt = $db->prepare("SELECT validity, role_id FROM account WHERE username=?");
		$stmt->bindParam(1, $_GET['username']);
		$stmt->execute();
		
        $checkuser = $stmt->fetch();
        $user = htmlentities($_GET['username']);
        $validity = htmlentities($checkuser['validity']);
        $role = htmlentities($checkuser['role_id']);
    }
    include('header.php');
?>
<div class="row px-5 mx-5">
    <form class="mx-5 px-4">
        <div class="form-row">
            <label for="username">Nom d'utilisateur:</label>
            <?php echo $user; $_SESSION['user'] = $user ?>
        </div>
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
                <input type="radio" class="form-check-input" id="validN" name="validity" value="0" <?php if($validity == 0) echo "checked"?>>
                <label class="form-check-label" for="validN">Compte inactif</label>
                <input type="radio" class="form-check-input" id="validY" name="validity" value="1" <?php if($validity == 1) echo "checked"?>>
                <label class="form-check-label" for="validY">Compte actif</label>
            </div>
        </div>
        <div class="form-row">
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" id="roleC" name="role" value="1" <?php if($role == 1) echo "checked"?>>
                <label class="form-check-label" for="roleC">Collaborateur</label>
                <input type="radio" class="form-check-input" id="roleA" name="role" value="2" <?php if($role == 2) echo "checked"?>>
                <label class="form-check-label" for="roleA">Administrateur</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" formmethod="post" name="submitModifiedUser">Modifier l'utilisateur</button>
        <a href="manageUser.php" class="btn btn-primary" role="button">Annuler</a>
    </form>
</div>
<?php include('footer.php') ?>