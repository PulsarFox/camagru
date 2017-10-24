<?php
    session_start();
    $is_ok = 0;
    include_once("config/setup.php");
    if($_SESSION['connected'])
        header("Location: ./index.php");
    else
    {
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
    <script type="text/html">
        document.write("<!--");
    </script>
    <meta type="refresh" content="5;URL=index.php" />
    <script type="text/html">
        document.write("-->");
    </script>
</head>
<?php
include_once("verifpage.php");
include_once("header.php");
if ($is_ok == 1)
{

} else {
    echo "Mauvais lien ou truc pas bon";
}

?>