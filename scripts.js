function loadFile(event) {
    var image = document.getElementById('output');
    var span = document.querySelector('.image-box span');
    image.src = URL.createObjectURL(event.target.files[0]);
    image.style.display = 'block';
    span.style.display = 'none';
    image.onload = function() {
        URL.revokeObjectURL(image.src) // free memory
    }
}
/*akun */
function openTab(event, tabId) {
    var i, tabcontent, tabbuttons;
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].classList.remove("active");
    }
    tabbuttons = document.getElementsByClassName("tab-button");
    for (i = 0; i < tabbuttons.length; i++) {
        tabbuttons[i].classList.remove("active");
    }
    document.getElementById(tabId).classList.add("active");
    event.currentTarget.classList.add("active");
}
/**akundonasi */
function openTab(event, tabId) {
    var i, tabcontent, tabbuttons;
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].classList.remove("active");
    }
    tabbuttons = document.getElementsByClassName("tab-button");
    for (i = 0; i < tabbuttons.length; i++) {
        tabbuttons[i].classList.remove("active");
    }
    document.getElementById(tabId).classList.add("active");
    event.currentTarget.classList.add("active");
    document.getElementById('tab-title').innerText = event.currentTarget.innerText;
}


