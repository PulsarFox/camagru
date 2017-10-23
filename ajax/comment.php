<?php
session_start();
include_once("../config/database.php");
if(!empty($_SESSION['username']) && $_SESSION['username'] != $_POST['username'])
    echo "canaillou";
else if($_POST['pic_id'] && $_POST['username'] && $_POST['post'] && $_POST['user_pic'])
{
    $id = $_POST['pic_id'];
    $user = $_POST['username'];
    $comment = $_POST['post'];
    $photo_from = $_POST['user_pic'];
    if (mb_strlen($comment) > 1000)
        echo "too_long";
    else
    {
        try {
            $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error connection db";
        }
        try {
            $time = time();
            $db->beginTransaction();
            $comment_req = $db->prepare("INSERT INTO `comments` values(null, ?, ?, ?, ?)");
            $comment_req->bindParam(1, $id, PDO::PARAM_INT);
            $comment_req->bindParam(2, $user, PDO::PARAM_STR);
            $comment_req->bindParam(3, $comment, PDO::PARAM_STR);
            $comment_req->bindParam(4, $time, PDO::PARAM_INT);
            $comment_req->execute();
            $mail_req = $db->prepare("SELECT `email` FROM `users` WHERE `username` = ?");
            $mail_req->bindParam(1, $photo_from, PDO::PARAM_STR);
            $mail_req->execute();
            $mail = $mail_req->fetch();
            $db->commit();
            if ($mail != NULL)
            {
                $from_mail = "admin@chiabrena.com";
                $from_name = "Chiabrena-Dieu";
                $subject = 'Un commentaire vient d\'être publié !';
                $message = '
                <html>
                <body>
                <p>Bonjour, '.htmlspecialchars($user).'
                <br />
                <br />
                Le commentaire suivant vient d\'être publié sur votre photo du //insert date<br/>
                '.$comment.'
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
                if (mail("samy.vincentffs@gmail.com", $subject, $message, $header) == TRUE)
                    echo "ok";
                else
                    echo "Erreur envoi mail";
            }
            else
                echo "Le nom d'utilisateur n'existe pas";
        } catch (PDOException $e) {
            $db->rollBack();
            echo "Error";
        }
    }
}
?>