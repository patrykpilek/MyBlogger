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

//search gadget
let searchBtn = document.querySelector("#searchSaveBtn")

if(searchBtn) {
    searchBtn.addEventListener("click", function(event) {
        let blogID = this.dataset.blog;
        let area = this.dataset.area;
        let pos = this.dataset.pos;
        let title = document.querySelector("#gadgetTitle");
        let error = document.querySelector("#error");

        if(title.value !== "") {
            error.innerHTML = "";
            let formData = new FormData();

            formData.append("blogID", blogID);
            formData.append("area", area);
            formData.append("pos", pos);
            formData.append("title", title.value);

            let httpRequest = new XMLHttpRequest();

            if(httpRequest) {
                httpRequest.open('POST', 'http://localhost/backend/ajax/addSearchGadget.php', true);
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

//html gadget
let htmlBtn = document.querySelector("#htmlSaveBtn")

if(htmlBtn) {
    htmlBtn.addEventListener("click", function(event) {
        let blogID = this.dataset.blog;
        let area = this.dataset.area;
        let pos = this.dataset.pos;
        let title = document.querySelector("#gadgetTitle");
        let html = document.querySelector("#gadgetContent");
        let error = document.querySelector("#error");
        let error2 = document.querySelector("#contentError");

        if(title.value !== "" && html.value !== "") {
            error.innerHTML = "";
            error2.innerHTML = "";
            let formData = new FormData();

            formData.append("blogID", blogID);
            formData.append("area", area);
            formData.append("pos", pos);
            formData.append("title", title.value);
            formData.append("html", html.value);

            let httpRequest = new XMLHttpRequest();

            if(httpRequest) {
                httpRequest.open('POST', 'http://localhost/backend/ajax/addHtmlGadget.php', true);
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
            error2.innerHTML = "Required field must not be blank";
        }
    });
}

//profile gadget
let profileBtn = document.querySelector("#profileBtn")

if(profileBtn) {
    profileBtn.addEventListener("click", function(event) {
        let blogID = this.dataset.blog;
        let area = this.dataset.area;
        let pos = this.dataset.pos;
        let title = document.querySelector("#gadgetTitle");
        let desc = document.querySelector("#gadgetContent");
        let fbUrl = document.querySelector("#fbUrl");
        let twUrl = document.querySelector("#twitterUrl");
        let igUrl = document.querySelector("#igUrl");
        let ytUrl = document.querySelector("#ytUrl");
        let error = document.querySelector("#titleError");
        let error2 = document.querySelector("#contentError");

        if(title.value !== "" && desc.value !== "") {
            error.innerHTML = "";
            error2.innerHTML = "";
            let formData = new FormData();

            formData.append("blogID", blogID);
            formData.append("area", area);
            formData.append("pos", pos);
            formData.append("title", title.value);
            formData.append("desc", desc.value);
            formData.append("fbUrl", fbUrl.value);
            formData.append("twUrl", twUrl.value);
            formData.append("igUrl", igUrl.value);
            formData.append("ytUrl", ytUrl.value);

            let httpRequest = new XMLHttpRequest();

            if(httpRequest) {
                httpRequest.open('POST', 'http://localhost/backend/ajax/addProfileGadget.php', true);
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
            error2.innerHTML = "Required field must not be blank";
        }
    });
}

//labels gadget
let labelBtn = document.querySelector("#labelBtn")

if(labelBtn) {
    labelBtn.addEventListener("click", function(event) {
        let blogID = this.dataset.blog;
        let area = this.dataset.area;
        let pos = this.dataset.pos;
        let title = document.querySelector("#gadgetTitle");
        let error = document.querySelector("#error");

        if(title.value !== "") {
            error.innerHTML = "";
            let formData = new FormData();

            formData.append("blogID", blogID);
            formData.append("area", area);
            formData.append("pos", pos);
            formData.append("title", title.value);

            let httpRequest = new XMLHttpRequest();

            if(httpRequest) {
                httpRequest.open('POST', 'http://localhost/backend/ajax/addLabelsGadget.php', true);
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