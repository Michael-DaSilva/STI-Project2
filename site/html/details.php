<!--
STI-Project2 2021
Groupe: Michaël da Silva & Guillaume Schranz

Changement apporté:
- Prepare statement contre les injections SQL
- htmlentities contre les attaques XSS
-->
<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
        header('location: login.php');
    }

    include("utils.php");

    try {
		$stmt = $db->prepare('SELECT messageDate, sender, subject, messageContent FROM messages WHERE id=?');
		$stmt->bindParam(1, $_GET['id']);
		$stmt->execute();
        $message = $stmt->fetch();
    } catch(PDOException $e){
        echo $e->getMessage();
    }
    include('header.php');
?>
<div class="container pl-5 ml-5">
    <div class="row">
        <div class="col-8">
            <table class="table">
                <tr>
                    <th>Date de reception:</th>
                    <td><?php echo htmlentities($message['messageDate']);?></td>
                </tr>
                <tr>
                    <th>Expediteur:</th>
                    <td><?php echo htmlentities($message['sender']);?></td>
                </tr>
                <tr>
                    <th>Sujet:</th>
                    <td><?php echo htmlentities($message['subject']);?></td>
                </tr>
                <tr>
                    <th>Message :</th>
                    <td><?php echo nl2br(htmlentities($message['messageContent']))?></td>
                </tr>
            </table>
        </div>
        <div class="col-4">
            <div class="btn-group-vertical btn-group btn-outline-dark pt-1">
                <a href="newEmail.php?id=<?php echo $_GET['id'] ?>" class="btn btn-secondary" role="button">Repondre</a>
                <a href="delMessage.php?id=<?php echo $_GET['id']?>" class="btn btn-secondary" role="button">Supprimer</a>
            </div>
        </div>
    </div>
    <a href="index.php" class="btn btn-primary" role="button">Retour</a>
</div>
<?php include('footer.php') ?>