<?php
    session_start();
    if (!$_SESSION['connected'])
    {
        header('Location: ./index.php');
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <link rel="icon" type="image/png" href="favicon.png" />
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style/page.css" />
    <link rel="stylesheet" type="text/css" href="style/header.css" />
    <script type="text/javascript" src="scripts/webcam.js"></script>
    <title>Chiabrena</title>
</head>
<body>
    <?php
    include_once("verifpage.php");
    include_once("header.php");
    include_once("config/setup.php");
    ?>
    <hr style="margin:0; width:100%;" />
    <div class="dragzone_images">
    <?php
        try {
            $i = 0;
            $left = 0;
            $query = $pdo->query("SELECT name, src FROM clippers");
            $clipper = $query->fetchAll();
            while ($clipper[$i])
            {
                echo '<img class="clipper '.$clipper[$i]["name"].'" alt="clipper" src="'.$clipper[$i]["src"].'" id="'.$clipper[$i]["name"].'" style="left: '.$left.'px;" />';
                $i++;
                $left = $left + 120;
            }
        } catch(PDOException $e) {
            die("Error");
        }
    ?>
    </div>
    <div class="central_block">
    <div class="cam_block">
        <div class="camera" id="drop_zone">
            <video id="video" class="dropper">Video stream not available.</video>
        </div>
        <button class="button_picture" id="startbutton" disabled="true">Take photo</button>
        <canvas id="canvas" style="display:none">
        </canvas>
        <div class="output">
            <img id="photo" class="img_output" alt="The screen capture will appear in this box.">
        </div>
        <br/><button class="save_button" id="savebutton">Save Photo</button><br />
        <span id="err_save"></span>
    </div>
    <div class="preview_block">
        <div class="title_preview_block">
            <p id="all_pictures" class="all_or_own">Photos r&eacute;centes</p>
        </div>
        <div class="image_preview_block" id="preview_block">
        </div>
    </div>
    </div>
    <?php 
        include_once("footer.php");
    ?>
    <script type="text/javascript" src="scripts/preview_pict.js"></script>
    <script type="text/javascript" src="scripts/drag_drop.js"></script>
</body>
</html>