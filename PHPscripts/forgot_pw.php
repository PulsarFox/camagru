<?php
session_start();
include_once("../config/database.php");
    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("<div class='error'>Database access error : " . $e->getMessage() . "</div>");
    }
    if ($_POST['submit'] == "Envoyer" && isset($_POST['mail']))
    {
        try{
            $key = md5(uniqid(rand(), true));
            $mail_exists = $db->prepare("SELECT `email`, `username` FROM `users` WHERE `email`=?");
            $mail_exists->bindParam(1, $_POST['mail']);
            $mail_exists->execute();
            if (($mail = $mail_exists->fetch()) != NULL)
            {
                $user = $mail['username'];
                $insert_key = $db->prepare("UPDATE `users` SET `email_key` = ? WHERE `email` = ?");
                $insert_key->bindParam(1, $key);
                $insert_key->bindParam(2, $mail['email']);
                $insert_key->execute();
                $from_mail = "admin@chiabrena.com";
                $from_name = "Dieu";
                $subject = 'Nouveau mot de passe';
                $message = '
                    <html>
                    <body>
                    <p>Bonjour, '.htmlspecialchars($user).'
                    <br />
                    <br />
                    Voici un lien pour réinitialiser votre mot de passe:<br/>
                    <a href="http://'.$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/".basename(dirname(getcwd(), 1)).'/reinit_pw.php?user='.$user.'&key='.$key.'">Réinitialisation</a>
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
                if (mail($mail['email'], $subject, $message, $header) === TRUE)
                {
                    $_SESSION['inscription_error'] = "Mail bien envoyé au ".$mail['email'];
                    header('Location:http://'.$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/".basename(dirname(getcwd(), 1)).'/mail_send.php');
                }
                else
                {
                    $_SESSION['mail_error'] = "Problème lors de l'envoi du mail";
                    header('Location:http://'.$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/".basename(dirname(getcwd(), 1)).'/forgot.php');
                }
            }
            else
            {
                $_SESSION['mail_error'] = "Le mail renseigné n'existe pas";
                header('Location:http://'.$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/".basename(dirname(getcwd(), 1)).'/forgot.php');
            }
        }catch(PDOException $e) {
            die("<div class='error'>Database access error : " . $e->getMessage() . "</div>");
        }
    }
    else
        header('Location:http://'.$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/".basename(dirname(getcwd(), 1)).'/index.php');
?>