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
            $receiver = htmlentities($_POST['receiver']);
        } else {
            $receiver_err = "Destinataire requis !";
        }

        if(!empty($_POST['subject'])){
            $subject = htmlentities($_POST['subject']);
        } else {
            $subject_err = "Sujet requis !";
        }
        if(!empty($_POST['content'])){
            $content = htmlentities($_POST['content']);
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
?>

<form method="post" id="newEmail">
    Destinataire: <input type="text" name="receiver" value="<?php echo $receiver; ?>"><?php echo $receiver_err; ?><br>
    Sujet: <input type="text" name="subject" value="<?php echo $subject; ?>"><?php echo $subject_err; ?><br>
    Message: <textarea rows="6" cols="50" name="content" form="newEmail"><?php echo $content; ?></textarea><br/>
    <?php echo $content_err; ?>
    <input type="submit" name="submitEmail" value="Envoyer">
</form>
<?php if(isset($_SESSION['emailSent']) && $_SESSION['emailSent'] === true){
    echo "<h4>Message envoye!</h4>";
    unset($_SESSION['emailSent']);
} ?>
<a href="index.php">Retour</a>