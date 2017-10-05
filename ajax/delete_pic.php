<?php
session_start();
include_once("../config/database.php");
if($_POST['pic_id'])
{
    $id = $_POST['pic_id'];
    $path = $_SERVER['DOCUMENT_ROOT']."/camagru/images/myimages/";

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
            echo $pic['username'];
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
?>