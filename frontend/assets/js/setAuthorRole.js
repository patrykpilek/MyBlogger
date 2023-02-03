let authorBtn = document.querySelectorAll("#authorMenu");

if(authorBtn) {
    authorBtn.forEach(function(el) {
        el.addEventListener("click", function(event) {
            let role = el;
            let menu = this.nextElementSibling;
            let option = document.querySelectorAll(".option");

            menu.classList.toggle("display");

            if(option) {
                option.forEach(function(el) {
                    el.addEventListener("click", function(event) {
                        if(confirm("Do you want to change permission for this user?")) {
                            //ajax request
                            let formData = new FormData();

                            formData.append('blogID', blogID);

                            let httpRequest = new XMLHttpRequest();

                            if(httpRequest) {
                                httpRequest.open('POST', 'http://localhost/backend/ajax/setAuthorRole.php', true);
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
                        }
                    });
                });
            }

            document.onclick = function(event) {
                event.stopPropagation();
                if(event.target.id !== "authorMenu") {
                    menu.classList.remove('display');
                }
            }
        });
    });
}