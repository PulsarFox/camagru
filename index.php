<?php
    session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style/page.css" />
    <link rel="stylesheet" type="text/css" href="style/header.css" />
    <title>Chiabrena</title>
</head>
<body>
    <?php
    include_once("verifpage.php");
    include_once("header.php");
    include_once("config/setup.php");
    ?>
    <div class="presentation_main">
        <div class="presentation_image_div">
            <h1 class="presentation_title_text">Chiabrena</h1>
            <div id="desc_text" class="description_text">
                <p>Si ta tete ne te conviens pas, viens sur Chiabrena</p>
            </div>
            <img class="presentation_image_blur" src="images/hide_face.jpg" alt="" />
            <img class="presentation_image" src="images/hide_face.jpg" alt="" />
        </div>
    </div>

    <div class="bloc_presentation" id="bloc">
        <h1 class="bloc_presentation_title" id="title">HOW TO DO IT</h1>
        <div class="do_it_first">
        </div>
        <div class="do_it_second">
        </div>
        </div>
    </div>
        <script>
            var desc = document.getElementById('desc_text');
            var title = document.getElementById('title');
            var test = document.getElementById('bloc');

            window.addEventListener('scroll', function(){
                var scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
                desc.style.opacity = (scrollTop / 100) - 1;
            });
            function checkVisible(elm)
            {
                var rect = elm.getBoundingClientRect();
                var viewHeight = Math.max(document.documentElement.clientHeight, window.innerHeight);
                return !(rect.bottom < 0 || rect.top - viewHeight >= 0);
            }
        </script>
    <div class="INSERT INCLUDE ONCE FOOTER">
    </div>
</body>
</html>