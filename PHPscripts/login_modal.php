<div id="modal" class="modal_style">
    <form class="loginform animate" action="PHPscripts/login.php" name="loginform" method="post">
        <span onclick="document.getElementById('modal').style.display='none'" class="closemodal">Close</span>
        <div class="container">
            <div class="username">
                <label>Username</label>
                <?php
                if($_SESSION['login_error'] == "blank_username" || $_SESSION['login_error'] == "incorrect_acc")
                    echo '<input class="input wrong" type="text" name="user_login" id="username_field" placeholder="Entrez votre nom d\'utilisateur" name="username">';
                else
                    echo '<input class="input ok" type="text" name="user_login" id="username_field" placeholder="Entrez votre nom d\'utilisateur" name="username">';
                ?>
            </div>
            <div class="passwd">
                <label>Password</label>
                <?php
                if ($_SESSION['login_error'] == "blank_password" || $_SESSION['login_error'] == "incorrect_pw")
                    echo '<input class="input wrong" type="password" name="password_login" id="password_field" placeholder="Entrez votre mot de passe" name="password">';
                else
                    echo '<input class="input ok" type="password" name="password_login" id="password_field" placeholder="Entrez votre mot de passe" name="password">';
                ?>
            </div>
            <input id="button" name="login" value="Login" type="submit">
            <input type="checkbox" checked="checked"> Remember me
        </div>
        <div class="container">
            <button type="button" onclick="document.getElementById('modal').style.display='none'" class="cancel">Cancel</button>
            <a class="forgot" href="forgot.php">Forgot password ?</a>
        </div>
    </form>
</div>
<script>
    var modal = document.getElementById("modal");

    window.onclick = function(event)
    {
        if (event.target == modal)
        modal.style.display = "none";
    }
</script>
<?php
if($_SESSION['login_error'])
{
    echo "<script>
        var test = document.getElementById('modal');
        modal.style.display = 'inline-block';
        </script>";
}
$_SESSION['login_error'] = '';
?>