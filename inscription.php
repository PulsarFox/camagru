<?php
    session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="favicon.png" />
    <link rel="stylesheet" type="text/css" href="style/page.css" />
    <link rel="stylesheet" type="text/css" href="style/header.css" />
    <script type="text/javascript" src="scripts/inscription_script.js"></script>
    <title>Chiabrena</title>
</head>
<body>
<?php
include_once("verifpage.php");
include_once("header.php");
?>
    <hr style="margin:0; width:100%;" />
    <div class="form_inscription">
        <fieldset>
        <legend><h1 class="title_inscription">Chiabrena-inscription</h1></legend>
        <form action="PHPscripts/inscription_script.php" method="post" onSubmit="return valid()">
            <div class="inscription">
                Nom d'utilisateur: <input id="user" type="text" name="username" /><span id="user_error"></span>
            <br/>
            </div>
            <div class="inscription">
                Adresse mail: <input id="mail" type="email" name="mail" /><span id="mail_error"></span>
                <?php
                    if ($_SESSION['inscription_error'] == "invalid")
                        echo "<span>Mail invalide</span>";
                    $_SESSION['inscription_error'] = "";
                ?>
            <br />
            </div>
            <div class="inscription">
                Mot de passe: <input id="pw" type="password" name="password"><span id="pw_error"></span>
            <br />
            </div>
            <div class="inscription">
                Valider le mot de passe: <input type="password" id="confirm_pw" name="confirm_password"><span id="confirm_pw_error"></span>
            </div>
            <br />
            <input id="submit_button" type="submit" name="submit" value="Confirmer">
        </form>    
        </fieldset>
    </div>
</body>
</html>