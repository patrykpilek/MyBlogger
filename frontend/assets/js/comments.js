let commentBtn = document.querySelector("#commentBtn");
let cancelBtn = document.querySelector("#cancelBtn");
let replyBtn = document.querySelectorAll("#replyBtn");

cancelBtn.addEventListener("click", function(event) {
    window.location.reload(true);
});

replyBtn.forEach(function(el) {
    el.addEventListener("click", function(event) {
        event.preventDefault();
        let parentEl = this.parentElement.parentElement.parentElement;
        let commentForm = document.querySelector(".comment-wrapper");

        parentEl.append(commentForm);
        commentForm = '';
        commentBtn.dataset.reply = this.dataset.reply;
    });
});

commentBtn.addEventListener("click", function(event) {
    event.preventDefault();
    let name = document.querySelector("#name").value;
    let email  = document.querySelector("#email").value;
    let comment = document.querySelector("#comment").value;

    if(name && email && comment !== "") {
        let formData = new FormData();

        formData.append('postID', this.dataset.post);
        formData.append("blogID", this.dataset.blog);
        formData.append("reply", this.dataset.reply);
        formData.append("name", name);
        formData.append("email", email);
        formData.append("comment", comment);

        let httpRequest = new XMLHttpRequest();

        if(httpRequest) {
            httpRequest.open('POST', 'http://' + window.location.host.split('.')[0] +'.localhost/backend/ajax/postComment.php', true);
            httpRequest.onreadystatechange = function () {
                if(this.readyState === 4 && this.status === 200) {
                    if(this.responseText.length !== 0) {
                        alert(this.responseText);
                    } else {
                        alert('Your comment is under review, it will take few hours to show up!');
                    }
                    location.reload(true);
                }
            }

            httpRequest.send(formData);
        }
    } else {
        alert("Please enter your name, email and comment to post");
    }
});