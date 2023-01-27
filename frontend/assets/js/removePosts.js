let deleteBtn = document.querySelector("#deleteBtn");
let deleteLink = document.querySelectorAll("#deletePost");
let checkAll = document.querySelector("#checkAll");

deleteLink.forEach(function(el) {
    el.addEventListener("click", function(e) {
        e.preventDefault();

        if(confirm("Are you sure, you want to delete this?")) {
            let formData = new FormData();

            formData.append('postID', el.dataset.post);
            formData.append("blogID", el.dataset.blog);

            let httpRequest = new XMLHttpRequest();

            if(httpRequest) {
                httpRequest.open('POST', 'http://localhost/backend/ajax/removePostByLink.php', true);
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
        }
    });
});

deleteBtn.addEventListener("click", function(e) {
    let checkBox = document.querySelectorAll(".postCheckBox");
    let postIDs = new Array();
    let blogIDs = new Array();

    checkBox.forEach(function (el) {
        if(el.checked) {
            postIDs.push(el.value);
            blogIDs.push(el.dataset.blog);
        }
    });

    if(postIDs.length > 0) {
        if(confirm("Are you sure, you want to delete this?")) {
            let formData = new FormData();

            formData.append('postIDs', JSON.stringify(postIDs));
            formData.append("blogIDs", JSON.stringify(blogIDs));

            let httpRequest = new XMLHttpRequest();

            if(httpRequest) {
                httpRequest.open('POST', 'http://localhost/backend/ajax/removePosts.php', true);
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
        }
    } else {
        alert("No Posts are selected!");
        location.reload(true);
    }
});

checkAll.addEventListener("change", function(e) {
    let checkBox = document.querySelectorAll('.postCheckBox');

    checkBox.forEach(function(el) {
        el.checked = true;
    });

    if(this.checked === false) {
        checkBox.forEach(function(el) {
            el.checked = false;
        });
    }
})