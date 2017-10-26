<?php
session_start();
include_once("../config/database.php");include_once("../config/database.php");
if ($_SESSION['username'] != $_POST['user'])
    echo "canaillou";
else if($_POST['pic_id'] && $_POST['user'])
{
    $id = $_POST['pic_id'];
    $user = $_POST['user'];
    $path = dirname(getcwd(), 1)."/images/myimages/";

    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error connection db";
    }
    try {
        $pic_req = $db->prepare("SELECT `src`, `username` FROM images WHERE `id` = ?");
        $pic_req->bindParam(1, $id, PDO::PARAM_INT);
        $pic_req->execute();
        $pic = $pic_req->fetch();
        if ($pic['username'] != $_SESSION['username'])
            echo "canaillou";
        else
        {
            $src = $pic['src'];
            if (unlink($path.$src))
            {
                $pic_del = $db->prepare("DELETE FROM `images` WHERE `id` = ?");
                $pic_del->bindParam(1, $id, PDO::PARAM_INT);
                $pic_del->execute();
                $com_del = $db->prepare("DELETE FROM `comments` WHERE `id_image` = ?");
                $com_del->bindParam(1, $id, PDO::PARAM_INT);
                $com_del->execute();
                echo "ok";
            }
            else
                echo $path.$src;
        }
    } catch(PDOException $e) {
        echo "Error";
    }
}
else
    header('Location:http://'.$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/".basename(dirname(getcwd(), 1)).'/index.php');
?>