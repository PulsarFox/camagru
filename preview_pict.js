(function(){
    var all_pict = document.getElementById("all_pictures");
    var own_pict = document.getElementById("own_pictures");
    var all = 1;
    var xhr = new XMLHttpRequest();

    all_pict.addEventListener('click', function(){
        all = 1;
        own_pict.style.backgroundColor = "white";
        all_pict.style.backgroundColor = "green";
    }, false);
    own_pict.addEventListener('click', function(){
        all = 0;
        own_pict.style.backgroundColor = "green";
        all_pict.style.backgroundColor = "white";
    }, false);
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
                console.log("errormate");
        }
    }, false);
    xhr.open("POST", "get_preview.php");
    xhr.setRequestHeader('Content-type', "application/x-www-form-urlencoded");
    xhr.send("all=" + all);

    function set_previews(data){
        var conteneur = document.getElementById("preview_block");
        var i = 0;

        conteneur.innerHTML = "";
        while (data[i] && i < 10)
        {
            conteneur.innerHTML += '<div class="preview_image"><img style="width:100px; height=100px" src="myimages/' + data[i]["src"] + '" alt="">';
            conteneur.innerHTML += '<p class="preview_username">' + data[i]["username"] + '</p></div><br />';
            console.log(data[i]["username"]);

            i++;
        }
    }
}());