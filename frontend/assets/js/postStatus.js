let publishBtn = document.querySelector("#publishBtn");

publishBtn.addEventListener("click", function(event) {
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
        if(confirm("Are you sure, you want to publish this?")) {
            let formData = new FormData();

            formData.append('postIDs', JSON.stringify(postIDs));
            formData.append("blogIDs", JSON.stringify(blogIDs));

            let httpRequest = new XMLHttpRequest();

            if(httpRequest) {
                httpRequest.open('POST', 'http://localhost/backend/ajax/publishPosts.php', true);
                httpRequest.onreadystatechange = function () {
                    if(this.readyState === 4 && this.status === 200) {
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

})