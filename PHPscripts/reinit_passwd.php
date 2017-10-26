<?php
include_once("../config/database.php");
session_start();
try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<div class='error'>Database access error : " . $e->getMessage() . "</div>");
}
if ($_POST['submit'] == "Confirmation" && $_POST['password'] && $_POST['confirm_pw'])
{
    if ($_POST['password'] != $_POST['confirm_pw'])
    {
        header("Location:../index.php");
    }
    else if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 128)
    {
        header("Location:../index.php");
    }
    else if ($_SESSION['username_tmp'] != "")
    {
        $pass = hash('whirlpool', $_POST['password']);
        $user = $_SESSION['username_tmp'];
        echo $user." ".$pass;
        try
        {
            $db->beginTransaction();
            $update_pw = $db->prepare("UPDATE `users` SET `password` = ?, `email_key` = '' WHERE `username` = ?");
            $update_pw->bindParam(1, $pass);
            $update_pw->bindParam(2, $user);
            $update_pw->execute();
            $db->commit();
            $_SESSION['redirect_message'] = "Mot de passe changé !";
            header("Location: ../redirect.php");
        }
        catch (PDOException $e)
        {
            $db->rollBack();
            die("Error" . $e->getMessage());
        }
    }
}
else
    header("Location ../index.php");
?>