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
    <script type="text/html">
        document.write("<!--");
    </script>
    <meta type="refresh" content="5;URL=index.php" />
    <script type="text/html">
        document.write("-->");
    </script>
</head>
<body>
    <?php
    include_once("header.php");
    ?>
    <br />
    <p><?php
    if ($_SESSION['redirect_message'])
        echo $_SESSION['redirect_message'];
    $_SESSION['redirect_message'] = "";
    ?><br />
    Redirection dans <span id="compt">5</span> seconde<span id="s">s</span>.<br />
    Pour &ecirc;tre redirig&eacute; automatiquement, <a href="index.php">Cliquez ici</a></p>
    <script>
    var compt = document.getElementById('compt');
    var plural = document.getElementById('s');
    var i = 5;

    function refreshTimer()
    {
        compt.innerHTML = i;
        s.innerHTML = (i > 1) ? "s" : null;
        if (i <= 0)
            window.location.href = 'index.php';
        else
        {
            i--;
            setTimeout(refreshTimer, 1000);
        }
    }
    refreshTimer();
    </script>
</body>
</html>