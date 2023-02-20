let button = document.querySelectorAll('#addGadget');

button.forEach(function(el) {
    el.addEventListener("click", function(event) {
        event.preventDefault();
        let type = this.dataset.type;
        let area = this.dataset.area;
        let pos = this.dataset.pos;
        let blogID = this.dataset.blog;

        window.location.href = "http://localhost/blogID/" + blogID + "/gadgets/add/" + type + "/" + area + "/" + pos;

    });
});