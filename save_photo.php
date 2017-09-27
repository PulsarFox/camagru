<?php
session_start();
include_once('config/database.php');
date_default_timezone_set('Europe/Paris');
if ($_POST['pic'] && $_POST['time'])
{
    $picture = $_POST['pic'];
    $timestamp = $_POST['time'] / 1000;

    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("<div class='error'>Database access error : " . $e->getMessage() . "</div>");
    }
    $datetime = date("Y-m-d H:i:s", $timestamp);
    if ($user = $_SESSION['username'])
    {
        try {
            $newpic = $db->prepare("INSERT INTO images values(null, ?, ?, ?, null)");
            $newpic->bindParam(1, $user, PDO::PARAM_STR);
            $newpic->bindParam(2, $picture, PDO::PARAM_STR);
            $newpic->bindParam(3, $datetime, PDO::PARAM_STR);
            $newpic->execute();
            echo $picture;
        } catch(PDOException $e) {
            echo "Error";
        }
    }
}
?>