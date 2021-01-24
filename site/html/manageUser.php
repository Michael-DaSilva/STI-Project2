<!--
STI-Project2 2021
Groupe: Michaël da Silva & Guillaume Schranz

Changement apporté:
- htmlentities contre les attaques XSS
- accès restreint à l'admin
-->
<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
        header('location: login.php');
    }

	if(!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] === false){
      header('location: index.php');
    }

    include("utils.php");

    try {
        $users = $db->query("SELECT username FROM account");
    } catch(PDOException $e){
        echo $e->getMessage();
    }
    include('header.php');
?>
<?php if(isset($_SESSION['userModified']) && $_SESSION['userModified'] === true)
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  Utilisateur modifié !
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
else if(isset($_SESSION['userModified']) && $_SESSION['userModified'] === false)
    echo '<div class="alert alert-alert alert-dismissible fade show" role="alert">
                  <strong>Erreur: </strong> l'."'".'utilisateur n'."'".'a pas pu être modifié. Veuillez réessayer plus tard.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
unset($_SESSION['userModified']); ?>
<?php if(isset($_SESSION['userDeleted']) && $_SESSION['userDeleted'] === true)
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  Utilisateur supprimé !
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
else if(isset($_SESSION['userDeleted']) && $_SESSION['userDeleted'] === false)
    echo '<div class="alert alert-alert alert-dismissible fade show" role="alert">
                  <strong>Erreur: </strong> l'."'".'utilisateur n'."'".'a pas pu être supprimé. Veuillez réessayer plus tard.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
unset($_SESSION['userDeleted']); ?>
<?php if(isset($_SESSION['userAdded']) && $_SESSION['userDeleted'] === true)
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  Nouvel Utilisateur ajouté !
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
unset($_SESSION['userAdded']); ?>
<table id="t01" class="table">
    <thead class="thead-light">
    <tr>
        <th scope="col">Utilisateur</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($users as $u){
        echo "<tr>";
        echo "<td>".htmlentities($u['username'])."</td>";
        echo "<td>";
        echo '<div class="btn-group-vertical btn-group-sm btn-outline-dark pt-1">
                <a href="modifyUser.php?username='.$u['username'].'" class="btn btn-secondary" role="button">Modifier l'."'".'utilisateur</a>
                <a href="delUser.php?username='.$u['username'].'" class="btn btn-secondary" role="button">Supprimer l'."'".'utilisateur</a>
            </div>';
        echo "</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<a href="newUser.php" class="btn btn-primary" role="button">Créer un nouvel utilisateur</a>
<a href="index.php" class="btn btn-primary" role="button">Retour</a>
<?php include('footer.php') ?>