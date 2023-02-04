let saveProfileBtn = document.querySelector("#saveProfileBtn");

saveProfileBtn.addEventListener("click", function(event) {
    let email = document.querySelector("#editEmail");
    let name = document.querySelector("#editDisplayName");
    let file = document.querySelector("#editProfile").files[0];

    if(email.value === "") {
        document.querySelector("#editEmailError").innerHTML = "Required filed must be blank!";
    }

    if(name.value === "") {
        document.querySelector("#displayNameError").innerHTML = "Required filed must be blank!";
    }

    if(name.value && email.value !== "") {

        let blogID = this.dataset.blog;
        //ajax request
        let formData = new FormData();

        formData.append('blogID', blogID);
        formData.append('email', email.value);
        formData.append('name', name.value);
        formData.append('file', file);

        let httpRequest = new XMLHttpRequest();

        if (httpRequest) {
            httpRequest.open('POST', 'http://localhost/backend/ajax/editProfile.php', true);
            httpRequest.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    if (this.responseText.length !== 0) {
                        alert(this.responseText);
                    }
                    location.reload(true);
                }
            }

            httpRequest.send(formData);
        }

    }
});

document.querySelector('#editProfile').addEventListener("change", function(event) {
    let regex = /(\.jpg|\.jpeg|\.png)$/i;

    if(!regex.exec(this.value)) {
        alert("Only '.jpeg', '.jpg', '.png', formats are allowed");
        this.value = '';
        return false;
    } else {
        if(this.files && this.files[0]) {
            let reader = new FileReader();
            reader.onload = function(event) {
                document.querySelector("#editProfileImage").src = event.target.result;
            }
            reader.readAsDataURL(this.files[0]);
        }
    }
});