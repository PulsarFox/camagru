function like_fct(e, id, name, is_like, nb)
{
    var xhr = new XMLHttpRequest();

    if (!name)
    {
        alert("Les votes sont reserves aux utilisateurs connectes");
        e.preventDefault();
        return;
    }
    else if (confirm("Le vote ne pourra pas être changé par la suite, confirmer ?") == true)
    {
        var like_count = document.getElementById("nb_like_" + id);
        var like = document.getElementById("like_img" + id);
        var dislike = document.getElementById("dislike_img" + id);

        xhr.addEventListener('readystatechange', function() {
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
            {
                if (xhr.responseText === "canaillou")
                    alert("Essaye autre chose, tu ne m'aura point");
                else if (xhr.responseText)
                {
                    like_count.innerHTML = "<span>LIKES : " + xhr.responseText +"</span>"
                    if (xhr.responseText < 0)
                        like_count.style.color = "red";
                    else if (xhr.responseText == 0)
                        like_count.style.color = "black";
                    else if (xhr.responseText > 0)
                        like_count.style.color = "green";
                    if (like && dislike)
                    {
                        like.removeAttribute('onclick');
                        dislike.removeAttribute('onclick');
                    }
                }
                else
                    alert("Probleme serveur veuillez contacter le maitre");
            }
            else if (xhr.status != 200 && xhr.status != 0)
                alert("Gros probleme serveur veuillez contacter le maitre pas trop maitre");
        }, false);
        xhr.open("POST" ,"ajax/like.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("id=" + id + "&is_like=" + is_like + "&user=" + name + "&nb_like=" + nb);
        return;
    }
}

function save_comment(e, id, name, photo_name)
{
    var xhr = new XMLHttpRequest();

    if (!name)
    {
        alert("Les commentaires sont réserves aux utilisateurs connectés");
        e.preventDefault();
        return;
    }
    else
    {
        var post = document.getElementById("comment" + id);
        var button_comment = document.getElementById("submit_" + id);
        var coms = document.getElementById(id);
        if (post && post.value != "")
        {
            xhr.addEventListener('readystatechange', function(){
                if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
                {
                    console.log(xhr.responseText);
                    if (xhr.responseText == "ok")
                    {
                        var d = new Date();
                        var data = coms.innerHTML;
                        coms.innerHTML = '<div class="comment_block"><div class="comment_title">'+ name + ' Post&eacute; le '+d.getDate()+'/'+(d.getMonth() + 1)+'/'+d.getFullYear()+' &agrave; ' +d.getHours()+ 'H' + d.getMinutes() +'</div><pre style="white-space: pre-wrap;"><div class="comment_text">' + post.value +'</pre></div></div>';
                        if (typeof(document.getElementById("no_comment")) == "undefined")
                            coms.innerHTML += data;
                        post.value = null;
                    }
                    else if (xhr.responseText == "canaillou")
                    {
                        alert("Bien essaye petit canaillou");
                    }
                }
                else if (xhr.status != 200 && xhr.status != 0)
                    alert("Grosse erreur attention");
            }, false);
            xhr.open("POST", "ajax/comment.php");
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("pic_id=" + id + "&username=" + name + "&post=" + encodeURIComponent(post.value) + "&user_pic=" + photo_name);
        }
    }
}

function delete_photo(e, id, name)
{
    if (!name)
    {
        alert("Ouloulou les tests");
        e.preventDefault;
        return;
    }
    else if (confirm("Voulez vous vraiment supprimer votre œuvre d'art ?") == true)
    {
        var xhr = new XMLHttpRequest();

        xhr.addEventListener('readystatechange', function (){
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
            {
                if (xhr.responseText == "ok")
                {
                    document.getElementById("block_picture_" + id).remove();
                    console.log("ok");
                }
                else if (xhr.responseText)
                {
                    alert("Arretez stp");
                }
                else
                {
                    console.log("pb connexion");
                }
            }
        }, false);
        xhr.open("POST", "ajax/delete_pic.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("pic_id=" + id + "&user=" + name);
    }
}

function show_comments(id){
    document.getElementById("comment_block" + id).style.display = "block";
    var button = document.getElementById("show_button" + id);
    document.getElementById("fieldset_comment" + id).style.borderWidth = "2px";
    button.innerHTML = "&uarr; Cacher les commentaires &uarr;";
    button.removeAttribute('onclick');
    button.setAttribute('onclick', "close_comments("+ id +")");
}

function close_comments(id){
    document.getElementById("comment_block" + id).style.display = "none";
    document.getElementById("fieldset_comment" + id).style.borderWidth = "0px";
    var button = document.getElementById("show_button" + id);
    button.innerHTML = "&darr; Afficher les commentaires &darr;";
    button.removeAttribute('onclick');
    button.setAttribute('onclick', "show_comments("+ id +")");
}