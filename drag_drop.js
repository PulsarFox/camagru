/*(function() {
    var dndHandler = {
        draggedElement:null,

        applyDragEvents: function(element){
            element.draggable = true;
            var dndHandler = this;
            element.addEventListener('dragstart', function(e){
                dndHandler.draggedElement = e.target;
                e.dataTransfer.setData('text/plain', '');
            });
        },

        applyDropEvents: function(dropper){
            dropper.addEventListener('dragover', function(e){
                e.preventDefault();
                this.className = 'dropper drop_hover';
            });
            dropper.addEventListener('dragleave', function(e){
                this.className = 'dropper';
            });
            var dndHandler = this;
            dropper.addEventListener('drop', function(e){
                var target = e.target,
                    draggedElement = dndHandler.draggedElement,
                    clonedElement = draggedElement.cloneNode(true);
                while(target.className.indexOf('dropper') == -1)
                    target = target.parentNode;
                target.className = 'dropper';
                clonedElement = target.appendChild(clonedElement);
                dndHandler.applyDragEvents(clonedElement);
                draggedElement.parentNode.removeChild(draggedElement);
            });
        }
    };
    var elements = document.getElementsByClassName("drag_image");
    var elementsLen = elements.length;
    var droppers = document.getElementsByClassName('dropper');
    var droppersLen = droppers.length;
    for (var i = 0; i < elementsLen; i++){
        dndHandler.applyDragEvents(elements[i]);
    }
    for (var j = 0; j < droppersLen; j++){
        dndHandler.applyDropEvents(droppers[j]);
    }
})();
*/

(function(){
    dragDrop = {
        initialMouseX: undefined,
        initialMouseY: undefined,
        startX: undefined,
        startY: undefined,
        draggedObject:undefined,
        
        initElement:function(element) {
            element = document.getElementById(element);
            element.onmousedown = dragDrop.startDragMouse;
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
            obj.className += ' dragged';
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
            if (realX < 0)
                realX = 0;
            else if (realX > window.innerWidth - 100)
                realX = window.innerWidth - 100;
            if (realY < 0)
                realY = 0;
            else if (realY > window.innerHeight - 100)
                realY = window.innerHeight - 100;
            dragDrop.draggedObject.style.left = realX + 'px';
            dragDrop.draggedObject.style.top = realY + 'px';
        },
        setRulesPosition: function(dx, dy) {
            dragDrop.draggedObject.style.left = dx + 'px';
            dragDrop.draggedObject.style.top = dy + 'px';
        },
        releaseElement:function(e){
            var evt = e || window.event;
            var dx = dragDrop.draggedObject.offsetLeft;
            var dy = dragDrop.draggedObject.offsetTop;
            //alert(dx + " " + dy);
            var dropWin = document.getElementById("drop_zone");
            var offX = dropWin.offsetLeft;
            var offY = dropWin.offsetTop;
            var x = dropWin.offsetLeft + dropWin.offsetWidth;
            var y = dropWin.offsetTop + dropWin.offsetHeight;

            if (dx <= offX - 99)
                dx = offX - 99;
            else if (dx >= x - 1)
                dx = x - 1;
            if (dy <= offY - 99)
                dy = offY - 99;
            else if (dy >= y - 1)
                dy = y - 1;
            dragDrop.setRulesPosition(dx, dy);
            removeEventSimple(document, 'mousemove', dragDrop.dragMouse);
            removeEventSimple(document, 'mouseup', dragDrop.releaseElement);
            dragDrop.draggedObject.className = dragDrop.draggedObject.className.replace(/dragged/, '');
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
    function cloneElement(e){
        var clone = e.cloneNode(true);
        e.parentNode.appendChild(clone);
    }
    dragDrop.initElement('draggable');
    var img = document.getElementById("draggable");
    img.addEventListener('click', cloneElement(img), false);
})();

