import "@babel/polyfill";
// import helpers
import { qSelect, qSelectAll, gID, log } from './helpers.js';

if (window.NodeList && !NodeList.prototype.forEach) {
    NodeList.prototype.forEach = Array.prototype.forEach;
}

/* HERO SLIDER START */
(() => {
    // elements
    let quoteTitle, quote, hero, path, slide, prev, next, url, split, i;
    // page url
    url = window.location.href;
    // split url to get method
    split = window.location.href.split('/');
    if (split[5] == '' || split[5] == 'home') {
        // replace /home string
        url = url.replace('/home', '');
        // initial counter
        i = 0;
        // intervals
        let interval = setInterval(() => moveSlide(1), 7000);
        function intervalSet() {
            clearTimeout(interval);
            moveSlide();
            interval = setInterval(() => moveSlide(1), 7000);
        }
        // slides content
        slide = [
            ['pizzasRefris_template.png', 'Gordão a 110%', 'A melhor lanchonete da região'],
            ['lanchesTemplate.png', 'Os Melhores lanches', 'Aqui você encontra váriedade e lanches com o sabor imperdivél'],
            ['hamburguerBatataTomate_template.png', 'Melhor menu', 'Vasto menu feito com igredientes de qualidade'],
            ['hamburguer_template.png', 'Experimente nossas ofertas', 'Mataremos sua fome com a porcentagem acima, satisfação em 110%']
        ];
        // prev next buttons
        prev = document.querySelector('#prev');
        next = document.querySelector('#next');
        prev.addEventListener('click', () => {
            i -= 1;
            (i == -1) ? i = slide.length - 1 : i;
            intervalSet();
        });
        next.addEventListener('click', () => {
            (i >= slide.length) ? i = slide.length : i += 1;
            intervalSet();
        });
        // select slider elements
        hero = document.querySelector('#hero');
        quoteTitle = document.querySelector('#quoteTitle');
        quote = document.querySelector('#quote');
        path = '/public/img/template/';
        // initial elements with counter in 0
        quoteTitle.innerText = slide[i][1];
        quote.innerText = slide[i][2];
        hero.style = "transition: all ease-in-out .5s; background-image:url(" + url + path + slide[i][0] + ")";
        hero.backgroundImage = "url(" + url + path + slide[i][0] + ")";
        
        // Hero ul slider selection
        let heroCounter = document.querySelector('#heroCounter');
        for (let item in slide) {
            item = document.createElement('li');
            item.className = `heroCounterItem`;
            heroCounter.appendChild(item);
            hero.appendChild(heroCounter);
        }
        let heroCounterItem = document.querySelectorAll('.heroCounterItem');
        heroCounterItem[i].classList.add('active');
        for (let i in slide) {
            heroCounterItem[i].addEventListener('click', function (i) {
                console.log(i);
                clearTimeout(interval);
                moveSlide(null, i);
            }.bind(null, i));
        }
        // end ul slider selection

        // function to move sliders
        function moveSlide(inc = null, index = null) {
            // if inc, than counter recive +1
            (inc != null) ? i += inc : i;
            // if counter is greater than slide elements reset value
            (i >= slide.length) ? i = 0 : i;
            // if index is provided than i recive index
            (index != null) ? i = index : i;
            // set elements again with i counter value
            hero.style = "transition: all .5s; background-image:url(" + url + path + slide[i][0] + ")";
            hero.backgroundImage = "url(" + url + path + slide[i][0] + ")";
            quoteTitle.innerText = slide[i][1];
            quote.style = 'transition:all ease-in-out .5s;transition-delay: .5s;';
            quote.innerText = slide[i][2];
            
            // remove and class to active slider item
            heroCounterItem.forEach(item => {
                item.classList.remove('active');
            });
            heroCounterItem[i].classList.add('active');
        }
    }
})();
/* HERO SLIDER END */

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
// end get elements data-anima

// owl carousel
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