let button = document.querySelector("#labelMenu");
let labelMenu = document.querySelector(".label-menu");

button.addEventListener("click", function(event) {
    event.stopPropagation();
    labelMenu.classList.toggle("display");

    let newLabel = document.querySelector("#newLabel");

    newLabel.addEventListener("click", function(event) {
        let checkBox = document.querySelectorAll(".postCheckBox");
        let array = new Array();

        checkBox.forEach(function(el){
            if(el.checked) {
                array.push(el.value);
            }
        });

        if(array.length > 0) {
            let newLabelValue = prompt("Enter the new label");
            if(newLabelValue !== null || newLabelValue !== '') {
                let regex = /^[a-z0-9]/i;
                let label = newLabelValue.match(regex);

                if(label !== null) {
                    //ajax request
                    alert("it's working");
                }
            }
        } else {
            alert("No posts are selected!");
            location.reload(true);
        }
    });

    document.onclick = function(event) {
        event.stopPropagation();
        if(event.target !== button && event.target.className !== "label-menu") {
            labelMenu.classList.remove("display");
        }
    }
});