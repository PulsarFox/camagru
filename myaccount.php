<?php
    session_start();
    if (!$_SESSION['connected'])
        header('Location: ./index.php');
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style/page.css" />
    <link rel="stylesheet" type="text/css" href="style/header.css" />
    <title>Chiabrena - Account</title>
</head>
<body>
    <?php
    include_once("verifpage.php");
    include_once("header.php");
    include_once("config/setup.php");
    ?>
    <div class="account_block">
        <div class="account_title">
        </div>
        <div class="account_inner_block">
            <div class="account_reset_block">
            </div>
            <div class="account_delete_block">
            </div>
        </div>
    </div>