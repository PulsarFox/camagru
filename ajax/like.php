<?php
session_start();
include_once('../config/database.php');
if ($_SESSION['username'] != $_POST['user'])
    echo "canaillou";
else if($_POST['id'] && $_POST['user'])
{
    $id = $_POST['id'];
    $like = $_POST['is_like'];
    $user = $_POST['user'];
    $nb = $_POST['nb_like'];

    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error";
    }
    try {
        $has_voted_req = $db->prepare("SELECT `id` FROM `likes_log` WHERE `id_image` = ? AND `username` = ?");
        $has_voted_req->bindParam(1, $id, PDO::PARAM_INT);
        $has_voted_req->bindParam(2, $user, PDO::PARAM_STR);
        $has_voted_req->execute();
        if ($has_voted_req->fetch() == NULL)
        {
            $update_req = $db->prepare("UPDATE `images` SET `likes` = `likes` + ? WHERE `id` = ?");
            $update_req->bindParam(1, $like, PDO::PARAM_INT);
            $update_req->bindParam(2, $id, PDO::PARAM_INT);
            $update_req->execute();
            $like_log_req = $db->prepare("INSERT INTO `likes_log` values(null, ?, ?, ?)");
            $like_log_req->bindParam(1, $user, PDO::PARAM_STR);
            $like_log_req->bindParam(2, $id, PDO::PARAM_INT);
            $like_log_req->bindParam(3, $like, PDO::PARAM_INT);
            $like_log_req->execute();
            $nb_like = $db->prepare("SELECT `likes` FROM `images` WHERE `id` = ?");
            $nb_like->bindParam(1, $id, PDO::PARAM_INT);
            $nb_like->execute();
            $ret = $nb_like->fetch();
            echo $ret[0];
        }
        else
            echo $nb;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>