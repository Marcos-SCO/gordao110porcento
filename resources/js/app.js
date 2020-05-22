import "@babel/polyfill";
// import helpers
import { qSelect, qSelectAll, gID, log } from './helpers.js';

if (window.NodeList && !NodeList.prototype.forEach) {
    NodeList.prototype.forEach = Array.prototype.forEach;
}

// on load spinner
document.onreadystatechange = function () {
    if (document.readyState !== "complete") {
        document.querySelector("body").style.visibility = "hidden";
        document.querySelector("#loader").style.visibility = "visible";
    } else {
        setTimeout(() => {
            document.querySelector("#loader").style.display = "none";
            document.querySelector("body").style.visibility = "visible";
        }, 100);
    }
};

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
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
    responsive: {
        // breakpoint from 0 up
        0: {
            items: 1,
        },
        // breakpoint from 480 up
        480: {
            items: 2,
        },
        // breakpoint from 768 up
        768: {
            items: 4,
        }
    }
});


log('osadsala ieasdsad');