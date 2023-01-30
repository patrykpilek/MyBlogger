let button = document.querySelector("#titleBtn");
let block = document.querySelector("#titleBlock");
let cancelBtn = document.querySelector("#titleCancelBtn");
let saveBtn = document.querySelector("#titleSaveBtn");
let titleBox = document.querySelector("#titleBox");

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
            formData.append("blogID", this.dataset.blog);

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