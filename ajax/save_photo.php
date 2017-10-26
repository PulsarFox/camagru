<?php
session_start();
include_once('../config/database.php');
date_default_timezone_set('Europe/Paris');
if ($_POST['pic'] && $_POST['time'] && $_SESSION['username'])
{
    $tmp = $_POST['pic'];
    $data = str_replace("data:image/png;base64,", "", $tmp);
    $picture = imagecreatefromstring(base64_decode($data));
    $timestamp = $_POST['time'];

    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error";
    }
    $path = dirname(getcwd(), 1)."/images/myimages/"; 
    if (!is_dir($path))
        mkdir($path, "0777");
    $datetime = date('Y-m_H-i-s', $timestamp / 1000);
    $user = $_SESSION['username'];
    $imgname = "Chiabrena-".$user."_".$datetime.".png";
    $imagepath = $path.$imgname;
    if (imagepng($picture, $imagepath))
    {
        try {
            $db->beginTransaction();
            $newpic = $db->prepare("INSERT INTO images values(null, ?, ?, ?, 0)");
            $newpic->bindParam(1, $user, PDO::PARAM_STR);
            $newpic->bindParam(2, $imgname, PDO::PARAM_STR);
            $newpic->bindParam(3, $timestamp, PDO::PARAM_STR);
            $newpic->execute();
            $db->commit();
            echo "Ok";
        } catch(PDOException $e) {
            $db->rollBack();
            echo "Error";
        }
    }
    else
    {
        try {
            $db->beginTransaction();
            $id = $db->prepare("SELECT `id` FROM `users` WHERE `username` = ?");
            $id->bindParam(1, $user);
            $id->execute();
            $lel = $id->fetch();
            $db->commit();
        } catch(PDOException $e) {
            $db->rollBack();
            echo "error3";
        }
        $imgname = "Chiabrena-User_id_".$lel['id']."_".$datetime.".png";
        $imagepath = $path.$imgname;
        if (imagepng($picture, $imagepath))
        {
            try {
                $db->beginTransaction();
                $newpic = $db->prepare("INSERT INTO images values(null, ?, ?, ?, 0)");
                $newpic->bindParam(1, $user, PDO::PARAM_STR);
                $newpic->bindParam(2, $imgname, PDO::PARAM_STR);
                $newpic->bindParam(3, $timestamp, PDO::PARAM_STR);
                $newpic->execute();
                $db->commit();
                echo "Ok";
            } catch(PDOException $e) {
                $db->rollBack();
                echo "Error";
            }
        }
        else
            echo "Error creating image file";
    }
}
else
    header('Location:http://'.$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/".basename(dirname(getcwd(), 1)).'/index.php');
?>