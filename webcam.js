(function(){
    var save = 0;
    var width = 320;
    var height = 0;
    var streaming = false;
    var video = null;
    var canvas = null;
    var photo = null;
    var startbutton = null;
    var mil = null;
    var cam = null;
    var is_video = true;

    function startup() {
        video = document.getElementById('video');
        canvas = document.getElementById('canvas');
        photo = document.getElementById('photo');
        startbutton = document.getElementById('startbutton');
        savebutton = document.getElementById('savebutton');
        cam = document.getElementById("drop_zone");

        if(navigator.mediaDevices.getUserMedia ==- undefined) {
            navigator.mediaDevices = {};
        }
        if (navigator.mediaDevices.getUserMedia === undefined){
            navigator.mediaDevices.getUserMedia = function(constraints){
                var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
                if (!getUserMedia) {
                    return Promise.reject("getUserMedia not implemented");
                }
                return new Promise(function(resolve, reject){
                    getUserMedia.call(navigator, constraints, resolve, reject);
                });
            }
        }
        navigator.mediaDevices.getUserMedia({video: true, audio: false})
        .then(function(stream){
            if ("srcObject" in video) {
                video.srcObject = stream;
            }
            else {
                var win = window.URL || window.webkitURL;
                video.src = win.createObjectURL(stream);
            }
            video.play();
        })
        .catch (function(e)
        {
            is_video = false;
            if (e.name == "NotAllowedError" || e.name == "NotFoundError")
                get_image_from_pc();
            else
            {
                cam.style.backgroundImage = "url(images/trotro.jpg)";
                cam.style.backgroundSize = "320px 240px";
            }
        });
        video.addEventListener('canplay', function(event){
            if (!streaming)
            {
                height = video.videoHeight / (video.videoWidth/width);
                if (isNaN(height))
                    height = width / (4/3);
                if (height == width)
                {
                    cam.innerHTML = "";
                    cam.style.backgroundImage = "url(images/trotro.jpg)";
                    cam.style.backgroundSize = "320px 240px";
                    streaming = false;
                }
                else
                {
                    video.setAttribute('width', width);
                    video.setAttribute('height', height);
                    canvas.setAttribute('width', width);
                    canvas.setAttribute('height', height);
                    streaming = true;
                }
            }
        }, false);
        startbutton.addEventListener('click', function(ev){
            takepicture();
            ev.preventDefault();
        }, false);
        savebutton.addEventListener('click', function(ev){
            savepicture();
            ev.preventDefault();
        }, false);
        clearphoto();
    }

    function get_image_from_pc()
    {
        cam.setAttribute('width', 320);
        cam.setAttribute('height', 240);
        cam.innerHTML = "<input type=\"file\" id=\"my_input_file\" autocomplete=\"off\" name=\"my_image\" accept=\"image/*\" /> <br /><button id=\"send_button\">Envoyer</button>";
        var input_field = document.getElementById("my_input_file");
        var send_button = document.getElementById("send_button");
        send_button.addEventListener('click', function(){
            var filz = input_field.files;
            if (filz.length === 0)
                cam.innerHTML += "<br/>No file selected";
            else
            {
                if (filz[0].size > 2097152)
                    cam.innerHTML += "<br/>Fichier trop volumineux";
                else {
                    var string = window.URL.createObjectURL(filz[0]);
                    cam.innerHTML = "<img style=\"width:320px; height:240px;\" id=\"my_image\"src=\""+string+"\" alt=\"\" />";
                }
            } 
        }, false);
    }

    function clearphoto(){
        var context = canvas.getContext('2d');
        context.fillStyle = "#000";
        context.fillRect(0, 0, canvas.width, canvas.height);
        var data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);
    }

    function takepicture() {
        var xhr = new XMLHttpRequest;
        var date = new Date();
        var context = canvas.getContext("2d");
        console.log(is_video);
        if ((width && height) || is_video == false)
        {
            console.log("yesnanb");
            canvas.width = width;
            canvas.height = height;
            if (is_video == true)
                context.drawImage(video, 0, 0, width, height);
            else
            {
                canvas.width = 320;
                canvas.height = 240;
                imz = document.getElementById("my_image");
                context.drawImage(imz, 0, 0, 320, 240);
                video = imz;
            }
            var dataUrl = canvas.toDataURL('image/png');
            xhr.addEventListener('readystatechange', function() {
                if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0))
                {
                    photo.setAttribute('src', xhr.responseText);
                    save = 1;
                    mil = date.getTime();
                }
                else
                    clearphoto(); //mettre erreur photo
            });
            var clippers = document.getElementsByClassName('ondropzone');
            var dataphrase = "video=" + encodeURIComponent(dataUrl) + "&video_x=" + video.offsetLeft + "&video_y=" + video.offsetTop + "&video_width=" + video.offsetWidth + "&video_height=" + video.offsetHeight; 
            for (i = 0; i < clippers.length; i++)
            {
                dataphrase += "&image" + i + "_x=" + clippers[i].offsetLeft;
                dataphrase += "&image" + i + "_y=" + clippers[i].offsetTop;
                dataphrase += "&image" + i + "=" + clippers[i].src;

            }
            xhr.open("POST", "webcam.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(dataphrase);
        }
        else
            clearphoto();
        document.getElementById("err_save").innerHTML = "";
    }
    function savepicture()
    {
        var picture = null;
        var xhr = new XMLHttpRequest();
        var feedback_field = document.getElementById("err_save");

        if (save == 1)
        {
            xhr.addEventListener('readystatechange', function() {
                if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0))
                {
                    if (xhr.responseText)
                    {
                        feedback_field.innerHTML = "Image sauvegard&eacute;e !";
                        //feedback_field.innerHTML = '<img src="' + xhr.responseText + '" alt ="" />';
                        save = 2;
                    }
                    else
                    {
                        feedback_field.innerHTML = "Erreur survenue lors de la sauvegarde";
                        //save = 1;
                    }
                }
            });
            picture = photo.src;
            xhr.open("POST", "save_photo.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("pic=" + encodeURIComponent(picture) + "&time=" + mil);
        }
        else if (save == 2)
        {
            feedback_field.innerHTML = "Photo dej&agrave; sauvegard&eacute;e.";
        }
        else if (save == 0)
        {
            feedback_field.innerHTML = "Photo no valide &agrave; la sauvegarde.";
        }
    }
    window.addEventListener('load', startup, false);
})();
