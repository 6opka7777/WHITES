document.addEventListener("DOMContentLoaded", function() {

    // Получите ссылки на элементы формы и список треков

    var searchInput = document.getElementById("search-input");

    var searchButton = document.getElementById("search-button");

    var tracks = document.querySelectorAll(".track");



    // Обработчик для кнопки поиска

    searchButton.addEventListener("click", function() {

        var searchTerm = searchInput.value.toLowerCase(); // Получите значение из поля ввода и преобразуйте его в нижний регистр

        searchTracks(searchTerm);

    });



    // Функция поиска треков

    function searchTracks(term) {

        tracks.forEach(function(track) {

            var title = track.querySelector("h3").textContent.toLowerCase();

            if (title.includes(term)) {

                track.style.display = "block"; // Показать трек, если его название соответствует поисковому запросу

            } else {

                track.style.display = "none"; // Скрыть трек, если его название не соответствует запросу

            }

        });

    }

});







document.addEventListener("DOMContentLoaded", function() {

    // Получите ссылки на элементы формы и список треков

    var searchInput = document.getElementById("search-input");

    var searchButton = document.getElementById("search-button");

    var tracks = document.querySelectorAll(".track");



    // Обработчик для кнопки поиска

    searchButton.addEventListener("click", function() {

        var searchTerm = searchInput.value.toLowerCase(); // Получите значение из поля ввода и преобразуйте его в нижний регистр

        searchTracks(searchTerm);

    });



    // Функция поиска треков

    function searchTracks(term) {

        tracks.forEach(function(track) {

            var title = track.querySelector("h3").textContent.toLowerCase();

            if (title.includes(term)) {

                track.style.display = "block"; // Показать трек, если его название соответствует поисковому запросу

            } else {

                track.style.display = "none"; // Скрыть трек, если его название не соответствует запросу

            }

        });

    }

});







