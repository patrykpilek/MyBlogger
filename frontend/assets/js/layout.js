let button = document.querySelectorAll('#newGadget');
let blogID = document.querySelector('#saveLayoutBtn').dataset.blog;

button.forEach(function(el) {
    el.addEventListener("click", function(event) {
        event.preventDefault();
        let data = this.parentElement.parentElement;
        let area = data.dataset.area;
        let pos = data.dataset.pos;

        if(pos === '0' && area === 'sideBar') {
            pos = document.querySelectorAll('#drag').length+1;
        }

        window.open('http://localhost/blogID/' + blogID + '/gadgets/' + area + '/' + pos, 'about:blank', 'width=780,height=800');
    });
});

// delete gadget
let deleteBtn = document.querySelectorAll("#deleteGadget");
deleteBtn.forEach(function(el) {
    el.addEventListener("click", function(event) {
        event.preventDefault();
        let blogID = this.dataset.blog
        let area = this.dataset.area;
        let pos = this.dataset.pos;
        let type = this.dataset.type;

        if(confirm("Are you sure, you want delete this gadget?")) {
            let formData = new FormData();

            formData.append("blogID", blogID);
            formData.append("area", area);
            formData.append("pos", pos);
            formData.append("type", type);

            let httpRequest = new XMLHttpRequest();

            if(httpRequest) {
                httpRequest.open('POST', 'http://localhost/backend/ajax/removeGadget.php', true);
                httpRequest.onreadystatechange = function () {
                    if(this.readyState === 4 && this.status === 200) {
                        if(this.responseText.length > 0) {
                            alert(this.responseText);
                        }
                        location.reload(true);
                    }
                }

                httpRequest.send(formData);
            }
        } else {
            location.reload(true);
        }
    });
});