document.addEventListener('DOMContentLoaded', () => {
    let sliderInner = document.querySelector('.slider--inner');
    let arrowLeft = document.querySelector('.left-arrow');
    let arrowRight = document.querySelector('.right-arrow');
    let index = 0; // Inicializar en 0
    let images = sliderInner.querySelectorAll('img');

    arrowLeft.addEventListener('click', () => {
        index--;
        if (index < 0) {
            index = images.length - 1; // Ir al último índice
        }
        mover(index, sliderInner);
    });

    arrowRight.addEventListener('click', () => {
        index++;
        if (index >= images.length) {
            index = 0; // Ir al primer índice
        }
        mover(index, sliderInner);
    });

    setInterval(() => {
        index++;
        if (index >= images.length) {
            index = 0; // Ir al primer índice
        }
        mover(index, sliderInner);
    }, 4000);
});

function mover(index, sliderInner) {
    let percentage = index * -100;
    sliderInner.style.transform = "translateX(" + percentage + "%)";
    console.log('index ' + index);
}
