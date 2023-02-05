let metaDescBtn = document.querySelector("#metaDescBtn");
let metaDescBlock = document.querySelector("#metaDescBlock");
let metaDescCancelBtn = document.querySelector("#metaCancelBtn");
let metaDescSaveBtn = document.querySelector("#metaSaveBtn");
let metaDescBox = document.querySelector("#metaDescBox");

metaDescBtn.addEventListener("click", function(event) {
    metaDescBlock.style.display = "block";

    metaDescCancelBtn.addEventListener("click", function(event) {
        metaDescBlock.style.display = "none";
    });

    metaDescSaveBtn.addEventListener("click", function(event) {
        descText = document.querySelector("#metaDescInput");

        if(descText.value.trim().length < '150') {
            //ajax request
            let formData = new FormData();

            formData.append('description', descText.value.trim());
            formData.append("blogID", blogID);

            let httpRequest = new XMLHttpRequest();

            if(httpRequest) {
                httpRequest.open('POST', 'http://localhost/backend/ajax/updateMeta.php', true);
                httpRequest.onreadystatechange = function () {
                    if(this.readyState === 4 && this.status === 200) {
                        if(/OwnnerError$/i.exec(this.responseText)) {
                            alert("You cannot preform this action !");
                            location.reload(true);
                        } else {
                            this.value = this.responseText;
                        }

                        metaDescBlock.style.display = "none";
                        metaDescBox.innerHTML = descText.value;
                    }
                }

                httpRequest.send(formData);
            }
        } else {
            document.querySelector("#metaDescError").innerHTML = "Must be at most 150 characters!";
        }
    });
});