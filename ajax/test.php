<?php
session_start();
include_once('../config/database.php');
try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "<div class='error'>Database access error : " . $e->getMessage() . "</div>";
}
if ($_POST['username'])
{
    $user = $_POST['username'];
    try {
        $usn_exists = $db->prepare("SELECT `username` FROM `users` WHERE `username`=?");
        $usn_exists->bindParam(1, $user, PDO::PARAM_STR);
        $usn_exists->execute();
        if ($usn_exists->fetch() != NULL)
            echo "Exists";
        else
            echo "Ok";
    } catch (PDOException $e)
    {
	    echo "<div class='error'>User access error : " . $e->getMessage() . "</div>";
    }
}
else if ($_POST['mail'])
{
    $mail = $_POST['mail'];
    $re = "/^[a-z'0-9]+([._-][a-z'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/";
    if (preg_match($re, $mail) == NULL)
    {
        echo "Invalid";
        return;
    }
    try {
        $mail_exists = $db->prepare("SELECT email FROM users WHERE email=?");
        $mail_exists->bindParam(1, $mail, PDO::PARAM_STR);
        $mail_exists->execute();
        if ($mail_exists->fetch() != NULL)
            echo "Exists";
        else
            echo "Ok";
    } catch (PDOException $e)
    {
	    echo "<div class='error'>Mail access error : " . $e->getMessage() . "</div>";
    }
}
else
    header('Location:http://'.$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/".basename(dirname(getcwd(), 1)).'/index.php');
?>