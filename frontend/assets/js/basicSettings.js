let button = document.querySelector("#titleBtn");
let block = document.querySelector("#titleBlock");
let cancelBtn = document.querySelector("#titleCancelBtn");
let saveBtn = document.querySelector("#titleSaveBtn");
let titleBox = document.querySelector("#titleBox");
let blogID = saveBtn.dataset.blog;

button.addEventListener("click", function(event) {
    block.style.display = "block";

    cancelBtn.addEventListener("click", function (event) {
        block.style.display = "none";
    });

    saveBtn.addEventListener("click", function(event) {
        let title = document.querySelector("#titleInput");

        if(title.value.trim() !== "") {
            let formData = new FormData();

            formData.append('title', title.value.trim());
            formData.append("blogID", blogID);

            let httpRequest = new XMLHttpRequest();

            if(httpRequest) {
                httpRequest.open('POST', 'http://localhost/backend/ajax/updateTitle.php', true);
                httpRequest.onreadystatechange = function () {
                    if(this.readyState === 4 && this.status === 200) {
                        if(/OwnnerError$/i.exec(this.responseText)) {
                            alert("You cannot preform this action !");
                            location.reload(true);
                        } else {
                            this.value = this.responseText;
                        }

                        block.style.display = "none";
                        titleBox.innerHTML = title.value;
                    }
                }

                httpRequest.send(formData);
            }
        } else {
            document.querySelector("#titleError").innerHTML = "Required field must not be blank";
        }
    });
});

let descBtn = document.querySelector("#descBtn");
let descBlock = document.querySelector("#descBlock");
let descCancelBtn = document.querySelector("#descCancelBtn");
let descSaveBtn = document.querySelector("#descSaveBtn");
let descBox = document.querySelector("#descBox");

descBtn.addEventListener("click", function(event) {
    descBlock.style.display = "block";

    descCancelBtn.addEventListener("click", function(event) {
        descBlock.style.display = "none";
    });

    descSaveBtn.addEventListener("click", function(event) {
        descText = document.querySelector("#descInput");

        if(descText.value.trim().length < '500') {
            //ajax request
            let formData = new FormData();

            formData.append('description', descText.value.trim());
            formData.append("blogID", blogID);

            let httpRequest = new XMLHttpRequest();

            if(httpRequest) {
                httpRequest.open('POST', 'http://localhost/backend/ajax/updateDescription.php', true);
                httpRequest.onreadystatechange = function () {
                    if(this.readyState === 4 && this.status === 200) {
                        if(/OwnnerError$/i.exec(this.responseText)) {
                            alert("You cannot preform this action !");
                            location.reload(true);
                        } else {
                            this.value = this.responseText;
                        }

                        descBlock.style.display = "none";
                        descBox.innerHTML = descText.value;
                    }
                }

                httpRequest.send(formData);
            }
        } else {
            document.querySelector("#descError").innerHTML = "Must be at most 500 characters!";
        }
    });
});