let searchBtn = document.querySelector("#searchBtn");

searchBtn.addEventListener("click", function(event) {
   let search = document.querySelector("#search");

   if(search.value !== '') {
       window.location = "http://" + window.location.host.split('.')[0] + ".localhost/search/" + search.value;
   }
});