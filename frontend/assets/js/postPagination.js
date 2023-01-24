let btn = document.querySelector("#postJumpMenu");
let page = document.querySelector(".p-num > ul");
let pageMenu = document.querySelector(".p-num")

if(page.lastElementChild != null) {
    if(page.lastElementChild.innerHTML.trim() > 1) {
        enableBtn();
    }
}

btn.addEventListener("click", function(event) {
    event.preventDefault();
    event.stopPropagation();

    pageMenu.classList.toggle("display");

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