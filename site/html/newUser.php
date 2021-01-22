<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
        header('location: login.php');
    }

    $user = $password = $validity = $role = "";
    $user_err = $password_err = "";

    include("utils.php");

    if(isset($_POST['submitNewUser'])){
        $checkuser = $db->query("SELECT * FROM account WHERE username=".'"'.$_POST['user'].'"')->fetch();
        if(!empty($_POST['user'])){
            if(!$checkuser){
                $user = $_POST['user'];
            } else {
                $user_err = "Utilisateur déjà existant !";
            }
        } else {
            $user_err = "Nom d'utilisateur requis !";
        }

        if(!empty($_POST['password'])){
            $password = $_POST['password'];
        } else {
            $password_err = "Mot de passe requis !";
        }

        $validity = $_POST['validity'];
        $role = $_POST['role'];

        if(empty($user_err) && empty($password_err)){
            $_SESSION['newUsername'] = $user;
            $_SESSION['newUserpass'] = $password;
            $_SESSION['newUservalidity'] = $validity;
            $_SESSION['newUserrole'] = $role;
        }
        header("location: addUser.php");
    }
    include('header.php');
?>
<div class="row px-5 mx-5">
    <form class="mx-5 px-4">
        <div class="form-row">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" class="form-control" id="username" name="user" placeholder="Nom d'utilisateur">
        </div>
        <div class="form-row">
            <label for="pass">Password:</label>
            <input type="password" class="form-control" id="pass" name="password" placeholder="Mot de passe">
        </div>
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