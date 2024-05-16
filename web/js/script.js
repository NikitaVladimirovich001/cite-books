// Смена темы

let lightTheme = "css/light.css";
let darkTheme = 'css/site.css'
let lightImage = "image/bel_fon.jpg";
let darkImage = "image/genres/horror.png";

function isLightTheme(domElem) {
    let href = domElem.getAttribute("href");
    let startIndex = href.indexOf('');
    let correctHref = href.slice(startIndex);
    return correctHref === lightTheme;
}

function changeTheme(commit=true) {
    let theme = document.getElementById("theme");

    // Переключаем тему
    if (isLightTheme(theme)) {
        theme.href = darkTheme; // Путь к темной теме
        localStorage.setItem("image", darkImage); // Сохраняем путь к темному изображению
    } else {
        theme.href = lightTheme; // Путь к светлой теме
        localStorage.setItem("image", lightImage); // Сохраняем путь к светлому изображению
    }
    setImage(theme);

    if (commit) {
        // Сохраняем выбранную тему в localStorage
        localStorage.setItem("theme", theme.href);
    }
}

function setImage(theme) {
    let image = document.getElementById('background');

    // Получаем сохраненное изображение из локального хранилища
    let savedImage = localStorage.getItem("image");

    // Если изображение сохранено, устанавливаем его
    if (savedImage) {
        image.setAttribute('src', savedImage);
    } else {
        // Если изображение не сохранено, устанавливаем изображение в зависимости от текущей темы
        if (isLightTheme(theme)) {
            image.setAttribute('src', lightImage);
        } else {
            image.setAttribute('src', darkImage);
        }
    }
}
//
// Проверяю, есть ли 'theme' в локальном хранилище
let savedTheme = localStorage.getItem("theme");

// Если есть, применяем это значение, иначе по умолчанию используем светлую тему
if (savedTheme) {
    document.getElementById("theme").href = savedTheme;
} else {
    document.getElementById("theme").href = lightTheme; // Путь к светлой теме
}

document.addEventListener("DOMContentLoaded", function () {
    setImage(document.getElementById("theme"));
    let switchMode = document.getElementById("switchMode");
    switchMode.onclick = function () {
        changeTheme();
    };


// кнопка для отоброжение и удаления модального окна для смены темы

    const modal = document.getElementById("modal");
    const btn_menu = document.getElementById("btn_menu");

    let isModalOpened = false;

    function openModal() {
        modal.style.display = "flex";
        isModalOpened = true;
    }

    function closeModal() {
        if (!isCursorOnModal) {
            modal.style.display = "none";
            isModalOpened = false;
        }
    }

    btn_menu.addEventListener('mouseover', openModal);
    btn_menu.addEventListener('mouseout', function() {
        setTimeout(closeModal, 300); // Добавляем небольшую задержку перед закрытием модального окна
    });

    modal.addEventListener('mouseover', function() {
        isCursorOnModal = true;
    });

    modal.addEventListener('mouseout', function() {
        isCursorOnModal = false;
        setTimeout(closeModal, 300); // Добавляем небольшую задержку перед закрытием модального окна
    });

});