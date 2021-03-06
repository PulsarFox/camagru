<?php
session_start();
include_once("../config/database.php");
if (!empty($_POST['login']))
{
    if ($_POST['user_login'] && $_POST['password_login'])
    {
        $user_login = $_POST['user_login'];
        try {
            $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $user_req = $pdo->prepare('SELECT `username`, `is_active` FROM users WHERE username=?');
            $user_req->bindParam(1, $user_login, PDO::PARAM_STR);
            $user_req->execute();
            if (($user = $user_req->fetch()) != NULL)
            {
                if ($user['is_active'] == 0)
                {
                    $_SESSION['redirect_message'] = "Votre compte n'est pas activé.";
                    header("Location:../redirect.php");
                    exit;
                }
                $pw_login = hash('whirlpool', $_POST['password_login']);
                $pw_req = $pdo->prepare('SELECT password FROM users WHERE password=?');
                $pw_req->bindParam(1, $pw_login, PDO::PARAM_STR);
                $pw_req->execute();
                if ($pw_req->fetch() != NULL)
                {
                    $_SESSION['connected'] = "ok";
                    $_SESSION['login_error'] = '';
                    $_SESSION['username'] = $_POST['user_login'];
                }
                else
                    $_SESSION['login_error'] = "incorrect_pw";
            }
            else
                $_SESSION['login_error'] = "incorrect_acc";
        } catch (PDOException $e) {
            die("<div class='error'>Database access error : " . $e->getMessage() . "</div>");
        }
    }
    else if (!$_POST['user_login'] && !$_POST['password_login'])
        $_SESSION['login_error'] = "blank_fields";
    else if (!$_POST['password_login'])
        $_SESSION['login_error'] = "blank_password";
    else
        $_SESSION['login_error'] = "blank_username";
    if (basename($_SERVER['HTTP_REFERER'], ".php") == "inscription")
    {
        header("Location: ../index.php");
        exit;
    }
    else
    {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit;
    }
}
else
{
    exit;
    header('Location:../index.php');
}

?>
