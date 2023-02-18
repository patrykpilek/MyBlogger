let drag = document.querySelectorAll('#drag');
let saveBtn = document.querySelector('#saveLayoutBtn');
let dragFromID = new Array();
let dropToID = new Array();

drag.forEach(function (el) {
    el.addEventListener("dragstart", function(event) {
        dragSrcEl = this;
        event.dataTransfer.effectAllowed = 'move';
        event.dataTransfer.setData('text/html', this.innerHTML);
    });

    el.addEventListener("dragover", function(event) {
        event.preventDefault();
        event.dataTransfer.dropEffect = 'move';
        return false;
    });

    el.addEventListener("drop", function(event) {
        if(dragSrcEl !== this) {
            saveBtn.classList.remove('disabled');
            saveBtn.disabled = false;

            dragFromID.push(dragSrcEl.dataset.id);
            dropToID.push(this.dataset.id);

            dragSrcEl.innerHTML = this.innerHTML;
            this.innerHTML = event.dataTransfer.getData('text/html');
        }
        return false;
    });
});