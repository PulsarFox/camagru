<?php
if ($page == "editeur")
    echo '<div id="footer" style="position:initial; margin-top:30px;">';
else
    echo '<div id="footer">';
?>
    <div class="footer_picture" onclick="scrollLent()">
        <img alt="scroll_top_left"  src="images/fleche.png" style="width:48px;"/>
        <p>Retour en haut de page</p>
        <img alt="scroll_top_right"  src="images/fleche.png" style="width:48px;"/>
    </div>
    <div class="footer_copyright">
        <p>Copyright &copy; savincen</p>
    </div>
    <script>
        function scrollLent()
        {
            var galerie = document.getElementById("galerie_block");
            if (galerie != null)
                var scrollTop = galerie.scrollTop;
            else
                var scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
            if(scrollTop > 0)
            {
                if (galerie)
                    galerie.scrollBy(0, -50);
                else
                    scrollBy(0, -50);
                setTimeout(scrollLent, 1);
            }
            return true;
        }
    </script>
</div>