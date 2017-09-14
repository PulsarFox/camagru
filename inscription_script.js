var user_valid = 0, mail_valid = 0, pw_valid = 0, conf_pw_valid = 0;

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
    if (user_valid == 1 && mail_valid == 1 && pw_valid == 1 && conf_pw_valid == 1)
    {
        var button = document.getElementById("submit_button");
        button.disabled = false;
    }
    else
    {
        var button = document.getElementById("submit_button");
        button.disabled = true;
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
    xhr.open("POST", "test.php", true);
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

function valid()
{
    if (user_valid == 1 && mail_valid == 1 && pw_valid == 1 && conf_pw_valid == 1)
        return true;
    else
    {
        console.log("noreturn");
        return false;
    }
}