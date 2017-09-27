<?php
if ($_POST['video'])
{
    $tmp = array_filter(explode(',', $_POST['video']), 'strlen');
    $video_image = imagecreatefromstring(base64_decode($tmp[1]));
    
    $x = $_POST['video_x'];
    $y = $_POST['video_y'];
    $w = $_POST['video_width'];
    $h = $_POST['video_height'];

    foreach($_POST as $key => $value)
    {
        if (strpos($key, "image") !== FALSE)
        {
            if (strpos($key, "_x") !== FALSE)
                $x_image = $value - $x;
            else if (strpos($key, "_y") !== FALSE)
                $y_image = $value - $y;
            else
            {
                $image = imagecreatefrompng($value);
                $size = getimagesize($value);
                imagecopyresampled($video_image, $image, $x_image, $y_image, 0, 0, 100, 100, $size[0], $size[1]);
            }
        }
    }
    ob_start();
        imagepng($video_image);
        $content = ob_get_contents();
    ob_end_clean();
    echo "data:image/png;base64,".base64_encode($content);
}
?>