let search = document.querySelector("#postSearch");
let blog_ID = document.querySelector("#postSearch").dataset.blog;
let buttonMenu = document.querySelector("#postJumpMenu");
let pageLimit = document.querySelector("#pageLimit");
let nextPageBtn = document.querySelector("#nextPage");
let activeLink = document.querySelector("#active")
let postSearchStatus = '';

if(window.location.href.indexOf('draft') > -1) {
    activeLink.classList.remove('active');
    document.querySelector("#draft").classList.add('active');
    postSearchStatus = 'draft';
} else if(window.location.href.indexOf('published') > -1) {
    activeLink.classList.remove('active');
    document.querySelector("#published").classList.add('active');
    postSearchStatus = 'published';
}

search.addEventListener("keyup", function(event) {
    if(event.which === 13) {
        let formData = new FormData();

        formData.append('search', search.value.trim());
        formData.append("blogID", blog_ID);

        let httpRequest = new XMLHttpRequest();

        if(httpRequest) {
            httpRequest.open('POST', 'http://localhost/backend/ajax/searchPosts.php', true);
            httpRequest.onreadystatechange = function () {
                if(this.readyState === 4 && this.status === 200) {
                    if(this.responseText.length !== 0) {
                        document.querySelector("#posts").innerHTML = this.responseText;
                        disableBtn();
                    }

                    if(search.value === '') {
                        enableBtn();
                    }
                }
            }
            httpRequest.send(formData);
        }
    }
});

function enableBtn() {
    pageLimit.disabled = false;
    buttonMenu.disabled = false;
    buttonMenu.classList.remove("disabled");
    nextPageBtn.disabled = false;
    nextPageBtn.classList.remove("disabled");
}

function disableBtn() {
    pageLimit.disabled = true;
    buttonMenu.disabled = true;
    buttonMenu.classList.add("disabled");
    nextPageBtn.disabled = true;
    nextPageBtn.classList.add("disabled");
}