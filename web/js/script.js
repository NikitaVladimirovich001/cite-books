let switchMode = document.getElementById("switchMode");

switchMode.onclick = function () {
    let theme = document.getElementById("theme");

    if(theme.getAttribute("href") == "css/light.css") {
        theme.href = 'css/site.css';
    } else {
        theme.href = 'css/light.css';
    }
}
