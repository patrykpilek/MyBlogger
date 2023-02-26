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
                let closeBtn = document.querySelector("#closePopup");

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