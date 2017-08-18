<?php
    session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="page.css" />
    <link rel="stylesheet" type="text/css" href="header.css" />
    <title>Chiabrena</title>
</head>
<body>
<?php
include_once("verifpage.php");
include_once("header.php");

try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<div class='error'>Database access error : " . $e->getMessage() . "</div>");
}

if ($_POST['submit'] && $_POST['submit'] == "Confirmer" && $_POST['username'] && $_POST['mail'] && $_POST['password'] && $_POST['confirm_password'])
{
    $pw = hash('whirlpool', $_POST['password']);
    $cpw = hash('whirlpool', $_POST['confirm_password']);
    $user_already_exists = 0;
    $mail_already_exists = 0;
    if ($pw === $cpw)
    {
        $user = $_POST['username'];
        $mail = $_POST['mail'];
        try
        {
            $usn_exists = $db->prepare('SELECT username FROM users WHERE username="'.$user.'"');
            $usn_exists->execute();
            if ($usn_exists->fetch() != NULL)
                $user_already_exists = 1;
            $mail_exists = $db->prepare('SELECT email FROM users WHERE email="'.$mail.'"');
            $mail_exists->execute();
            if ($mail_exists->fetch() != NULL)
                $mail_already_exists = 1;
            if (!$user_already_exists && !$mail_already_exists)
            {
                $newuser = $db->prepare('INSERT INTO users values("", "'.$user.'", "'.$pw.'", "'.$mail.'", FALSE)');
                $newuser->execute();
            }
        }
        catch (PDOException $e)
        {
	        die("<div class='error'>Database access error : " . $e->getMessage() . "</div>");
        }
    }
}
?>
    <hr style="margin:0; width:100%;" />
    <div class="form_inscription">
        <fieldset>
        <legend><h1 class="title_inscription">Chiabrena-inscription</h1></legend>
        <form action="inscription.php" method="post">
            <div class="inscription">
                Nom d'utilisateur: <input id="inscription" type="text" name="username" value=<?php echo''.$_POST["username"].''?>>
                <?php
                    if ($_POST['submit'] && $_POST['username'] == "")
                        echo '<span class="errmsg"> Nom d\'utilisateur non renseign&eacute;</span>
                            <script>
                                document.getElementById("inscription").focus();
                            </script>';
                    if ($user_already_exists)
                    {
                        echo '<span class="errmsg"> Le nom d\'utilisateur existe d&eacute;j&agrave;</span>
                            <script>
                                document.getElementById("inscription").focus();
                            </script>';
                    }
                ?>
                <br/>
            </div>
            <div class="inscription">
                Adresse mail: <input id="email" type="email" name="mail" value=<?php echo''.$_POST["mail"].''?>>
                <?php
                    if ($_POST['submit'] && $_POST['mail'] == "")
                    {
                        echo '<span class="errmsg"> Email non renseign&eacute;<span>';
                        if ($_POST['username'] != "")
                            echo '
                                <script>
                                    document.getElementById("email").focus();
                                </script>';
                    }
                    if ($mail_already_exists)
                    {
                        echo '<span class="errmsg"> L\'adresse mail est utilis&eacute;e</span>
                            <script>
                                document.getElementById("inscription").focus();
                            </script>';
                    }
                ?>
            <br />
            </div>
            <div class="inscription">
                Mot de passe: <input id="pw" type="password" name="password">
                <?php
                    if ($_POST['submit'] && $_POST['password'] == "")
                    {
                        echo '<span class="errmsg"> Mot de passe non renseign&eacute;<span>';
                        if ($_POST['username'] != "")
                            echo '
                            <script>
                                    document.getElementById("pw").focus();
                            </script>';
                    }
                ?>
            <br />
            </div>
            <div class="inscription">
                Valider le mot de passe: <input type="password" id="confirm_pw" name="confirm_password">
                <?php
                    if ($_POST['submit'] && hash('whirlpool', $_POST['password']) !== hash('whirlpool', $_POST['confirm_password']))
                    {
                        echo '<span class="errmsg"> Les mots de passe ne correspondent pas</span>
                        <script>
                                document.getElementById("confirm_pw").focus();
                        </script>';
                    }
                ?>
            </div>
            <br />
            <input type="submit" name="submit" value="Confirmer">
        </form>    
        </fieldset>
    </div>
</body>
</html>