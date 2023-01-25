let btn = document.querySelector("#postJumpMenu");
let page = document.querySelector(".p-num > ul");
let pageMenu = document.querySelector(".p-num");
let postLimit = document.querySelector("#pageLimit");
let previousBtn = document.querySelector("#previousPage");
let nextBtn = document.querySelector("#nextPage");
let currentPage = document.querySelector("#currentPageNum");
let bID = nextBtn.dataset.blog;
let postStatus = '';

if(page.lastElementChild != null) {
    if(page.lastElementChild.innerHTML.trim() > 1) {
        enableBtn();
    }
}

btn.addEventListener("click", function(event) {
    event.preventDefault();
    event.stopPropagation();

    pageMenu.classList.toggle("display");
    let pages = document.querySelectorAll('.pageNum')

    pages.forEach(function(el) {
        el.addEventListener("click", function(event) {

            let page = document.querySelector('.p-num > ul').lastElementChild.innerHTML.trim();

            //ajax request
            let formData = new FormData();
            formData.append('blogID', bID);
            formData.append('nextPage', el.innerHTML.trim());
            formData.append('postLimit', 1);
            formData.append('postStatus', postStatus);

            let httpRequest = new XMLHttpRequest();

            if(httpRequest){
                httpRequest.open('POST', 'http://localhost/backend/ajax/showNextPosts.php', true);
                httpRequest.onreadystatechange = function(){
                    if(this.readyState === 4 && this.status === 200){
                        document.querySelector("#posts").innerHTML = this.responseText;
                        currentPage.innerHTML = el.innerHTML;

                        if(el.innerHTML !== '1') {
                            previousBtn.disabled = false;
                            previousBtn.classList.remove("disabled");
                        } else {
                            previousBtn.disabled = true;
                            previousBtn.classList.add("disabled");
                        }

                        if(el.innerHTML === page) {
                            nextBtn.disabled = true;
                            nextBtn.classList.add("disabled");
                        } else {
                            nextBtn.disabled = false;
                            nextBtn.classList.remove("disabled");
                        }
                    }
                }
                httpRequest.send(formData);
            }
        })
    });

    document.onclick = function (e) {
        e.stopPropagation();
        if(e.target !== btn) {
            pageMenu.classList.remove("display");
        }
    }
});

function enableBtn() {
    btn.disabled = false;
    btn.classList.remove("disabled");
}