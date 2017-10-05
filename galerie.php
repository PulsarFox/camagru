<?php
    session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style/page.css" />
    <link rel="stylesheet" type="text/css" href="style/header.css" />
    <script type="text/javascript" src="scripts/infinite_scroll.js"></script>
    <script type="text/javascript" src="scripts/like.js"></script>
    <title>Camagru - gallerie</title>
</head>
<body>
    <?php
    include_once('verifpage.php');
    include_once("header.php");
    ?>
    <hr style="width:100%; margin:0" />
    <div id="galerie_block">
        <div id="loader">
            <p>Loading...</p>
        </div>
    </div>
    <?php
    include_once("footer.php");
    ?>
</body>
</html>