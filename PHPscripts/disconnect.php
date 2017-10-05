<?php
session_start();
$_SESSION['username'] = '';
$_SESSION['connected'] = '';
header("Location: ../index.php");
?>