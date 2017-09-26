(function(){
    var width = 320;
    var height = 0;
    var streaming = false;
    var video = null;
    var canvas = null;
    var photo = null;
    var startbutton = null;

    function startup() {
        video = document.getElementById('video');
        canvas = document.getElementById('canvas');
        photo = document.getElementById('photo');
        startbutton = document.getElementById('startbutton');

        navigator.mediaDevices.getUserMedia({video: true, audio: false})
        .then(function(stream){
            if
                ("srcObject" in video) {
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
            console.log("Error : " + e);
            alert("Error :" + e);
        });
        video.addEventListener('canplay', function(event){
            if (!streaming)
            {
                height = video.videoHeight / (video.videoWidth/width);
                if (isNaN(height))
                    height = width / (4/3);
                video.setAttribute('width', width);
                video.setAttribute('height', height);
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);
                streaming = true;
            }
        }, false);
        startbutton.addEventListener('click', function(ev){
            takepicture();
            ev.preventDefault();
        }, false);
        clearphoto();
    }
    function clearphoto(){
        var context = canvas.getContext('2d');
        context.fillStyle = "#000";
        context.fillRect(0, 0, canvas.width, canvas.height);
        var data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);
    }

    function takepicture() {/*
        var context = canvas.getContext('2d');
        if (width && height) {
            canvas.width = width;
            canvas.height = height;
            context.drawImage(video, 0, 0, width, height);
            var data = canvas.toDataURL('image/png');
            photo.setAttribute('src', data);
        }
        else
            clearphoto();*/
        var xhr = new XMLHttpRequest;
        var context = canvas.getContext("2d");
        if (width && height)
        {
            canvas.width = width;
            canvas.height = height;
            context.drawImage(video, 0, 0, width, height);
            var dataUrl = canvas.toDataURL('image/png');
            xhr.addEventListener('readystatechange', function() {
                if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0))
                {
                    console.log(xhr.responseText);
                    photo.setAttribute('src', xhr.responseText);
                }
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
    }
    window.addEventListener('load', startup, false);
})();