<?php
    session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="page.css" />
    <link rel="stylesheet" type="text/css" href="header.css" />
    <title>Camagru</title>
</head>
<body>
    <?php
    include_once("verifpage.php");
    include_once("header.php");
    ?>
    <div class="presentation_main">
        <div class="presentation_image_div">
            <h1 class="presentation_title_text">Chiabrena</h1>
            <img class="presentation_image_blur" src="images/hide_face.jpg" alt="" />
            <img class="presentation_image" src="images/hide_face.jpg" alt="" />
        </div>

    </div>
</body>
</html>