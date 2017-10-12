<?php
header("Content-Type: text/xml");
session_start();
date_default_timezone_set('Europe/Paris');
sleep(1);
if (!isset($_POST['nbr_loaded']))
{
	$_SESSION['error'] = "You can't access to this page";
	header("Location: ../index.php");
	exit;
}

include("../config/database.php");
$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try
{
	$images_req = $db->prepare('SELECT id, username, src, `time`, likes FROM images ORDER BY `time` ASC LIMIT '.$_POST['nbr_loaded'].', 5');
	$images_req->execute();
	$i = $images_req->rowCount();
	$images = $images_req->fetchAll(PDO::FETCH_ASSOC);
	$images_req->closeCursor();
}
catch (PDOException $e)
{
	echo "<div class='error'>Database access error : ".$e->getMessage()."</div>";	
	exit;
}
$comments_req = $db->prepare("SELECT username, comment, `timedate` FROM comments WHERE `id_image` = ? ORDER BY `timedate` DESC");
foreach ($images as $pic)
{
	$comments_req->bindParam(1, $pic['id'], PDO::PARAM_INT);
	echo '<div id="block_picture_'.$pic['id'].'" class="'.htmlspecialchars($pic['username']).' block_pic"  >
		<div class="gallery_photo">
		<p>'.date('j/m/Y \a H\h i\m\i\n s\s', $pic['time']/1000).'</p>
        <div class="photo">
		<a href="images/myimages/'.$pic['src'].'" target="_blank"><img class="pic_perso" src="images/myimages/'.$pic['src'].'" /></a>
        <p class="pic_username">'.htmlspecialchars($pic['username']).'</p>
        <div class="del">';
	    if ($_SESSION['username'] === $pic['username'])
		    echo '<img src="images/del.png" alt="Delete" title="Delete your photo" style="width:30px; cursor:pointer; cursor:hand;" onclick="delete_photo(\''.$pic['id'].'\', \''.htmlspecialchars($pic['username']).'\')" />';
	    echo '</div>
        </div>
		<div class="like_and_del_block">
		    <div class="like_dislike">
    		    <div id="like_img'.$pic['id'].'" class="like_img" onclick="like_fct('.$pic['id'].', \''.htmlspecialchars($_SESSION['username']).'\', 1, '.$pic['likes'].')">
                <img class="like_image" src="images/like.png" alt="Like" style="width:50px"/>
		        </div>
		        <div id="nb_like_'.$pic['id'].'" class="nb_like" style="color:';
                if ($pic['likes'] == 0)
                    echo "black";
                else if ($pic['likes'] > 0)
                    echo "green";
                else
                    echo "red";
                echo ';">
		            <span>LIKES : '.$pic['likes'].'<span>
		        </div>
                <div id="dislike_img'.$pic['id'].'" class="dislike_img" onclick="like_fct('.$pic['id'].', \''.htmlspecialchars($_SESSION['username']).'\', -1, '.$pic['likes'].')">
                    <img class="dislike_image" src="images/dislike.png" alt="Dislike" style="width:50px;"/>
                </div>
		    </div>
		</div>
		</div>
		<div class="comment">
		<div id="'.$pic['id'].'">';
	try
	{
		$comments_req->execute();
		$comments = $comments_req->fetchAll(PDO::FETCH_ASSOC);
		$comments_req->closeCursor();
		foreach($comments as $com)
		{
			echo '<div class="comment_block">
                    <div class="comment_title"> '.htmlspecialchars($com['username']).' '.$com['timedate'].'</div>
                    <div class="comment_text">'.htmlspecialchars($com['comment']).'</div>
                </div>';
		}
	}
	catch (PDOException $e)
	{
		echo '<div class="error" Database access error : ' . $e->getMessage().'</div>';	
		echo '<br/>Veuillez recharger la page, si le probleme persiste, c\'est que je suis nul';
		exit;
	}	
	echo  '</div>
		<form method="post">
		<textarea id="comment'.$pic['id'].'" placeholder="Type a comment" maxlength="500" value=""></textarea>
		<input type="button" id="submit_'.$pic['id'].'" name="submit_'.$pic['id'].'" value="comment" onclick="save_comment('.$pic['id'].', \''.htmlspecialchars($_SESSION['username']).'\')">
		</form>
		</div>
		</div>';
}

if ($i < 5)
{
	echo "<div id='all_downloaded'>Toutes les photos sont la</div>";
}

?>
