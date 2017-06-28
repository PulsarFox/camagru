<?php
$page = basename($_SERVER["PHP_SELF"], ".php");
if ($page != "index" && $page != "gallerie" && $page != "myaccount" && $page != "snaproom")
    header('Location:./index.php');
?>