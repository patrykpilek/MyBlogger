let labels = document.querySelectorAll(".label");
let publish = document.querySelector("#publish");

labels.forEach(function(el) {
    el.addEventListener("click", function(event) {
        let labelArea = document.querySelector("#labelArea");

        if(labelArea.value.trim() !== '') {
            if(labelArea.value.indexOf(el.innerHTML) === -1) {
                let comma = labelArea.value.trim().slice();

                if(comma === ',') {
                    label = labelArea.value + el.innerHTML;
                    labelArea.value = label;
                } else {
                    //add label with comma
                    label = labelArea.value + ', ' + el.innerHTML;
                    labelArea.value = label;
                }
            }
        } else {
            label = labelArea.value + el.innerHTML;
            labelArea.value = label;
        }
    });
});

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
    let title = document.querySelector('#title').value.trim();
    let description = document.querySelector('#description').value.trim();
    let labels = document.querySelector('#labelArea').value.trim();
    let comments = document.querySelector('.comments:checked').value;
    let slug = document.querySelector('#customSlug').value.trim();

    if(title !== '') {
        if(slug === '') {
            slug = title;
        }

        let formData = new FormData();

        formData.append("blogID", blogID);
        formData.append("title", title);
        formData.append("description", description);
        formData.append("labels", labels);
        formData.append("comments", comments);
        formData.append("slug", slug);

        let httpRequest = new XMLHttpRequest();

        if(httpRequest) {
            httpRequest.open('POST', 'http://localhost/backend/ajax/addPost.php', true);
            httpRequest.onreadystatechange = function () {
                if(this.readyState === 4 && this.status === 200) {
                    window.location.href = "http://localhost/admin/blogID/" + blogID + "/dashboard/";
                }
            }

            httpRequest.send(formData);
        }
    }

});