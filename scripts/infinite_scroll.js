(function(){
    var count = 0;
    var xhr = null;

    var interval = setInterval(function(){
        var galerie = document.getElementById("galerie_block");        

        if (xhr && xhr.readyState != 0 && xhr.readyState != 4)
            return;
        else if (count == 0)
            download_next_pic(proceed_info);
        else if (galerie.scrollTop >= (galerie.scrollHeight - galerie.clientHeight - 400))
        {
            download_next_pic(proceed_info);
        }
    }, 1000);

    function download_next_pic(callback)
    {
        var loader = document.getElementById("loader");
        xhr = new XMLHttpRequest();
        xhr.addEventListener('readystatechange', function(){
            if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0))
            {
                callback(xhr.responseText);
                count += 5;
            }
            else if (xhr.readyState === 4 && xhr.status != 200 && xhr.status != 0)
            {
                loader.style.display = "none";
                clearInterval(interval);
            }
            else
            {
                loader.style.display = "block";
                //loader.scrollIntoView();
            }
        }, false);
        xhr.open("POST", "ajax/scroll.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("nbr_loaded=" + count);
    }

    function proceed_info(data)
    {
        var galerie = document.getElementById("galerie_block");
        var loader = document.getElementById("loader");
        var datatext;
        //var done = document.getElementById("all_downloaded");

        loader.remove();
        datatext = galerie.innerHTML;
        galerie.innerHTML = datatext + data;
        galerie.appendChild(loader);
        if (typeof(document.getElementsByClassName("error")[0]) != 'undefined')
        {
            //galerie.innerHTML = "Database Error i'm so bad at this kym";
            clearInterval(interval);
        }
        if (typeof(document.getElementById("all_downloaded")) != 'undefined' && document.getElementById("all_downloaded"))
        {
            var done = document.getElementById("all_downloaded");
            document.getElementById("loader").remove();
            done.style.backgroundColor = "red";
            clearInterval(interval);
            return;
        }
        document.getElementById("loader").style.display = "none";
    }

    window.addEventListener('load', real_resize, false);
    window.addEventListener('resize', not_now_charlie, false);

    var resize_timeout;
    function not_now_charlie(){
        if (!resize_timeout) {
            resize_timeout = setTimeout(function (){
                resize_timeout = null;
                real_resize();
            }, 66);
        }
    }

    function real_resize(){
        galerie = document.getElementById("galerie_block");
        galerie.style.height = (window.innerHeight - (document.getElementById("header").offsetHeight + document.getElementById("footer").offsetHeight)) + "px";
    }
}());