// Pobierz kontener i obrazy po załadowaniu całej strony
document.addEventListener('DOMContentLoaded', function () {
    var container = document.querySelector('.image-container');
    var images = document.querySelectorAll('.zdjecie');

    // Ustaw szerokość kontenera na sumę szerokości obrazów
    container.style.width = (images.length * (200 + 20)) + 'px';

    // Funkcja do przesuwania obrazów w lewo
    function moveImagesLeft() {
        container.style.transform = 'translateX(-220px)'; // Przesuń w prawo o szerokość obrazu + odstęp
        container.prepend(container.lastElementChild); // Przenieś ostatni obraz na początek
        container.style.transition = 'none'; // Wyłącz przejście, aby uniknąć animacji podczas powrotu do początkowego układu
        setTimeout(function () {
            container.style.transition = ''; // Przywróć przejście
            container.style.transform = 'translateX(0)'; // Przesuń kontener z powrotem na początek
        }, 0);
    }

    // Funkcja do przesuwania obrazów w prawo
    function moveImagesRight() {
        container.style.transform = 'translateX(-220px)'; // Przesuń w lewo o szerokość obrazu + odstęp
        container.appendChild(container.firstElementChild); // Przenieś pierwszy obraz na koniec
        container.style.transition = 'none'; // Wyłącz przejście, aby uniknąć animacji podczas powrotu do początkowego układu
        setTimeout(function () {
            container.style.transition = ''; // Przywróć przejście
            container.style.transform = 'translateX(0)'; // Przesuń kontener z powrotem na początek
        }, 0);
    }

    // Dodaj obsługę zdarzeń do przycisków, które uruchamiają przewijanie
    document.getElementById('prevButton').addEventListener('click', moveImagesLeft);
    document.getElementById('nextButton').addEventListener('click', moveImagesRight);
});