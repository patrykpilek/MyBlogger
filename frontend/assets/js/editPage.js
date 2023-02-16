let publish = document.querySelector("#publish");
let saveBtn = document.querySelector("#saveBtn");
let draftBtn = document.querySelector("#draftBtn");
let title = document.querySelector('#title');
let linkOp = document.querySelectorAll('.postLinkOp');
let slug = document.querySelector('#slugDiv');
let urlDiv = document.querySelector('#custom-url-area');
let customUrl = document.querySelector('#customSlug');
let customUrlEr = document.querySelector('#urlError');
urlDiv.style.display = "none";


title.addEventListener("keydown", function(event) {
    if(document.querySelectorAll(".postLinkOp").value !== '') {
        if(linkOp[0].value === "automatic") {
            checkTyping();
        }
    }
});

customUrl.addEventListener("keyup", function (event) {
    regex = /^([a-zA-Z0-9-]+)$/gm;
    if(this.value !== '') {
        if(this.value.match(regex)) {
            customUrlEr.innerHTML = "";
            slug.innerHTML = this.value+".html";
        } else {
            slug.innerHTML = "";
            customUrlEr.innerHTML = "Invalid characters!";
        }
    } else {
        slug.innerHTML = "";
    }
});

linkOp.forEach(function(el) {
    el.addEventListener("change", function(event) {
        if(el.value === "custom") {
            slug.innerHTML = '';
            urlDiv.style.display = "block";
            customUrl.value = '';
        } else {
            slug.innerHTML = '';
            urlDiv.style.display = "none";
            if(title.value !== '') {
                displaySlug();
            }
        }
    });
});

let typingTimer = null;
let typingInterval = 5000;

function checkTyping() {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(displaySlug, 1000);
}

function displaySlug() {
    let formData = new FormData();

    formData.append("blogID", publish.dataset.blog);
    formData.append("title", title.value);

    let httpRequest = new XMLHttpRequest();

    if(httpRequest) {
        httpRequest.open('POST', 'http://localhost/backend/ajax/getSlug.php', true);
        httpRequest.onreadystatechange = function () {
            if(this.readyState === 4 && this.status === 200) {
                if(this.responseText.length !== 0) {
                    slug.innerHTML = this.responseText;
                }
            }
        }

        httpRequest.send(formData);
    }
}

publish.addEventListener("click", function(event) {
    let blogID = this.dataset.blog;
    let postID = this.dataset.post;
    let title = document.querySelector('#title').value.trim();
    let description = document.querySelector('#description').value.trim();
    let slug = document.querySelector('#customSlug').value.trim();
    let content = document.querySelector('#editor').firstChild.innerHTML;

    if(title !== '') {
        if(slug === '') {
            slug = title;
        }

        let formData = new FormData();

        formData.append("blogID", blogID);
        formData.append("postID", postID);
        formData.append("title", title);
        formData.append("description", description);
        formData.append("content", content);
        formData.append("slug", slug);

        let httpRequest = new XMLHttpRequest();

        if(httpRequest) {
            httpRequest.open('POST', 'http://localhost/backend/ajax/updatePage.php', true);
            httpRequest.onreadystatechange = function () {
                if(this.readyState === 4 && this.status === 200) {
                    window.location.href = "http://localhost/admin/blogID/" + blogID + "/dashboard/pages";
                }
            }

            httpRequest.send(formData);
        }
    } else {
        alert('Please add page title!')
    }

});

if(saveBtn !== null) {
    saveBtn.addEventListener("click", function(event) {
        let blogID = publish.dataset.blog;
        let postID = publish.dataset.post;
        let title = document.querySelector('#title').value.trim();
        let description = document.querySelector('#description').value.trim();
        let slug = document.querySelector('#customSlug').value.trim();
        let content = document.querySelector('#editor').firstChild.innerHTML;

        if(title !== '') {
            if(slug === '') {
                slug = title;
            }

            let formData = new FormData();

            formData.append("blogID", blogID);
            formData.append("postID", postID);
            formData.append("title", title);
            formData.append("description", description);
            formData.append("content", content);
            formData.append("slug", slug);

            let httpRequest = new XMLHttpRequest();

            if(httpRequest) {
                httpRequest.open('POST', 'http://localhost/backend/ajax/saveNewPage.php', true);
                httpRequest.onreadystatechange = function () {
                    if(this.readyState === 4 && this.status === 200) {
                        window.location.href = "http://localhost/admin/blogID/" + blogID + "/page/" + this.responseText + "/edit/";
                    }
                }

                httpRequest.send(formData);
            }
        } else {
            alert('Please add page title!')
        }

    });
}

if(draftBtn !== null) {
    draftBtn.addEventListener("click", function(event) {
        let blogID = publish.dataset.blog;
        let postID = publish.dataset.post;

        let formData = new FormData();

        formData.append("blogID", blogID);
        formData.append("postID", postID);

        let httpRequest = new XMLHttpRequest();

        if(httpRequest) {
            httpRequest.open('POST', 'http://localhost/backend/ajax/addToDraft.php', true);
            httpRequest.onreadystatechange = function () {
                if(this.readyState === 4 && this.status === 200) {
                    window.location.reload(true);
                }
            }

            httpRequest.send(formData);
        }
    });
}