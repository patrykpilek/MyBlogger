let drag = document.querySelectorAll('#drag');
let saveBtn = document.querySelector('#saveLayoutBtn');
let dragFrom = new Array();
let dropTo = new Array();

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

            dragFrom.push(dragSrcEl.dataset.id);
            dropTo.push(this.dataset.id);

            dragSrcEl.innerHTML = this.innerHTML;
            this.innerHTML = event.dataTransfer.getData('text/html');
        }
        return false;
    });
});

saveBtn.addEventListener("click", function(event) {
    if(dragFrom.length && dropTo.length > 0) {
        this.disabled = true;
        let formData = new FormData();

        formData.append("blogID", this.dataset.blog);
        formData.append("dragFrom", JSON.stringify(dragFrom));
        formData.append("dropTo", JSON.stringify(dropTo));

        let httpRequest = new XMLHttpRequest();

        if(httpRequest) {
            httpRequest.open('POST', 'http://localhost/backend/ajax/saveLayout.php', true);
            httpRequest.onreadystatechange = function () {
                if(this.readyState === 4 && this.status === 200) {
                    if(this.responseText.length > 0) {
                        alert(this.responseText);
                    } else {
                        alert('Layout saved');
                    }
                    location.reload();
                }
            }

            httpRequest.send(formData);
        }
    }
});