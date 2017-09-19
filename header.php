<?php
include_once("config/database.php");
?>
<div class="header">
    <div class="titles">
        <a href="index.php" class="link_homepage">
            <h1 class="titre">Chiabrena</h1>
        </a>
        <?php
            if ($page == "index")
                $under = "Accueil";
            else if ($page == "forgot")
                $under = "Nobrainpage";
            else
                $under = ucfirst($page);
            echo '<h2 class="undertitle">'.$under.'</h2>';
        ?>
    </div>
    <div class="menu">
        <a class="menu_title home" href="index.php">Accueil</a>
        <span class="test"></span>
        <a class="menu_title editor" href="editeur.php">Editeur</a>
        <a class="menu_title gallerie" href="gallerie.php">Gallerie</a>
        <?php
            if ($_SESSION['connected'])
                echo '<a class="menu_title myaccount" href="disconnect.php">'.htmlspecialchars($_SESSION['username']).'</a>';
            else
                echo '<a class="menu_title login" onclick="document.getElementById(\'modal\').style.display=\'block\';document.getElementById(\'username_field\').focus();" href="#">Log in</a>
                    <a class="menu_title signup" href="inscription.php">Sign up</a>';
        ?>
    </div>
<?php
if (!$_SESSION['connected'])
    include_once("login_modal.php");
?>
</div>