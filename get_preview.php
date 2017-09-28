<?php
include_once('config/database.php');
if ($_POST['all'])
{
    $all = $_POST['all'];

    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e){
        die("Error");
    }
    if ($all == 1)
    {
        try {
            $pictures = $db->query("SELECT `id`, `username`, `src`, `time` FROM `images` ORDER BY `id` DESC LIMIT 10");
            echo json_encode($pictures->fetchAll());
        } catch (PDOException $e){
            echo "Error db";
        }
    }
    else
        echo $all;
}
else
    echo "Nopost";
?>