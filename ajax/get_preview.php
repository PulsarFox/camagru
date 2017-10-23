<?php
include_once('../config/database.php');
if ($_POST['all'])
{
    $all = $_POST['all'];

    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e){
        echo "Error";
    }
    if ($all == 1)
    {
        try {
            $check_exists = $db->query("SELECT `id`, `src` FROM `images` ORDER BY `id` DESC LIMIT 10");
            $file_exists = $check_exists->fetchAll();
            foreach($file_exists as $file)
            {
                if (!file_exists(dirname(getcwd(), 1)."/images/myimages/".$file['src']))
                    $db->query("DELETE FROM `images` WHERE id =".$file['id'].";");
            }
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