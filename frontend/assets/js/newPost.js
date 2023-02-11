let labels = document.querySelectorAll(".label");

labels.forEach(function(el) {
    el.addEventListener("click", function(event) {
        let labelArea = document.querySelector("#labelArea");

        if(labelArea.value.trim() !== '') {
            if(labelArea.value.indexOf(el.innerHTML) === -1) {
                let comma = labelArea.value.trim().slice();

                if(comma === ',') {
                    label = labelArea.value + el.innerHTML;
                    labelArea.value = label;
                } else {
                    //add label with comma
                    label = labelArea.value + ', ' + el.innerHTML;
                    labelArea.value = label;
                }
            }
        } else {
            label = labelArea.value + el.innerHTML;
            labelArea.value = label;
        }
    });
});