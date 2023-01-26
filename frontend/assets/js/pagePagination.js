let btn = document.querySelector("#postJumpMenu");
let page = document.querySelector(".p-num > ul");
let pageMenu = document.querySelector(".p-num");
let postLimit = document.querySelector("#pageLimit");
let previousBtn = document.querySelector("#previousPage");
let nextBtn = document.querySelector("#nextPage");
let currentPage = document.querySelector("#currentPageNum");
let active = document.querySelector("#active")
let postStatus = '';
let bID = nextBtn.dataset.blog;

if(window.location.href.indexOf('draft') > -1) {
    active.classList.remove('active');
    document.querySelector("#draft").classList.add('active');
    postStatus = 'draft';
} else if(window.location.href.indexOf('published') > -1) {
    active.classList.remove('active');
    document.querySelector("#published").classList.add('active');
    postStatus = 'published';
}

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
            formData.append('postLimit', postLimit.value);
            formData.append('postStatus', postStatus);

            let httpRequest = new XMLHttpRequest();

            if(httpRequest){
                httpRequest.open('POST', 'http://localhost/backend/ajax/showNextPages.php', true);
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

nextBtn.addEventListener("click", function (event) {
    let currentNum = currentPage.innerHTML.trim();
    let lastPageNum = document.querySelector('.p-num > ul').lastElementChild.innerHTML.trim();
    previousBtn.disabled = false;
    previousBtn.classList.remove('disabled');

    if(lastPageNum > currentNum) {
        currentNum++;
        //ajax request
        let formData = new FormData();
        formData.append('blogID', bID);
        formData.append('nextPage', currentNum);
        formData.append('postLimit', postLimit.value);
        formData.append('postStatus', postStatus);

        let httpRequest = new XMLHttpRequest();

        if(httpRequest){
            httpRequest.open('POST', 'http://localhost/backend/ajax/showNextPages.php', true);
            httpRequest.onreadystatechange = function(){
                if(this.readyState === 4 && this.status === 200){
                    document.querySelector("#posts").innerHTML = this.responseText;
                    currentPage.innerHTML = currentNum;
                }
            }
            httpRequest.send(formData);
        }
    }
    if(lastPageNum-1 < currentNum) {
        nextBtn.disabled = true;
        nextBtn.classList.add("disabled");
    }
});

previousBtn.addEventListener("click", function (event) {
    let currentNum = currentPage.innerHTML.trim();
    let lastPageNum = document.querySelector('.p-num > ul').lastElementChild.innerHTML.trim();


    if(currentNum > '1') {
        currentNum--;

        nextBtn.disabled = false;
        nextBtn.classList.remove("disabled");

        //ajax request
        let formData = new FormData();
        formData.append('blogID', bID);
        formData.append('previousPage', currentNum);
        formData.append('postLimit', postLimit.value);
        formData.append('postStatus', postStatus);

        let httpRequest = new XMLHttpRequest();

        if(httpRequest){
            httpRequest.open('POST', 'http://localhost/backend/ajax/showPreviousPages.php', true);
            httpRequest.onreadystatechange = function(){
                if(this.readyState === 4 && this.status === 200){
                    document.querySelector("#posts").innerHTML = this.responseText;
                    currentPage.innerHTML = currentNum;
                }
            }
            httpRequest.send(formData);
        }
    }
    if(currentNum === '1') {
        previousBtn.disabled = true;
        previousBtn.classList.add("disabled");
    }
});

postLimit.addEventListener("change", function(e) {
    let jumpTo = this.value;
    //ajax request
    let formData = new FormData();
    formData.append('blogID', bID);
    formData.append('postLimit', jumpTo);
    formData.append('postStatus', postStatus);

    let httpRequest = new XMLHttpRequest();

    if(httpRequest){
        httpRequest.open('POST', 'http://localhost/backend/ajax/jumToPage.php', true);
        httpRequest.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                document.querySelector("#posts").innerHTML = this.responseText;
                currentPage.innerHTML = 1;
                getPagesNumber(jumpTo);
            }
        }
        httpRequest.send(formData);
    }
});

function getPagesNumber(jumpTo) {
    //ajax request
    let formData = new FormData();
    formData.append('blogID', bID);
    formData.append('postLimit', jumpTo);
    formData.append('postStatus', postStatus);

    let httpRequest = new XMLHttpRequest();

    if(httpRequest){
        httpRequest.open('POST', 'http://localhost/backend/ajax/getPagesNumbers.php', true);
        httpRequest.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                let regex = /(25|50|100)/g;
                let number = jumpTo.match(regex);
                let page = document.querySelector("#page-num");
                if(number) {
                    page.innerHTML = this.responseText;
                    if(page.textContent === "1") {
                        disableBtn();
                    } else {
                        enableBtn();
                    }
                }
            }
        }
        httpRequest.send(formData);
    }
}

function enableBtn() {
    postLimit.disabled = false;

    btn.disabled = false;
    btn.classList.remove("disabled");
    nextBtn.disabled = false;
    nextBtn.classList.remove("disabled");
}

function disableBtn() {
    btn.disabled = true;
    btn.classList.add("disabled");
    nextBtn.disabled = true;
    nextBtn.classList.add("disabled");
}