(function(){
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
                elements[i].onmousedown = dragDrop.startDragMouse;
                i++;
            }
        },
        startDragMouse: function(e) {
            dragDrop.startDrag(this);
            var evt = e || window.event;
            dragDrop.initialMouseX = evt.clientX;
            dragDrop.initialMouseY = evt.clientY;
            addEventSimple(document, 'mousemove', dragDrop.dragMouse);
            addEventSimple(document, 'mouseup', dragDrop.releaseElement);
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
            var dX = evt.clientX - dragDrop.initialMouseX;
            var dY = evt.clientY - dragDrop.initialMouseY;
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
            removeEventSimple(document, 'mousemove', dragDrop.dragMouse);
            removeEventSimple(document, 'mouseup', dragDrop.releaseElement);
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
        console.log("delete ALL");

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

