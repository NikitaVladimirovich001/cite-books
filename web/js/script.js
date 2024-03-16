document.addEventListener("DOMContentLoaded", function () {
    // Проверяю, есть ли 'theme' в локальном хранилище
    let savedTheme = localStorage.getItem("theme");

    // Если есть, применяем это значение, иначе по умолчанию используем светлую тему
    if (savedTheme) {
        document.getElementById("theme").href = savedTheme;
    } else {
        document.getElementById("theme").href = "css/light.css"; // Путь к светлой теме
    }

    let switchMode = document.getElementById("switchMode");

    switchMode.onclick = function () {
        let theme = document.getElementById("theme");

        // Переключаем тему
        if (theme.getAttribute("href") === "css/light.css") {
            theme.href = 'css/site.css'; // Путь к темной теме
        } else {
            theme.href = 'css/light.css'; // Путь к светлой теме
        }

        // Сохраняем выбранную тему в localStorage
        localStorage.setItem("theme", theme.href);
    };
});


// кнопка для отоброжение и удаления модального окна
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