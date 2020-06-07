import "@babel/polyfill";
// import helpers
import { qSelect, qSelectAll, gID, log } from './helpers.js';

if (window.NodeList && !NodeList.prototype.forEach) {
    NodeList.prototype.forEach = Array.prototype.forEach;
}

let url = window.location.href;

// Dates
let date = new Date();
let currentYear = date.getFullYear();
// Home active years
let activeYears = document.querySelectorAll('.activeYears');
// Foter date 
let footerDate = document.getElementById('footerDate');
footerDate.innerText = currentYear;
let years = currentYear - 1997;
if (activeYears != null) {
    for (let activeYear of activeYears) {
        activeYear.innerText = years;
    }
}

// on load spinner
let spinnerUlr = window.location.href.split('/');

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
        },
        // breakpoint from 1000 up
        1161: {
            items: 5,
        }
    }
});

/* HERO SLIDER START */
(() => {
    // elements
    let quoteTitle, quote, hero, path, slide, prev, next, url, split, i;
    // page url
    url = window.location.href;
    // split url to get method
    split = window.location.href.split('/');
    if ((split[5] == '' || split[5] == 'home') && split[5] !== 'index') {
        // replace /home string
        url = url.replace('/home', '');
        // initial counter
        i = 0;
        // slides content
        slide = [
            ['pizzasRefris_template.jpg', 'Gordão a 110%', 'O melhor restaurante e lanchonete da região'],
            ['batataGarfoHamburguer.jpg', 'Os Melhores lanches', 'Aqui você encontra váriedade e lanches com o sabor imperdivél'],
            ['hamburguerBatataTomate_template.png', 'Melhor menu', 'Vasto menu feito com igredientes frescos e de qualidade'],
            ['hamburguer_template.png', 'Experimente nossas ofertas', 'Mataremos sua fome com a porcentagem acima, satisfação em 110%']
        ];
        // intervals
        let interval = setInterval(() => moveSlide(1), 7000);
        function intervalSet() {
            clearTimeout(interval);
            moveSlide();
            interval = setInterval(() => moveSlide(1), 7000);
        }
        // prev next buttons
        prev = document.querySelector('#prev');
        next = document.querySelector('#next');
        prev.addEventListener('click', () => {
            i -= 1;
            (i == -1) ? i = slide.length - 1 : i;
            intervalSet();
        });
        next.addEventListener('click', () => {
            i += 1;
            (i == slide.length) ? i = 0 : i;
            intervalSet();
        });

        // select slider elements
        hero = document.querySelector('#hero');
        hero.style = 'display:block;opacity:1;';
        quoteTitle = document.querySelector('#quoteTitle');
        quote = document.querySelector('#quote');
        path = '/public/img/slider/';
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
                clearTimeout(interval);
                // get the i in string and transform into int with + sign.
                // move slide with inc null and i interger
                moveSlide(null, +i);
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

 //------------- Loading animation start ---------- //
 (() => {
    let loader, hero, header, footer, nav, main, items;
    loader = document.querySelector("#loader");
    hero = document.querySelector("#hero");
    header = document.querySelector("#topNav");
    footer = document.querySelector("footer");
    nav = document.querySelector("nav");
    main = document.querySelector("main");
    items = [hero, header, footer, nav, main];
    document.onreadystatechange = function() {
        if (document.readyState !== "complete") {
            for (let item of items) {
                if (item == null) {
                    continue;
                }
                item.style = "opacity:0;visibility:none;";
            }
            loader.style = "visibility:visible;display:block;opacity:1;z-index:999999999999;position:absolute";
        } else {
            for (let item of items) {
                if (item == null) {
                    continue;
                }
                item.style = "opacity:1;visibility:visible;";
            }
            loader.style.display = "none";
        }
    }
})();
//------------- Loading animation end ---------- //

//------------- Top btns start ---------- //
(() => {
    //Get the button:
    let body = document.querySelector('body');
    let whats = document.getElementById('whats');
    let mybutton = document.getElementById("topBtn");
    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function () {
        scrollFunction();
        console.log('io');
    };
    // on body click don't display btn
    body.addEventListener('click', () => mybutton.style = 'opacity:0;transition:.5s');

    function scrollFunction() {
        (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) ? mybutton.style = "display:block;opacity:1" : mybutton.style = "display:block;opacity:0;transition:.5s";
        (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) ? whats.style = 'display:none;opacity:0;transition:.5s;z-index:-1' : whats.style = 'display:block;opacity:1;transition:.5s';
    }
    // When the user clicks on the button, scroll to the top of the document
    mybutton.addEventListener('click', function topFunction() {
        let currentYOffset = self.pageYOffset;
        let initYOffset = currentYOffset;
        var intervalId = setInterval(function () {
            currentYOffset -= initYOffset * 0.05;
            document.body.scrollTop = currentYOffset;
            document.documentElement.scrollTop = currentYOffset;
            document.body.scrollTop = currentYOffset; // For Chrome, Firefox, IE and Opera
            if (self.pageYOffset == 0) {
                clearInterval(intervalId);
            }
        }, 30);
    });
    // Scroll to specific values
    // scrollTo is the same
    // window.scroll({
    //     top: 2500,
    //     left: 0,
    //     behavior: 'smooth'
    // });
    // Scroll certain amounts from current position 
    // window.scrollBy({
    //     top: 100, // could be negative value
    //     left: 0,
    //     behavior: 'smooth'
    // });
})();
//------------- Top btns end ---------- //