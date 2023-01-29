let publishButton = document.querySelector("#publishBtn");
let publishLink = document.querySelectorAll("#publishComment");
let blog_ID = publishButton.dataset.blog;

publishButton.addEventListener("click", function(event) {
    let checkBox = document.querySelectorAll(".commentCheckBox");
    let postIDs = new Array();
    let commentIDs = new Array();

    checkBox.forEach(function(el) {
        if(el.checked) {
            postIDs.push(el.dataset.post);
            commentIDs.push(el.dataset.comment);
        }
    });

    if(postIDs.length > 0) {
        let formData = new FormData();

        formData.append('postIDs', JSON.stringify(postIDs));
        formData.append("commentIDs", JSON.stringify(commentIDs));
        formData.append("blogID", blog_ID);

        let httpRequest = new XMLHttpRequest();

        if(httpRequest) {
            httpRequest.open('POST', 'http://localhost/backend/ajax/publishComments.php', true);
            httpRequest.onreadystatechange = function () {
                if(this.readyState === 4 && this.status === 200) {
                    if(this.responseText.length !== 0) {
                        alert(this.responseText);
                    }
                    location.reload(true);
                }
            }

            httpRequest.send(formData);
        }
    } else {
        alert("No posts are selected!");
        location.reload(true);
    }
});

publishLink.forEach(function(el) {
    el.addEventListener("click", function (event) {
        event.preventDefault();
        event.stopPropagation();

        let formData = new FormData();

        formData.append('postID', el.dataset.post);
        formData.append("commentID", el.dataset.comment);
        formData.append("blogID", blog_ID);

        let httpRequest = new XMLHttpRequest();

        if(httpRequest) {
            httpRequest.open('POST', 'http://localhost/backend/ajax/publishCommentByLink.php', true);
            httpRequest.onreadystatechange = function () {
                if(this.readyState === 4 && this.status === 200) {
                    if(this.responseText.length !== 0) {
                        alert(this.responseText);
                    }
                    location.reload(true);
                }
            }

            httpRequest.send(formData);
        }
    });
});