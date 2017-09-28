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
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="page.css" />
    <link rel="stylesheet" type="text/css" href="header.css" />
    <script type="text/javascript" src="webcam.js"></script>
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
        <img class="clipper smiley" alt="" src="images/smiley.png" id="smiley" />
        <img class="clipper beer" alt="" src="images/beer.png" id="smiley" style="left:150px;" />
    </div>
    <div class="central_block">
    <div class="cam_block">
        <div class="camera" id="drop_zone">
            <video id="video" class="dropper">Video stream not available.</video>
        </div>
        <button class="button_picture" id="startbutton">Take photo</button>
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
            <p id="all_pictures" class="all_or_own">Toutes les photos</p>
            <p id="own_pictures" class="all_or_own">Mes photos</p>
        </div>
        <div class="image_preview_block" id="preview_block">
        </div>
    </div>
    </div>
    <script type="text/javascript" src="preview_pict.js"></script>
    <script type="text/javascript" src="drag_drop.js"></script>
</body>
</html>