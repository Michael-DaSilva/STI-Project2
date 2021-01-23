<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
        header('location: login.php');
    }

    $user = $password = $validity = $role = "";

    include("utils.php");

    if(isset($_POST['submitModifiedUser'])){
        if(!empty($_POST['password'])){
            $db->query("UPDATE account SET password=".'"'.$_POST['password'].'" WHERE username='.'"'.$_SESSION['user'].'"');
        }
        $db->query("UPDATE account SET validity=".$_POST['validity']." WHERE username=".'"'.$_SESSION['user'].'"');
        $db->query("UPDATE account SET role_id=".$_POST['role']." WHERE username=".'"'.$_SESSION['user'].'"');
        unset($_SESSION['user']);
        $_SESSION['userModified'] = true;
        header("location: manageUser.php");
    }

    if(isset($_GET['username'])){
        $checkuser = $db->query("SELECT validity, role_id FROM account WHERE username=".'"'.$_GET['username'].'"')->fetch();
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