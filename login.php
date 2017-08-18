<?php
session_start();
include_once("config/database.php");
if (isset($_POST['login']))
{
    if ($_POST['user_login'] && $_POST['password_login'])
    {
        $user_login = $_POST['user_login'];
        try {
            $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $user_req = $pdo->prepare('SELECT username FROM users WHERE username="'.$user_login.'"');
            $user_req->execute();
            if ($user_req->fetch() != NULL)
            {
                $pw_login = hash('whirlpool', $_POST['password_login']);
                $pw_req = $pdo->prepare('SELECT password FROM users WHERE password="'.$pw_login.'"');
                $pw_req->execute();
                if ($pw_req->fetch() != NULL)
                {
                    $_SESSION['connected'] = "ok";
                    $_SESSION['login_error'] = '';
                    $_SESSION['username'] = $user_login;
                }
                else
                    $pw_ok = "no";
            }
            else
                $login_ok = "no";
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
}
header("Location:".$_SERVER['HTTP_REFERER']);
?>
