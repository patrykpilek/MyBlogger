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