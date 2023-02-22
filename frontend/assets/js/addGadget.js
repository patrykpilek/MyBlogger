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

//list gadget
let listBtn = document.querySelector("#listSaveBtn");
let addLink = document.querySelector("#addLink");
let title = document.querySelector("#gadgetTitle");
let siteUrl = document.querySelector("#siteUrl");
let siteName = document.querySelector("#siteName");
let titleEr = document.querySelector("#titleError");
let urlEr = document.querySelector("#urlError");
let nameEr = document.querySelector("#nameError");
let linkArea = document.querySelector("#linkArea");
let deleteLink = document.querySelectorAll("#deleteLink");
let links = document.querySelectorAll("#link");
let urlArr = [];
let nameArr = [];

if(listBtn) {
    listBtn.addEventListener("click", function(event) {
        let blogID = this.dataset.blog;
        let area = this.dataset.area;
        let pos = this.dataset.pos;
        let title = document.querySelector("#gadgetTitle");
        let error = document.querySelector("#error");

        if(title.value !== "" && links !== null) {
            titleEr.innerHTML = "";
            nameEr.innerHTML = "";
            urlEr.innerHTML = "";

            links.forEach(function(el) {
                urlArr.push(el.href);
                nameArr.push(el.innerHTML);
            });

            let formData = new FormData();

            formData.append("blogID", blogID);
            formData.append("area", area);
            formData.append("pos", pos);
            formData.append("title", title.value);
            formData.append("urlArr", JSON.stringify(urlArr));
            formData.append("nameArr", JSON.stringify(nameArr));

            let httpRequest = new XMLHttpRequest();

            if(httpRequest) {
                httpRequest.open('POST', 'http://localhost/backend/ajax/addListGadget.php', true);
                httpRequest.onreadystatechange = function () {
                    if(this.readyState === 4 && this.status === 200) {
                        window.close();
                        window.opener.location.reload(true);
                    }
                }

                httpRequest.send(formData);
            }
        } else {
            titleEr.innerHTML = "Required field must not be blank";
            nameEr.innerHTML = "Required field must not be blank";
            urlEr.innerHTML = "Required field must not be blank";
        }
    });
}

addLink.addEventListener("click", function(event) {
    event.preventDefault();
    if(title.value !== '' && siteUrl.value !== '' && siteName.value !== '') {
        console.log("test");
        let pattern = /^(http|https):\/\//;

        if(pattern.test(siteUrl.value)) {
            url = "http://" + siteUrl.value;
        } else {
            url = siteUrl.value;
        }

        let link = document.createElement('li');
        link.innerHTML = "<span><a href='javascript:;' id='deleteLink'>Delete</a></span><span><a href='"+url+"' target='_blank' id='link'>"+siteName.value+"</a></span>"
        siteUrl.value = '';
        siteName.value = '';
        linkArea.appendChild(link);
        link.children[0].children[0].addEventListener("click", remove, false);
        links = document.querySelectorAll("#link");
    } else {
        titleEr.innerHTML = "Required field must not be blank";
        nameEr.innerHTML = "Required field must not be blank";
        urlEr.innerHTML = "Required field must not be blank";
    }
});

if(deleteLink) {
    deleteLink.forEach(function(el) {
        el.addEventListener("click",  remove, false);
    });
}

function remove() {
    if(this.parentElement.nextElementSibling) {
        this.parentElement.nextElementSibling.remove();
        this.parentElement.remove();
    }

    deleteLink = document.querySelectorAll("#deleteLink");
    links = document.querySelectorAll("#link");
}