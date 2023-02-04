let commentBtn = document.querySelector("#commentBtn");
let commentInput = document.getElementsByName('commentMod');

commentBtn.addEventListener("click", function(event) {
    let comment;
    if (!(commentInput[0].checked || commentInput[1].checked)) {
        alert("Please select to allow comments moderation");
        return false;
    } else {

        for(i = 0; i < commentInput.length; i++){
            if(commentInput[i].checked) {
                comment = commentInput[i].value;
            }
        }

        let blogID = this.dataset.blog;

        //ajax request
        let formData = new FormData();

        formData.append('blogID', blogID);
        formData.append('comment', comment);

        let httpRequest = new XMLHttpRequest();

        if (httpRequest) {
            httpRequest.open('POST', 'http://localhost/backend/ajax/updateCommentMod.php', true);
            httpRequest.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    if (this.responseText.length !== 0) {
                        alert(this.responseText);
                    }
                    location.reload(true);
                }
            }

            httpRequest.send(formData);
        }
    }
});
