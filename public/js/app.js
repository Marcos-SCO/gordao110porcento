// import helpers
import {qSelect, qSelectAll, gID, log} from './helpers.js';

// on load spinner
document.onreadystatechange = function () {
    if (document.readyState !== "complete") {
        document.querySelector(
            "body").style.visibility = "hidden";
        document.querySelector(
            "#loader").style.visibility = "visible";
    } else {
        setTimeout(() => {
            document.querySelector(
                "#loader").style.display = "none";
            document.querySelector(
                "body").style.visibility = "visible";
        }, 100);
    }
};

// flash message
let flash = document.querySelector('#msg-flash');
if (flash != null) {
    setTimeout(() => {
        flash.style =
            'display:none;transition: transform .18s, opacity .18s, visibility 0s .18s;';
    }, 4000);
}

// Carousel Principal
$('#carousel-principal').owlCarousel({
    items: 1,
    lazyLoad: true,
    loop: true,
    margin: 10,
    nav: true,
    navSpeed: 1000,
    navText: ['<i class="fas fa-arrow-left"></i>', '<i class="fas fa-arrow-right"></i>'],
    dots: true,
    dotsSpeed: 1000,
    // autoplay: true,
    autoplaySpeed: 1000,
    reponsiveRefreshRatio: 10
});

// get elements with data-anima
const elements = qSelectAll('[data-anima]');
const animationClass = 'animation';
function animaScroll() {
    const topPageWindow = window.pageYOffset + ((window.innerHeight * 3) / 4); // 3/4 da janela
    elements.forEach(element => {
        if (topPageWindow > element.offsetTop) {
            element.classList.add(animationClass);
        } else {
            element.classList.remove(animationClass);
        }
    });
}
// Carrega Animações
if (elements.length) {
    window.addEventListener('scroll', animaScroll);
}
// end get elements

var owl = $('.owl-carousel');
owl.owlCarousel({
    items:4,
    loop:true,
    margin:10,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true
});