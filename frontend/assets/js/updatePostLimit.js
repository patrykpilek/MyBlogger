let postSaveBtn = document.querySelector("#postSaveBtn");

postSaveBtn.addEventListener("click", function(event) {
    let blogID = this.dataset.blog;
    let postLimit = document.querySelector("#postInput");
    let regex = /^\d+$/i;

    if(!regex.exec(postLimit.value)) {
        alert("Please enter a valid number");
        postLimit.value = '10';
        return false;
    } else {
        if(postLimit.value > 10 && postLimit.value < 100) {
            //ajax request
            let formData = new FormData();

            formData.append('blogID', blogID);
            formData.append('postLimit', postLimit.value);

            let httpRequest = new XMLHttpRequest();

            if(httpRequest) {
                httpRequest.open('POST', 'http://localhost/backend/ajax/updatePostLimit.php', true);
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
            alert("Please enter a valid number");
            postLimit.value = '10';
            return false;
        }
    }
});