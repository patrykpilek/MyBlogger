let deleteBtn = document.querySelectorAll(".deleteAuthor");

if(deleteBtn) {
    deleteBtn.forEach(function(el) {
       el.addEventListener("click", function(event) {
          event.preventDefault();
          let authorID = this.dataset.author;
          let blogID = this.dataset.blog;

          if(confirm('Are you sure? You want to delete this user?')) {
              //ajax request
              let formData = new FormData();
              let role = this.textContent;

              formData.append('blogID', blogID);
              formData.append('authorID', authorID);

              let httpRequest = new XMLHttpRequest();

              if(httpRequest) {
                  httpRequest.open('POST', 'http://localhost/backend/ajax/removeAuthor.php', true);
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
          } else {
              window.location.reload(true);
          }
       });
    });
}