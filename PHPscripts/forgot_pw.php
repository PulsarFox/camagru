<?php
    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("<div class='error'>Database access error : " . $e->getMessage() . "</div>");
    }
    if ($_POST['submit'] == "Envoyer" && $_POST['mail'])
    {
        try{
            $mail_exists = $db->prepare("SELECT `mail` FROM users WHERE `mail`=?");
            $mail_exists->bindParam(1, $_POST['mail']);
            $mail_exists->execute();
            if (($mail = $mail_exists->fetch()) != NULL)
            {
                $from_mail = "admin@chiabrena.com";
                $from_name = "Dieu";
                $subject = 'Nouveau mot de passe';
                $message = '
                    <html>
                    <body>
                    <p>Bonjour, '.htmlspecialchars($user).'
                    <br />
                    <br />
                    
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
                    header("Location: ../index.php");
            }
        }catch(PDOException $e) {
            die("<div class='error'>Database access error : " . $e->getMessage() . "</div>");
        }
    }
    else
        header("Location: ../forgot.php");
?>