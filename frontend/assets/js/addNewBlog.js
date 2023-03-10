let blogListBtn = document.querySelector('#blogListBtn');
let blogListMenu = document.querySelector('#blogListMenu');
let newBlogBtn = document.querySelector('#newBlogBtn');
let blogForm = document.querySelector('#blogFormPopup');

blogListBtn.addEventListener("click", function(event) {
    event.stopPropagation();

    blogListMenu.classList.toggle("display");

    document.onclick = function(event) {
        if(event.target !== blogListBtn && event.target.parentElement.parentElement !== blogListMenu) {
            blogListMenu.classList.remove("display");
        }
    }

    newBlogBtn.addEventListener("click", function (event) {
        blogListMenu.classList.remove('display');
        getBlogForm();
        blogForm.style.display = 'block';
    });
});

function getBlogForm() {
    let httpRequest = new XMLHttpRequest();

    if(httpRequest) {
        httpRequest.open('GET', 'http://localhost/backend/ajax/getBlogFormPopup.html', true);
        httpRequest.onreadystatechange = function () {
            if(this.readyState === 4 && this.status === 200) {
                document.querySelector('#blogFormPopup').innerHTML = this.responseText;
                let closeBtn = document.querySelectorAll("#closePopup");
                let createBtn = document.querySelector('#createBlogBtn');

                createBtn.addEventListener("click", function(event) {
                    let title = document.querySelector('#blogTitle');
                    let url = document.querySelector('#blogUrl');
                    let error = document.querySelector('#error');
                    let regex = /^([a-z]+)$/;

                    if(title.value !== '' && url.value !== '') {
                        if(!regex.exec(url.value)) {
                            error.innerHTML = "This blog address is invalid or not supported!";
                        } else {
                            createBlog(title.value, url.value);
                        }
                    } else {
                        error.innerHTML = "Please enter title an blog address."
                    }
                });

                if(closeBtn !== null) {
                    closeBtn.forEach(function(el) {
                        el.addEventListener("click", function(event) {
                            blogForm.style.display = 'none';
                            blogForm.innerHTML = '';
                        });
                    });
                }
            }
        }

        httpRequest.send();
    }
}

function createBlog(title, url) {
    let formData = new FormData();

    formData.append('title', title);
    formData.append('url', url);
    formData.append('blogID', newBlogBtn.dataset.blog);

    let httpRequest = new XMLHttpRequest();

    if(httpRequest) {
        httpRequest.open('POST', 'http://localhost/backend/ajax/createBlog.php', true);
        httpRequest.onreadystatechange = function () {
            if(this.readyState === 4 && this.status === 200) {
                if(isNaN(this.responseText)) {
                    document.querySelector('#error').innerHTML = this.responseText;
                } else {
                    window.location.href = 'http://localhost/admin/blogID/' + this.responseText + '/dashboard/';
                }
            }
        }

        httpRequest.send(formData);
    }
}