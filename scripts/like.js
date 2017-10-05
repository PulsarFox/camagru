function like_fct(id, name, is_like, nb)
{
    var xhr = new XMLHttpRequest();

    if (!name)
    {
        alert("Les votes sont reserves aux utilisateurs connectes");
        return;
    }
    else
    {
        var like_count = document.getElementById("nb_like_" + id);
        var like = document.getElementById("like_img" + id);
        var dislike = document.getElementById("dislike_img" + id);

        xhr.addEventListener('readystatechange', function() {
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
            {
                if (xhr.responseText)
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

function save_comment(id, name)
{
    var xhr = new XMLHttpRequest();

    if (!name)
        alert("Les commentaires sont reserves aux utilisateurs connectes");
    else
    {
        var post = document.getElementById("comment" + id);
        if (post && post.value != "")
        {
            xhr.addEventListener('readystatechange', function(){
                if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
                {
                    if (xhr.responseText)
                    {
                        console.log(xhr.responseText);
                    }
                    else
                    {
                        console.log("pasok");
                    }
                }
                else if (xhr.status != 200 && xhr.status != 0)
                    alert("Grosse erreur attention");
            }, false);
            xhr.open("POST", "ajax/comment.php");
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("pic_id=" + id + "&username=" + name + "&post=" + post.value)
        }
    }
}

function delete_photo(id, name)
{
    if (!name)
        alert("T'es arrive ici comment toi jeune haxxor?");
    else
    {
        var xhr = new XMLHttpRequest();

        xhr.addEventListener('readystatechange', function (){
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
            {
                if (xhr.responseText)
                {
                    console.log(xhr.responseText);
                }
                else
                {
                    console.log("pb suppression img");
                }
            }
        }, false);
        xhr.open("POST", "ajax/delete_pic.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("pic_id=" + id);
        document.location.reload(false);
    }
}