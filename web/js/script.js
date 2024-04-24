// Смена темы

let lightTheme = "/web/css/light.css";
let darkTheme = '/web/css/site.css'
let lightImage = "/web/image/bel_fon.jpg";
let darkImage = "/web/image/genres/horror.png";

function isLightTheme(domElem) {
    let href = domElem.getAttribute("href");
    let startIndex = href.indexOf('/web');
    let correctHref = href.slice(startIndex);
    return correctHref === lightTheme;
}

function setImage(theme) {
    let image = document.getElementById('background');
    console.log(theme.getAttribute('href'));
    console.log(theme)
    console.log(image)
    if (!image) {
        return;
    }
    if (isLightTheme(theme)) {
        image.setAttribute('src', lightImage);
        console.log(1);
    } else {
        image.setAttribute('src', darkImage);
        console.log(2);
    }
}

function changeTheme(commit=true) {
        let theme = document.getElementById("theme");

        // Переключаем тему
        if (isLightTheme(theme)) {
            theme.href = darkTheme; // Путь к темной теме
        } else {
            theme.href = lightTheme; // Путь к светлой теме
        }
    setImage(theme);

        if (commit) {
            // Сохраняем выбранную тему в localStorage
            localStorage.setItem("theme", theme.href);
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



//  Модальное окно для обратной связи

const modal_sv = document.getElementById("modal_sv");
const btn_sv = document.getElementById("btn_sv");

function openModalsv() {
    modal_sv.style.display = "flex";
}

function closeModalsv() {
    modal_sv.style.display = "none";
}

btn_sv.onclick = openModalsv;

window.onclick = function (e) {
    if (e.target === modal_sv) {
        closeModalsv();
    }
};

// Функция для изменения цвета фона книги
    function changeColor(colorCode) {
        var contentDiv = document.getElementById("content");
        switch (colorCode) {
            case 1:
                contentDiv.style.backgroundColor = "white";
                break;
            case 2:
                contentDiv.style.backgroundColor = "beige";
                break;
            case 3:
                contentDiv.style.backgroundColor = "red";
                break;
            default:
                // Если нажата некорректная кнопка, ничего не делаем
                break;
        }
    }

// Добавляем обработчики событий для кнопок изменения цвета
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("button1").addEventListener("click", function () {
            changeColor(1);
        });
        document.getElementById("button2").addEventListener("click", function () {
            changeColor(2);
        });
        document.getElementById("button3").addEventListener("click", function () {
            changeColor(3);
        });
    });

});