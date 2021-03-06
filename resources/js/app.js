import "@babel/polyfill";
// import helpers
import { qSelect, qSelectAll, gID, log } from './helpers.js';

if (window.NodeList && !NodeList.prototype.forEach) {
    NodeList.prototype.forEach = Array.prototype.forEach;
}

/* Sample function that returns boolean in case the browser is Internet Explorer*/
function isIE() {
    var ua = navigator.userAgent; /* MSIE used to detect old browsers and Trident used to newer ones*/
    var is_ie = ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1;
    return is_ie;
}
// url
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

// get elements with data-anima
const elements = document.querySelectorAll('[data-anima]');
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

if (!isIE()) {
    // on load spinner
    //------------- Loading animation start ---------- //
    (() => {
        let loader, hero, header, footer, nav, main, items;
        loader = document.querySelector("#loader");
        if (loader != null) {
            hero = document.querySelector("#hero");
            header = document.querySelector("#topNav");
            footer = document.querySelector("footer");
            nav = document.querySelector("nav");
            main = document.querySelector("main");
            items = [hero, header, footer, nav, main];
            document.onreadystatechange = function () {
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
        //     top: 2390,
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
} else {
    console.log('Baixe um browser mais atualizado...');
}