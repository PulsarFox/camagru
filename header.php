<div class="header">
    <div class="titles">
        <a href="index.php" class="link_homepage">
            <h1 class="titre">Chiabrena</h1>
        </a>
        <?php
           if ($page == "index")
                $page = "Accueil";
            else
                $page = ucfirst($page);
            echo '<h2 class="undertitle">'.$page.'</h2>';
        ?>
    </div>
    <div class="menu">
        <a class="menu_title home" href="#">Accueil</a>
        <span class="test"></span>
        <a class="menu_title editor" href="#">Editeur</a>
        <a class="menu_title gallerie" href="#">Gallerie</a>
        <?php
            if ($_SESSION['connected'])
                echo '<a class="menu_title myaccount" href="#">Accname</a>';
            else
                echo '<a class="menu_title login" href="#">Log in</a>
                    <a class="menu_title signin" href="#">Sign in</a>';
        ?>
    </div>
</div>