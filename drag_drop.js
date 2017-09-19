(function() {
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