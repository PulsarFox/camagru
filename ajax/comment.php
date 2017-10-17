<?php
session_start();
include_once("../config/database.php");
if($_SESSION['username'] != $_POST['username'])
    echo "canaillou";
else if($_POST['pic_id'] && $_POST['username'] && $_POST['post'])
{
    $id = $_POST['pic_id'];
    $user = $_POST['username'];
    $comment = $_POST['post'];
    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error connection db";
    }
    try {
        $time = time();
        $comment_req = $db->prepare("INSERT INTO `comments` values(null, ?, ?, ?, ?)");
        $comment_req->bindParam(1, $id, PDO::PARAM_INT);
        $comment_req->bindParam(2, $user, PDO::PARAM_STR);
        $comment_req->bindParam(3, $comment, PDO::PARAM_STR);
        $comment_req->bindParam(4, $time, PDO::PARAM_INT);
        $comment_req->execute();
        echo "ok";
    } catch (PDOException $e) {
        echo "Error";
    }
}
?>