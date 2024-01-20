document.addEventListener('DOMContentLoaded', function () {
    var container = document.querySelector('.image-container');
    var images = document.querySelectorAll('.zdjecie');

    container.style.width = (images.length * (200 + 20)) + 'px';

    function moveImagesLeft() {
        container.style.transform = 'translateX(-220px)';
        container.prepend(container.lastElementChild);
        container.style.transition = 'none';
        setTimeout(function () {
            container.style.transition = ''; 
            container.style.transform = 'translateX(0)';
        }, 0);
    }

    function moveImagesRight() {
        container.style.transform = 'translateX(-220px)';
        container.appendChild(container.firstElementChild); 
        container.style.transition = 'none';
        setTimeout(function () {
            container.style.transition = ''; 
            container.style.transform = 'translateX(0)';
        }, 0);
    }

    document.getElementById('prevButton').addEventListener('click', moveImagesLeft);
    document.getElementById('nextButton').addEventListener('click', moveImagesRight);
});