let button = document.querySelector("#labelMenu");
let labelMenu = document.querySelector(".label-menu");
let label = document.querySelectorAll(".label");
let blogID = document.querySelector("#newLabel").dataset.blog;
let checkAll = document.querySelector("#checkAll");

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
                let regex  = /^[a-z0-9]+/i;
                let label = newLabelValue.match(regex);

                if(label !== null) {
                    //ajax request
                    let formData = new FormData();
                    formData.append('newLabel', label);
                    formData.append('postID', JSON.stringify(array));
                    formData.append('blogID', this.dataset.blog);

                    let httpRequest = new XMLHttpRequest();

                    if(httpRequest){
                        httpRequest.open('POST', 'http://localhost/backend/ajax/addLabel.php', true);
                        httpRequest.onreadystatechange = function(){
                            if(this.readyState === 4 && this.status === 200){
                                location.reload(true);
                            }
                        }
                        httpRequest.send(formData);
                    }
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

label.forEach(function(el) {
    el.addEventListener("click", function(event) {
        event.preventDefault();
        event.stopPropagation();

        let checkBox = document.querySelectorAll(".postCheckBox");
        let array = new Array();

        checkBox.forEach(function(el){
            if(el.checked) {
                array.push(el.value);
            }
        });

        if(array.length > 0) {
            //ajax request
            let formData = new FormData();
            formData.append('newLabel', el.textContent);
            formData.append('postID', JSON.stringify(array));
            formData.append('blogID', blogID);

            let httpRequest = new XMLHttpRequest();

            if(httpRequest){
                httpRequest.open('POST', 'http://localhost/backend/ajax/addLabel.php', true);
                httpRequest.onreadystatechange = function(){
                    if(this.readyState === 4 && this.status === 200){
                        location.reload(true);
                    }
                }
                httpRequest.send(formData);
            }
        } else {
            alert("No posts are selected!");
            location.reload(true);
        }
    })
});

checkAll.addEventListener("change", function(e) {
    let checkBox = document.querySelectorAll('.postCheckBox');

    checkBox.forEach(function(el) {
        el.checked = true;
    });

    if(this.checked === false) {
        checkBox.forEach(function(el) {
            el.checked = false;
        });
    }
})