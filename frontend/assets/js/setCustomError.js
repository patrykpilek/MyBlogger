let customBtn = document.querySelector("#customEditBtn");
let customBox = document.querySelector("#customBox");
let customBlock = document.querySelector("#customBlock");
let cSaveBtn = document.querySelector("#customSaveBtn");
let cCancelBtn = document.querySelector("#customCancelBtn");

customBtn.addEventListener("click", function(event) {
    customBlock.style.display = "block";

    cCancelBtn.addEventListener("click", function(event) {
        customBlock.style.display = "none";
    });

    cSaveBtn.addEventListener("click", function(event){
       let textArea = document.querySelector("#customInput");
       let blogID = this.dataset.blog;

        //ajax request
        let formData = new FormData();

        formData.append('blogID', blogID);
        formData.append('error', textArea.value);

        let httpRequest = new XMLHttpRequest();

        if(httpRequest) {
            httpRequest.open('POST', 'http://localhost/backend/ajax/setCustomError.php', true);
            httpRequest.onreadystatechange = function () {
                if(this.readyState === 4 && this.status === 200) {
                    if(this.responseText.length !== 0) {
                        alert(this.responseText);
                    }
                    location.reload(true);
                }
            }

            httpRequest.send(formData);
        }
    });
});