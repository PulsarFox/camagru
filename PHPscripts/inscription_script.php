<?php
session_start();
include_once('../config/database.php');
try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<div class='error'>Database access error : " . $e->getMessage() . "</div>");
}

$is_valid = FALSE;
if ($_POST['submit'] && $_POST['submit'] == "Confirmer" && $_POST['username'] && $_POST['mail'] && $_POST['password'])
{
    $pw = hash('whirlpool', $_POST['password']);
    $cpw = hash('whirlpool', $_POST['confirm_password']);
    if ($_POST['confirm_password'] != NULL && $pw === $cpw)
    {
        $user = $_POST['username'];
        $mail = $_POST['mail'];
        try
        {
            $db->beginTransaction();
            $usn_exists = $db->prepare("SELECT username FROM users WHERE username=?");
            $usn_exists->bindParam(1, $user, PDO::PARAM_STR);
            $usn_exists->execute();
            if ($usn_exists->fetch() != NULL)
                $_SESSION['inscription_error'] = "Utilisateur invalide";
            else
            {
                $mail_exists = $db->prepare("SELECT email FROM users WHERE email=?");
                $mail_exists->bindParam(1, $mail, PDO::PARAM_STR);
                $mail_exists->execute();
                if ($mail_exists->fetch() != NULL)
                    $_SESSION['inscription_error'] = "Email invalid";
                else
                {
                    $key = md5(uniqid(rand(), true));
                    $newuser = $db->prepare('INSERT INTO users values(NULL, ?, ?, ?, ?, FALSE,FALSE, NULL)');
                    $newuser->bindParam(1, $user, PDO::PARAM_STR);
                    $newuser->bindParam(2, $pw, PDO::PARAM_STR);
                    $newuser->bindParam(3, $mail, PDO::PARAM_STR);
                    $newuser->bindParam(4, $key, PDO::PARAM_STR);
                    $newuser->execute();
                    $last_id = $db->lastInsertId();
                    $is_valid = TRUE;
                    $_SESSION['inscription_error'] = "bug plus loin";
                }
            }
           $db->commit();
        }
        catch (PDOException $e)
        {
            $db->rollBack();
	        echo "<div class='error'>Database access error : " . $e->getMessage() . "</div>";
        }
    }
    if ($is_valid == FALSE)
        header('Location:../inscription.php');
    else
    {
        $from_mail = "admin@chiabrena.com";
        $from_name = "Dieu";
        $subject = 'Inscription to Chiabrena';
        $message = '
        <html>
        <body>
        <p>Bonjour, '.htmlspecialchars($user).'
        <br />
        <br />
        Pour valider votre inscription, veuillez cliquer sur le lien suivant :<br/>
        <a href="http://'.$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].'/camagru/mail.php?key='.$key.'&user='.htmlspecialchars($user).'">Valider</a></p>
        </body>
        </html>
        ';
        $message = wordwrap($message, 70, "\r\n");
        $encoding = "utf-8";
        $subj_pref = array("input-charset" => $encoding, "output-charset" => $encoding, "line-length" => 76, "line-break-chars" => "\r\n");
        $header = "Content-type: text/html; charset=".$encoding." \r\n";
        $header .= "From: ".$from_name." <".$from_mail."> \r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-Transfer-Encoding: 8bit \r\n";
        $header .= "Date: ".date("r (T)")." \r\n";
        $header .= iconv_mime_encode("Subject", $subject, $subj_pref);
        if (mail($mail, $subject, $message, $header) === TRUE)
        {
            $_SESSION['inscription_error'] = "Mail bien envoy&eacute; !";
        }
        else
        {
            try {
                $db->exec("DELETE FROM `users` WHERE id=".$last_id);
            } catch (PDOException $e){
                $_SESSION['inscription_error'] = "Problem delete user from db";
            } 
            $_SESSION['inscription_error'] = "Probleme lors de l'envoi du mail, recommencez votre inscription";
            
        }
    }
    header("Location: ../mail_send.php");
}

?>