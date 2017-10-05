<?php
include_once("config/database.php");
?>
<div id="header">
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
        <?php
            if ($_SESSION['connected'] && $_SESSION['username'])
            {
                //echo '<p class="hello_world"><span class="line">Connect&eacute; en tant que '.htmlspecialchars($_SESSION['username']).'</span></p>';
                echo '<p class="hello_world"><span class="line">'.htmlspecialchars($_SESSION['username']).' - <a href="PHPscripts/disconnect.php">Se d&eacute;connecter</a></span></p>';
            }
            else
                echo '<div class="menu_title_block" style="position:relative; top:6px;">';
        ?>
        
        <a class="menu_title home" href="index.php">Accueil</a>
        <a class="menu_title gallerie" href="galerie.php">Galerie</a>
        <?php
            if ($_SESSION['connected'])
                echo '<a class="menu_title editor" href="editeur.php">Editeur</a>
                <a class="menu_title myaccount" href="">Mon Compte</a>';
            else
                echo '<a class="menu_title login" onclick="document.getElementById(\'modal\').style.display=\'block\';document.getElementById(\'username_field\').focus();" href="#">Log in</a>
                    <a class="menu_title signup" href="inscription.php">Sign up</a></div>';
        ?>
        
    </div>
<?php
if (!$_SESSION['connected'])
    include_once("PHPscripts/login_modal.php");
?>
</div>