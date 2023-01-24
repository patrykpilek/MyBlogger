let search = document.querySelector("#postSearch");
let blog_ID = document.querySelector("#postSearch").dataset.blog;

search.addEventListener("keyup", function(event) {
    if(event.which === 13) {
        let formData = new FormData();

        formData.append('search', search.value.trim());
        formData.append("blogID", blog_ID);

        let httpRequest = new XMLHttpRequest();

        if(httpRequest) {
            httpRequest.open('POST', 'http://localhost/backend/ajax/searchPosts.php', true);
            httpRequest.onreadystatechange = function () {
                if(this.readyState === 4 && this.status === 200) {
                    if(this.responseText.length !== 0) {
                        document.querySelector("#posts").innerHTML = this.responseText;
                    }
                }
            }
            httpRequest.send(formData);
        }
    }
});