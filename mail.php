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
    include_once("verifpage.php");
    include_once("header.php");
    include_once("config/setup.php");
    if ($_GET['key'])
    {
        try {
            $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("<div class='error'>Database access error : " . $e->getMessage() . "</div>");
        }
        try {
            $keyvalid = $db->prepare("SELECT `key`, `username`, `is_active` FROM users WHERE `key` = ?");
            $keyvalid->bindParam(1, $_GET['key']);
            $keyvalid->execute();
            if (($tab = $keyvalid->fetch()) != NULL)
            {
                if ($tab['is_active'] == TRUE)
                    echo "Le compte est dej&agrave; activ&eacute;";
                else if ($tab['username'] == $_GET['user'])
                {
                    echo "Compte active";
                    $activate = $db->prepare("UPDATE users SET is_active = TRUE WHERE `username` = ? AND `key` = ?");
                    $activate->bindParam(1, $_GET['user']);
                    $activate->bindParam(2, $_GET['key']);
                    $activate->execute();
                    $_SESSION['connected'] = "ok";
                    $_SESSION['username'] = $_GET['user'];
                }
            }
            else
                echo "unknown error";
        } catch(PDOException $e) {
            die("<div class='error'>Select Error : ".$e->getMessage()."</div>");
        }
    }
    ?>
    <br />
    <p>Redirection dans <span id="compt">5</span> seconde<span id="s">s</span>.<br />
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