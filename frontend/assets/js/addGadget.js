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

//topPosts Gadget
let topPostsBtn = document.querySelector("#topPostsBtn")

if(topPostsBtn) {
    topPostsBtn.addEventListener("click", function(event) {
        let blogID = this.dataset.blog;
        let area = this.dataset.area;
        let pos = this.dataset.pos;
        let title = document.querySelector("#gadgetTitle");
        let postLimit = document.querySelector("#postLimit");
        let error = document.querySelector("#error");

        if(title.value !== "" && postLimit.value !== "") {
            error.innerHTML = "";
            let formData = new FormData();

            formData.append("blogID", blogID);
            formData.append("area", area);
            formData.append("pos", pos);
            formData.append("title", title.value);
            formData.append("postLimit", postLimit.value);

            let httpRequest = new XMLHttpRequest();

            if(httpRequest) {
                httpRequest.open('POST', 'http://localhost/backend/ajax/addTopPostsGadget.php', true);
                httpRequest.onreadystatechange = function () {
                    if(this.readyState === 4 && this.status === 200) {
                        window.close();
                        window.opener.location.reload(true);
                    }
                }

                httpRequest.send(formData);
            }
        } else {
            error.innerHTML = "Required field must not be blank";
        }
    });
}