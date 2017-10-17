(function(){
    var is_mobile = false;

    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4)))
    is_mobile = true;
    dragDrop = {
        initialMouseX: undefined,
        initialMouseY: undefined,
        startX: undefined,
        startY: undefined,
        draggedObject:undefined,
        
        initElement:function(element) {
            var i = 0;
            elements = document.getElementsByClassName('clone');
            while(elements[i])
            {
                if(is_mobile == true)
                {
                    elements[i].addEventListener('touchstart', dragDrop.startDragMouse, false);
                }
                else
                    elements[i].onmousedown = dragDrop.startDragMouse;
                i++;
            }
        },
        startDragMouse: function(e) {
            dragDrop.startDrag(this);
            var evt = e || window.event;
            if (is_mobile == true)
            {
                dragDrop.initialMouseX = evt.touches[0].clientX;
                dragDrop.initialMouseY = evt.touches[0].clientY;
                addEventSimple(document, 'touchmove', dragDrop.dragMouse);
                addEventSimple(document, 'touchend', dragDrop.releaseElement);
            }
            else
            {
                dragDrop.initialMouseX = evt.clientX;
                dragDrop.initialMouseY = evt.clientY;
                addEventSimple(document, 'mousemove', dragDrop.dragMouse);
                addEventSimple(document, 'mouseup', dragDrop.releaseElement);
            }
            
            return false;
        },
        startDrag: function(obj){
            if (dragDrop.draggedObject)
                dragDrop.releaseElement();
            dragDrop.startX = obj.offsetLeft;
            dragDrop.startY = obj.offsetTop;
            dragDrop.draggedObject = obj;
            obj.className = 'clone dragged';
        },
        dragMouse: function(e) {
            var evt = e || window.event;
            if (is_mobile == true)
            {
                var dX = evt.touches[0].clientX - dragDrop.initialMouseX;
                var dY = evt.touches[0].clientY - dragDrop.initialMouseY;
            }
            else
            {
                var dX = evt.clientX - dragDrop.initialMouseX;
                var dY = evt.clientY - dragDrop.initialMouseY;
            }
            dragDrop.setPosition(dX, dY);
            return false;
        },
        setPosition: function(dx, dy) {
            var realX = dragDrop.startX + dx;
            var realY = dragDrop.startY + dy;
            var drop_zone = document.getElementById("drop_zone");
            var drop_width = drop_zone.offsetLeft + drop_zone.offsetWidth;
            var drop_height = drop_zone.offsetTop + drop_zone.offsetHeight;
            var scrolltop;
            var scrollleft;

            if (!(scrolltop = document.body.scrollTop))
                scrolltop = document.documentElement.scrollTop;
            if (!(scrollleft = document.body.scrollLeft))
                scrollleft = document.documentElement.scrollLeft;

            if (!(realX <= drop_zone.offsetLeft - 99 || realX >= drop_width - 1 || realY <= drop_zone.offsetTop - 99 || realY >= drop_height - 1))
                drop_zone.style.border = "2px solid red";
            else
                drop_zone.style.border = "";
            if (realX < 0 + scrollleft)
                realX = 0 + scrollleft;
            else if (realX > window.innerWidth - 100 + scrollleft)
                realX = window.innerWidth - 100 + scrollleft;
            if (realY < 0 + scrolltop)
                realY = 0 + scrolltop;
            else if (realY > window.innerHeight - 100 + scrolltop)
                realY = window.innerHeight - 100 + scrolltop;
            dragDrop.draggedObject.style.left = realX + 'px';
            dragDrop.draggedObject.style.top = realY + 'px';
        },
        setRulesPosition: function(dx, dy) {
            dragDrop.draggedObject.style.left = dx + 'px';
            dragDrop.draggedObject.style.top = dy + 'px';
        },
        releaseElement:function(){
            deleteOverflow();
            drop_zone.style.border = "";
            if(is_mobile == true)
            {
                removeEventSimple(document, 'touchmove', dragDrop.dragMouse);
                removeEventSimple(document, 'touchend', dragDrop.releaseElement);
            }
            else
            {
                removeEventSimple(document, 'mousemove', dragDrop.dragMouse);
                removeEventSimple(document, 'mouseup', dragDrop.releaseElement);
            }
            dragDrop.draggedObject.className = "clone ondropzone";
            dragDrop.draggedObject = null;
        }
    }
    function addEventSimple(obj, evt, fn){
        if (obj.addEventListener)
            obj.addEventListener(evt, fn, false);
        else if (obj.attachEvent)
            obj.attachEvent('on'+evt, fn);
        else
            alert("Error evenements");
    }
    function removeEventSimple(obj, evt, fn){
        if (obj.removeEventListener)
            obj.removeEventListener(evt, fn, false);
        else if (obj.detachEvent)
            obj.detachEvent('on'+evt, fn);
        else
            alert("Error detach evenements");
    }
    function deleteOverflow()
    {
        var clippers = document.getElementsByClassName("clipper");
        var clone = document.getElementsByClassName("clone");
        var drop_zone = document.getElementById("drop_zone");
        var drop_width = drop_zone.offsetLeft + drop_zone.offsetWidth;
        var drop_height = drop_zone.offsetTop + drop_zone.offsetHeight;

        for (i = 0; i < clone.length; i++){
            if (clone[i].offsetLeft <= drop_zone.offsetLeft - 99 || clone[i].offsetLeft >= drop_width - 1 || clone[i].offsetTop <= drop_zone.offsetTop - 99 || clone[i].offsetTop >= drop_height - 1)
                clone[i].remove();
        }
        for (i = 0; i < clone.length; i++){
            if (clone[i].offsetLeft <= drop_zone.offsetLeft - 99 || clone[i].offsetLeft >= drop_width - 1 || clone[i].offsetTop <= drop_zone.offsetTop - 99 || clone[i].offsetTop >= drop_height - 1)
                clone[i].remove();
        }
        for (i = 0; i < clippers.length; i++)
            cloneElement(clippers[i]);
    }
    function cloneElement(e){
        var clone = e.cloneNode(true);
        clone.className = "clone";
        clone.removeAttribute("id");
        clone.setAttribute("draggable", "true");
        e.parentNode.appendChild(clone);
        dragDrop.initElement('clone');
    }
    window.addEventListener('load', function(){
        var images = document.getElementsByClassName("clipper");
        for (i = 0; i < images.length; i++)
            cloneElement(images[i]);
    }, false);
})();

