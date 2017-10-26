<?php
$page = basename($_SERVER["PHP_SELF"], ".php");
if ($page != "index" && $page != "galerie" && $page != "editeur" && $page != "forgot" && $page != "mail" && $page != "reinit_pw" && $page != "inscription" && $page != "mail_send.php")
    header('Location:http://'.$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/".basename(dirname(getcwd(), 1)).'/index.php');
?>