<div class="header">
    <div class="titles">
        <a href="index.php" class="link_homepage">
            <h1 class="titre">Chiabrena</h1>
        <?php
           if ($page == "index")
                $page = "Accueil";
            else
                $page = ucfirst($page);
            echo '<h2 class="undertitle">'.$page.'</h2>';
        ?>
        </a>
    </div>
</div>