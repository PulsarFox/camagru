/*var user_valid = 0, mail_valid = 0, pw_valid = 0, conf_pw_valid = 0;

function check_valid(type, error)
{
    if (error == 0) {
        if (type == "user")
            user_valid = 1;
        else if (type == "mail")
            mail_valid = 1;
        else if (type == "pw")
            pw_valid = 1;
        else if (type == "confirm_pw")
            conf_pw_valid = 1;
    }
    else if (error == 1){
        if (type == "user")
            user_valid = 0;
        else if (type == "mail")
            mail_valid = 0;
        else if (type == "pw")
            pw_valid = 0;
        else if (type == "confirm_pw")
            conf_pw_valid = 0;
    }
}

function display_ok(field, errfield)
{
    field.style.borderColor = "green";
    field.style.backgroundColor = "#FFFFFF";
    check_valid(field.id, 0);
    errfield.innerHTML = "<img class=\"okimg\" src=\"images/ok.png\" alt=\"\" title=\"ok\"/>";
}

function display_error(field, errfield, errtype)
{
    var wrong_img = "<img class=\"wrongimg\" src=\"images/wrong.png\" alt=\"\" title=\"wrong\"/>";
    
    check_valid(field.id, 1);
    field.style.borderColor = "red";
    field.style.backgroundColor = "#FFCDCD";
    if (errtype == 1)
        errfield.innerHTML = "Faut rentrer quelque chose la hein " + wrong_img;
    else if (errtype == 2)
        errfield.innerHTML = "Ce nom d\'utilisateur existe d&eacute;j&agrave; " + wrong_img;
    else if (errtype == 3)
        errfield.innerHTML = "Cette adresse email est d&eacute;j&agrave; utilis&eacute;e " + wrong_img;
    else if (errtype == 4)
        errfield.innerHTML = "Le mot de passe doit &ecirc;tre compos&eacute; d\'au moins 6 caract&egrave;res alphanum&eacute;riques, ou underscore " + wrong_img;
    else if (errtype == 5)
        errfield.innerHTML = "Le mot de passe doit &ecirc;tre diff&eacute;rent du nom d\'utilisateur " + wrong_img;
    else if (errtype == 6)
        errfield.innerHTML = "Les mots de passe ne correspondent pas" + wrong_img;
}

function existsblur(input)
{
    var field = document.getElementById(input);
    var errorfield = document.getElementById(input+"_error");
    var xhr = new XMLHttpRequest();
    var val = field.value;

    xhr.addEventListener('readystatechange', function() {
        if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0))
        {
            if (xhr.responseText == "Ok")
                display_ok(field, errorfield)
            else if (xhr.responseText == "Exists" && input == "user") 
                display_error(field, errorfield, 2);
            else if (xhr.responseText == "Exists" && input == "mail")
                display_error(field, errorfield, 3)
            else
                display_error(field, errorfield, 1)
        }
    });
    xhr.open("POST", "ajax/test.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    if (input == "user")
        xhr.send("username="+val);
    else if (input == "mail")
        xhr.send("mail="+val);
}

function test_pw(input)
{
    var pwfield = document.getElementById("pw");
    var confpwfield = document.getElementById("confirm_pw");
    var err_confpwfield = document.getElementById("confirm_pw_error")
    var err_pwfield = document.getElementById("pw_error");
    var user = document.getElementById("user").value;
    var pw = pwfield.value;
    if (input == "pw")
    {
        var re = /^\w+$/;
        if (pw.length == 0)
            display_error(pwfield, err_pwfield, 1);
        else if (pw.length < 6 || !re.test(pw))
            display_error(pwfield, err_pwfield, 4);
        else if (pw == user)
            display_error(pwfield, err_pwfield, 5);
        else if (confpwfield.value != 0 && pw != confpwfield.value)
            display_error(confpwfield, err_confpwfield, 6);
        else
            display_ok(pwfield, err_pwfield);
    }
    else if (input == "confirm_pw"){
        if (confpwfield.value != 0 && pw == confpwfield.value)
            display_ok(confpwfield, err_confpwfield);
        else
            display_error(confpwfield, err_confpwfield, 6);
    }
}

*/
var user_ok = 0, mail_ok = 0, pw_ok = 0, conf_ok = 0;
function set_events()
{
    var simili = 0;
    var user_field = document.getElementById("user"),
    mail_field = document.getElementById("mail"),
    pw_field = document.getElementById("pw"),
    conf_field = document.getElementById("confirm_pw"),
    submit_button = document.getElementById("submit_button");
    var user_error = document.getElementById("user_error"),
    mail_error = document.getElementById("mail_error"),
    pw_error = document.getElementById("pw_error"),
    conf_error = document.getElementById("confirm_pw_error");
    

    user_field.addEventListener('keyup', function(event){
        var xhr = new XMLHttpRequest();
        
        if (pw_field.value != "" && user_field.value != "" && user_field.value == pw_field.value)
        {
            user_ok = 0;
            user_field.style.borderColor = "red";
            simili = 1;
            user_error.innerHTML = "Le nom d'utilisateur ne doit pas etre similaire au mot de passe";
        }
        else if (user_field.value != "")
        {
            xhr.addEventListener('readystatechange', function(){
                if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
                {
                    if (xhr.responseText == "Exists")
                    {
                        user_field.style.borderColor = "red";
                        user_error.innerHTML = "L'utilisateur existe deja";
                        user_ok = 0;
                    }
                    else if (xhr.responseText == "Ok")
                    {
                        user_ok = 1;
                        user_field.style.borderColor = "green";
                        user_error.innerHTML = "<img class=\"okimg\" src=\"images/ok.png\" alt=\"\" title=\"ok\"/>";
                        if (simili == 1 && pw_ok == 1)
                        {
                            pw_field.style.borderColor = "green";
                            pw_error.innerHTML = "<img class=\"okimg\" src=\"images/ok.png\" alt=\"\" title=\"ok\"/>";
                            pw_ok = 1;
                            simili = 0;
                        }
                    }
                    else
                    {
                        user_ok = 0;
                        user_error.innerHTML = xhr.responseText;
                    }
                }
                else if (xhr.status != 200 && xhr.status != 0)
                {
                    user_ok = 0;
                    user_error.innerHTML = "user request database error";
                }
            }, false);
            xhr.open("POST", "ajax/test.php");
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("username=" + user_field.value);
        }
        else if (user_field.value == "")
        {
            user_ok = 0;
            user_error.innerHTML = "T'as oubli&eacute; un truc tabernac";
            user_field.style.borderColor = "";
        }

    }, false);

    mail_field.addEventListener('keyup', function(){
        var xhr = new XMLHttpRequest();
        if (mail_field.value != "")
        {
            xhr.addEventListener('readystatechange', function(){
                if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
                {
                    if (xhr.responseText == "Exists")
                    {
                        mail_field.style.borderColor = "red";
                        mail_error.innerHTML = "Le mail existe deja";
                        mail_ok = 0;
                    }
                    else if (xhr.responseText == "Ok")
                    {
                        mail_field.style.boderColor = "green";
                        mail_error.innerHTML = "<img class=\"okimg\" src=\"images/ok.png\" alt=\"\" title=\"ok\"/>";
                        mail_ok = 1;
                    }
                    else 
                    {
                        mail_ok = 0;
                        mail_error.innerHTML = xhr.responseText;
                    }
                }
                else if (xhr.status != 200 && xhr.status != 0)
                {
                    mail_ok = 0;
                    mail_error.innerHTML = "mail request database error";
                }
            }, false);
            xhr.open("POST", "ajax/test.php");
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("mail=" + mail_field.value);
        }
        else
        {
            mail_ok = 0;
            mail_error.innerHTML = "T'as oubli&eacute; un truc tabernac";
            mail_field.style.borderColor = "";
        }
    }, false);

    pw_field.addEventListener('keyup', function(){
        var re = /^\w+$/;
        if (pw_field.value == "")
        {
            pw_field.style.borderColor = "";
            pw_ok = 0;
            pw_error.innerHTML = "Mot de passe needed tabernac";
        }
        else if (pw_field.value != "" && conf_field.value != "" && pw_field.value != conf_field.value)
        {
            pw_field.style.borderColor = "red";
            pw_ok = 0;
            conf_field.style.borderColor = "red";
            conf_ok = 0;
            pw_error.innerHTML = "Les mots de passe ne correspondent pas";
        }
        else if (pw_field.value != "" && user_field.value != "" && pw_field.value == user_field.value)
        {
            pw_field.style.borderColor = "red";
            pw_ok = 0;
            pw_error.innerHTML = "Le mot de passe doit etre different du nom d'utilisateur";
            pw_simili = 1;
        }
        else if (!re.test(pw_field.value))
        {
            pw_field.style.borderColor = "red";
            pw_ok = 0;
            pw_error.innerHTML = "Caract&egrave;s ill&eacute;gaux : non alphanumeriques / underscore";
        }
        else if (pw_field.value.length < 6)
        {
            pw_field.style.borderColor = "red";
            pw_ok = 0;
            pw_error.innerHTML = "Le mot de passe doit comporter plus de 6 caract&egrave;res";
        }
        else
        {
            if (simili == 1 && user_ok == 1)
            {
                user_field.style.borderColor = "green";
                user_error.innerHTML = "<img class=\"okimg\" src=\"images/ok.png\" alt=\"\" title=\"ok\"/>";
                user_ok = 1;
                simili = 0;
            }
            pw_field.style.borderColor = "green";
            pw_error.innerHTML = "<img class=\"okimg\" src=\"images/ok.png\" alt=\"\" title=\"ok\"/>";
            pw_ok = 1;
        }
    }, false);

    conf_field.addEventListener('keyup', function(){
        if (conf_field.value == "")
        {
            conf_error.innerHTML = "Rho l'autre eh il manque un truc";
            conf_field.style.borderColor = "";
            conf_ok = 0;
        }
        else if (conf_field.value != "" && pw_field.value != "" && conf_field.value == pw_field.value)
        {
            conf_error.innerHTML = "<img class=\"okimg\" src=\"images/ok.png\" alt=\"\" title=\"ok\"/>";
            conf_field.style.borderColor = "green";
            if (pw_ok == 1)
            {
                pw_field.style.borderColor = "green";
                pw_error.innerHTML = "<img class=\"okimg\" src=\"images/ok.png\" alt=\"\" title=\"ok\"/>";
            }
            conf_ok = 1;
        }
        else
        {
            conf_error.innerHTML = "Ca correspond pas tabernac";
            conf_field.style.borderColor = "red";
            conf_ok = 0;
        }
    }, false);
    
}

function valid()
{
    if (user_ok == 1 && mail_ok == 1 && pw_ok == 1 && conf_ok == 1)
        return true;
    else
    {
        console.log("noreturn");
        return false;
    }
}

window.addEventListener('load', set_events, false);