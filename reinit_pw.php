<?php
    session_start();
    $is_ok = 0;
    include_once("config/database.php");
    if($_SESSION['connected'])
        header("Location: ./index.php");
    else
    {
        $_SESSION['username_tmp'] = "";
        if ($_GET['key'] && $_GET['user'])
        {
            $key = $_GET['key'];
            $user = $_GET['user'];
            try {
                $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                alert("Database access error : " . $e->getMessage());
            }
            try {
                $prep_key = $db->prepare("SELECT `email_key`, `username` FROM `users` WHERE `email_key` = ?");
                $prep_key->bindParam(1, $key);
                $prep_key->execute();
                $resp = $prep_key->fetch();
                if ($resp != NULL)
                {
                    if ($resp['username'] == $user)
                    {
                        $is_ok = 1;
                        $_SESSION['username_tmp'] = $user;
                    }
                    else
                        header("Location: ./index.php");
                }
                else
                    header("Location: ./index.php");
            } catch (PDOException $e)
            {
                alert("Database error ".$e->getMessage());
            }
        }
        else
            header("Location: ./index.php");
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="favicon.png" />
    <link rel="stylesheet" type="text/css" href="style/page.css" />
    <link rel="stylesheet" type="text/css" href="style/header.css" />
    <title>Chiabrena</title>
</head>
<body>
<?php
include_once("verifpage.php");
include_once("header.php");
if ($is_ok == 1)
{
    echo '<div class="form_reset_pw">
            <form action="./PHPscripts/reinit_passwd.php" method="post" onSubmit="return valid()">
                <p>Entrez votre nouveau mot de passe</p>
                <input type="password" id="pw" name="password" /><br/><span id="pw_error"></span>
                <p>Confirmez votre mot de passe</p>
                <input type="password" id="conf_pw" name="confirm_pw" /><br /><span id="conf_error"></span>
                <br />
                <input class="conf_button_reset" type="submit" name="submit" value="Confirmation" /> 
            </form>
        </div>';

} else {
    echo "<span style='margin:0 auto'>Vous n'avez pas le droit d'acceder a cette page.</span>";
}
?>
<script>
    var pw_field = document.getElementById("pw");
    var conf_field = document.getElementById("conf_pw");
    var pw_ok = 0;
    var conf_ok = 0;
    pw_field.addEventListener('keyup', function(){
        var re = /^\w+$/;
        if (pw_field.value == "")
        {
            pw_field.style.borderColor = "";
            pw_ok = 0;
            pw_error.innerHTML = "";
        }
        else if (!re.test(pw_field.value))
        {
            pw_field.style.borderColor = "red";
            pw_ok = 0;
            pw_error.innerHTML = "Caract&egrave;s ill&eacute;gaux : non alphanumeriques / underscore";
        }
        else if (pw_field.value.length < 6)
        {
            pw_field.style.borderColor = "red";
            pw_ok = 0;
            pw_error.innerHTML = "Le mot de passe doit comporter plus de 6 caract&egrave;res";
        }
        else if (pw_field.value != "" && conf_field.value != "" && pw_field.value != conf_field.value)
        {
            pw_field.style.borderColor = "red";
            pw_ok = 0;
            pw_error.innerHTML = "Les mots de passe ne correspondent pas";

        }
        else
        {
            pw_field.style.borderColor = "green";
            pw_error.innerHTML = "<img class=\"okimg\" src=\"images/ok.png\" alt=\"\" title=\"ok\"/>";
            pw_ok = 1;
        }
    }, false);

    conf_field.addEventListener('keyup', function(){
        if (conf_field.value == "")
        {
            conf_error.innerHTML = "";
            conf_field.style.borderColor = "";
            conf_ok = 0;
        }
        else if (conf_field.value != "" && pw_field.value != "" && conf_field.value == pw_field.value)
        {

            conf_error.innerHTML = "<img class=\"okimg\" src=\"images/ok.png\" alt=\"\" title=\"ok\"/>";
            conf_field.style.borderColor = "green";
            conf_ok = 1;
        }
        else
        {
            conf_error.innerHTML = "Les mots de passe ne correspondent pas";
            conf_field.style.borderColor = "red";
            conf_ok = 0;
        }
    }, false);

    function valid()
    {
        if (pw_ok == 1 && conf_ok == 1)
            return true;
        else
            return false;
    }
</script>
</body>
</html>