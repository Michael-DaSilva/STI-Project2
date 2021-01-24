<!--
STI-Project2 2021
Groupe: Michaël da Silva & Guillaume Schranz

Changement apporté:
- Prepare statement contre les injections SQL
- Ajout de limite de charactères dans l'input de l'utilisateur (receiver, subject, content)
- htmlentities contre les attaques XSS
-->
<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false){
        header('location: login.php');
    }

    $receiver = $subject = $content = "";
    $receiver_err = $subject_err = $content_err = "";

    include("utils.php");

    if(isset($_POST['submitEmail'])){
        if(!empty($_POST['receiver'])){
			if(strlen($_POST['receiver']) <= 50){
				$receiver = htmlentities($_POST['receiver']);
			} else {
				$receiver_err = "Limite de charactères atteintes (50)!";
			}
        } else {
            $receiver_err = "Destinataire requis !";
        }

        if(!empty($_POST['subject'])){
			if(strlen($_POST['subject']) <= 50){
				$subject = htmlentities($_POST['subject']);
			} else {
				$subject_err = "Limite de charactères atteintes (50)!";
			}
        } else {
            $subject_err = "Sujet requis !";
        }
		
        if(!empty($_POST['content'])){
			if(strlen($_POST['content']) <= 1000){
				$content = htmlentities($_POST['content']);
			} else {
				$content_err = "Limite de charactères atteintes (1000)!";
			}
        } else {
            $content_err = "Message vide !";
        }
		
        if(empty($receiver_err) && empty($subject_err) && empty($content_err)){
			$stmt = $db->prepare("SELECT * FROM account WHERE username=?");
			$stmt->bindParam(1,$receiver);
			$stmt->execute();
            $checkreceiver = $stmt->fetch();
            $receiverexist = !empty($checkreceiver);

            if($receiverexist){
                $_SESSION['newEmailreceiver'] = $receiver;
                $_SESSION['newEmailsubject'] = $subject;
                $_SESSION['newEmailcontent'] = $content;

                header('location: sendEmail.php');
            } else {
                $receiver_err = "Destinataire inconnu !";
            }
        }
    }

    if(isset($_GET['id'])){
		$stmt = $db->prepare("SELECT messageDate, sender, subject, receiver, messageContent FROM messages WHERE id=?");
		$stmt->bindParam(1,$_GET['id']);
		$stmt->execute();
        $messageDetails = $stmt->fetch();
        if($_SESSION['username'] === $messageDetails['receiver']){
            $receiver = $messageDetails['sender'];
            $subject = "RE: ".$messageDetails['subject'];
            $content = "\n\n------------------------------------------------------------\nDe : ".$receiver."\nEnvoyé le : ".$messageDetails['messageDate']."\nSujet : ".$messageDetails['subject']."\nMessage :\n\n".$messageDetails['messageContent'];
        }
    }
	include("header.php");
?>

<form method="post" id="newEmail">
    Destinataire: <input type="text" name="receiver" maxlength="50" value="<?php echo $receiver; ?>"><?php echo $receiver_err; ?><br>
    Sujet: <input type="text" name="subject" maxlength="50" value="<?php echo $subject; ?>"><?php echo $subject_err; ?><br>
    Message: <textarea rows="6" cols="50" name="content" form="newEmail" maxlength="1000"><?php echo $content; ?></textarea><br/>
    <?php echo $content_err; ?>
    <input type="submit" name="submitEmail" value="Envoyer">
</form>
<?php if(isset($_SESSION['emailSent']) && $_SESSION['emailSent'] === true){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
		  Message envoye!
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>';
	unset($_SESSION['emailSent']);
}?>
<a href="index.php">Retour</a>
<?php include("footer.php"); ?>