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
        <div id="desc_text" class="description_text">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse velit urna, auctor eu congue quis, pulvinar a quam. Morbi congue dui diam, sit amet blandit justo tristique in. Vivamus congue auctor felis, interdum tincidunt purus convallis at. Nulla facilisi. Quisque mollis at odio sed gravida. Aliquam diam odio, laoreet sit amet ornare pretium, fermentum a ante. Aenean sagittis consequat massa non luctus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Quisque tincidunt, lectus vel condimentum lacinia, nunc odio tristique magna, sed congue massa risus nec lorem.

Curabitur convallis vestibulum enim. Mauris ut magna at sapien faucibus ornare eget id urna. Vestibulum viverra pharetra congue. Etiam eget massa orci. Phasellus id lacinia lorem. Vivamus id eros sagittis massa auctor suscipit ut eu ex. Pellentesque aliquam convallis sem sit amet convallis.</p>
        </div>
        <script>
        var test = document.getElementById('desc_text');
        window.addEventListener('scroll', function(){
          var scrollTop = document.body.scrollTop;
          var windowHeight = window.innerHeight;
          var scrollHeight = document.body.scrollHeight;
          var scrollPercent = (scrollTop / (scrollHeight - windowHeight)) * 100;
           test.style.opacity = scrollPercent / 100;
           console.log(scrollPercent / 100);
        });
        </script>
    </div>
</body>
</html>
