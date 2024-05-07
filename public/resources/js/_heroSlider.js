function iCounter() {
    let i = 0;

    const decrementCounter = () => (i > 0) ? i -= 1 : 0;
    const incrementCounter = () => i += 1;
    const setCounter = (num) => i = num;
    const getCounter = () => i;

    return [incrementCounter, decrementCounter, setCounter, getCounter];
}

const [incrementCounter, decrementCounter, setCounter, getCounter] = iCounter();

// intervals
function sliderInterVal() {
    let interval = setInterval(() => moveSlide(), 4800);

    const getSliderInterval = () => interval;
    const setSliderInterval = (intervalParam) => interval = intervalParam;
    const clearSliderInterval = () => clearTimeout(interval);

    return [getSliderInterval, setSliderInterval, clearSliderInterval];
}

const [getSliderInterval, setSliderInterval, clearSliderInterval] = sliderInterVal();

// ---------------------------- ----------------------------

function getSliderItens() {
    const windowSize = window.innerWidth;
    const imgWidthPath = (windowSize <= 400) ? '_400' : '_600';

    return [
        {
            img: 'pizzasRefris_template' + imgWidthPath + '.jpg',
            title: 'Gordão a 110%',
            quote: 'O melhor restaurante e lanchonete da região'
        },
        {
            img: 'lanches' + imgWidthPath + '.png',
            title: 'Os Melhores lanches',
            quote: 'Aqui você encontra váriedade e lanches com o sabor imperdivél'
        },
        {
            img: 'hamburguerBatataTomate_template' + imgWidthPath + '.png',
            title: 'Melhor menu',
            quote: 'Vasto menu feito com ingredientes frescos e de qualidade'
        },
        {
            img: 'hamburguer_template' + imgWidthPath + '.png',
            title: 'Experimente nossas ofertas',
            quote: 'Mataremos sua fome com a porcentagem acima, satisfação em 110%'
        }
    ];
}

function preloadSliderImages(imageUrls, path = '') {
    const pathUrl = path;

    imageUrls.forEach(function (imgName) {
        const img = new Image();
        img.src = pathUrl.imgName;
    });
}

function sliderDomChangeElements(hero, quoteTitle, quote, heroCounterItem, currentSlideItem) {
    const baseUrl = document.querySelector('[data-base-url]')?.getAttribute('data-base-url');

    if (!baseUrl) return;

    const path = baseUrl + '/public/resources/img/slider/';

    hero.style =
        "transition: all .5s; background-image:url(" + path + currentSlideItem['img'] + ")";

    hero.backgroundImage = "url(" + path + currentSlideItem['img'] + ")";

    quoteTitle.innerText = currentSlideItem['title'];

    quote.style = 'transition:all ease-in-out .5s; transition-delay: .5s;';
    quote.innerText = currentSlideItem['quote'];

    // remove previous active slider item
    heroCounterItem.forEach(item => item.classList.remove('active'));

    heroCounterItem[getCounter()].classList.add('active');
}

// function to move sliders
function moveSlide(index = null, incrementSliderCount = true) {

    const slide = getSliderItens();
    const sliderLength = slide.length;

    const hero = document.querySelector('[data-js="heroSlider"]');
    if (!hero) return;

    hero.style = 'display:block;opacity:1;';

    const quoteTitle = hero.querySelector('[data-js="quoteTitle"]');

    const quote = hero.querySelector('[data-js="quote"]');

    const heroCounterItem = hero.querySelectorAll('[data-js="heroCounterItem"]');

    // if index is provided than i receive index
    if (index !== null) setCounter(index);

    if (incrementSliderCount && index == null) incrementCounter();

    // if counter is greater than slide elements reset value
    if (getCounter() >= (sliderLength)) {
        setCounter(0);
    }

    const currentSlideItem = slide[getCounter()];

    if (!currentSlideItem) return;

    sliderDomChangeElements(hero, quoteTitle, quote, heroCounterItem, currentSlideItem);
}

function changeSliderInterval(index = null, incrementSliderCount = null) {
    clearSliderInterval();
    moveSlide(index, incrementSliderCount);

    setSliderInterval(setInterval(() => moveSlide(), 4800));
}

function sliderClickControls() {

    // prev next buttons
    const prev = document.querySelector('#prev');
    const next = document.querySelector('#next');

    if (!prev || !next) return;

    const sliderLength = getSliderItens().length;

    prev.addEventListener('click', () => {

        clearSliderInterval();

        const isCounterZero = getCounter() == 0;

        setTimeout(() => {

            if (!isCounterZero) decrementCounter();

            if (isCounterZero) setCounter(sliderLength - 1);

            changeSliderInterval(null, null);
        }, 390);
    });

    next.addEventListener('click', () => {

        clearSliderInterval();

        setTimeout(() => {

            const isCounterGreaterThanSlideLength = getCounter() > sliderLength;

            if (!isCounterGreaterThanSlideLength) incrementCounter();

            if (isCounterGreaterThanSlideLength) setCounter(0);

            changeSliderInterval(null, null);
        }, 390);
    });
}

function heroSlider() {

    const baseUrl = document.querySelector('[data-base-url]')
        ?.getAttribute('data-base-url');

    if (!baseUrl) return;

    const path = baseUrl + '/public/resources/img/slider/';

    const slide = getSliderItens();

    const sliderImgs = slide.filter(img => img);
    preloadSliderImages(sliderImgs, path);

    const currentSlideItem = slide?.[getCounter()];

    if (!currentSlideItem) return;

    sliderClickControls();

    // select slider elements
    const hero = document.querySelector('[data-js="heroSlider"]');
    hero.style = 'display:block;opacity:1;';

    if (!hero) return;

    const quoteTitle = hero.querySelector('[data-js="quoteTitle"]');

    const quote = hero.querySelector('[data-js="quote"]');

    // Hero ul slider selection
    const heroCounter = hero.querySelector('[data-js="heroCounter"]');

    for (let item in slide) {

        const liItem = document.createElement('li');
        liItem.className = `heroCounterItem`;
        liItem.setAttribute('data-js', 'heroCounterItem');

        heroCounter.appendChild(liItem);
        hero.appendChild(heroCounter);
    }

    const heroCounterItem = document.querySelectorAll('[data-js="heroCounterItem"]');

    sliderDomChangeElements(hero, quoteTitle, quote, heroCounterItem, currentSlideItem);

    heroCounterItem[getCounter()].classList.add('active');

    for (let slideItem in slide) {

        heroCounterItem[slideItem].addEventListener('click', function (slideItem) {

            clearSliderInterval();

            moveSlide(+slideItem);

            setSliderInterval(setInterval(() => moveSlide(), 4800));

        }.bind(null, slideItem));
    }
    // end ul slider selection
}



addEventListener('DOMContentLoaded', heroSlider);