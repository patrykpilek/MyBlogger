let button = document.querySelector("#labelMenu");
let labelMenu = document.querySelector(".label-menu");

button.addEventListener("click", function(event) {
    event.stopPropagation();
    labelMenu.classList.toggle("display");

    document.onclick = function(event) {
        event.stopPropagation();
        if(event.target !== button && event.target.className !== "label-menu") {
            labelMenu.classList.remove("display");
        }
    }
});