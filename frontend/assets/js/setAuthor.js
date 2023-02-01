let formBtn = document.querySelector("#authorBtn");

formBtn.addEventListener("click", function(event) {
    document.querySelector(".au-main").style.display = "block";

    let formSaveBtn = document.querySelector("#formSave");

    formSaveBtn.addEventListener("click", function(event) {
        let email = document.querySelector('#emailInput');
        let name = document.querySelector('#nameInput');
        let pass = document.querySelector('#passInput');
        let passRe = document.querySelector('#passReInput');
        let file = document.querySelector('#file').files[0];

        if(email.value === '') {
            document.querySelector("#emailError").innerHTML = "required field must not be blank!";
        }

        if(name.value === '') {
            document.querySelector("#nameError").innerHTML = "required field must not be blank!";
        }

        if(pass.value === '') {
            document.querySelector("#passError").innerHTML = "required field must not be blank!";
        }

        if(passRe.value === '') {
            document.querySelector("#passReError").innerHTML = "required field must not be blank!";
        }

        if(email.value && name.value && pass.value && passRe.value !== '') {
            if(pass.value === passRe.value) {
                if(pass.value.length > 4) {
                    // send ajax request
                } else {
                    document.querySelector("#passReError").innerHTML = "password is to short";
                }
            } else {
                document.querySelector("#passReError").innerHTML = "password does not match!";
            }
        }
    });
});