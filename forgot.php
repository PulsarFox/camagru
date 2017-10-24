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
    <title>Chiabrena</title>
</head>
<body>
    <?php
    include_once("verifpage.php");
    include_once("header.php");
    include_once("config/setup.php");
    ?>
    <div id="bloc_oubli" class="bloc_oubli">
        <p>Entrez votre adresse mail</p><br />
        <form action="PHPscripts/forgot_pw.php" method="post">
            <input class="oubli_mail" type="mail" name="mail" placeholder="Ex : mecsympa@ihaveagirlfriend" />
            <input class="oubli_button" type="submit" value="Envoyer" name="submit">
        </form>
    </div>
</body>
</html>