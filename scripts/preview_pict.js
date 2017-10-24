(function(){
    var all_pict = document.getElementById("all_pictures");
    var own_pict = document.getElementById("own_pictures");
    var all = 1;
    var xhr = new XMLHttpRequest();

    xhr.addEventListener('readystatechange', function(){
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0))
        {
            if (xhr.responseText)
            {
                var data = xhr.responseText;
                var doto = JSON.parse(data);
                set_previews(doto);
            }
            else
            {
                conteneur.innerHTML = "Erreur serveur<br />";
                return ;
            }
        }
    }, false);
    xhr.open("POST", "ajax/get_preview.php");
    xhr.setRequestHeader('Content-type', "application/x-www-form-urlencoded");
    xhr.send("all=" + all);

    function set_previews(data){
        var conteneur = document.getElementById("preview_block");
        var i = 0;

        conteneur.innerHTML = "";
        while (data[i] && i < 10)
        {
            conteneur.innerHTML += '<div class="preview_image"><img style="width:150px;" src="images/myimages/' + data[i]["src"] + '" alt="">';
            conteneur.innerHTML += '</div><br />';
            i++;
        }
    }
}());