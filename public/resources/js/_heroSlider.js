import iCounter from './helpers/counter';
import centralizedInterval from './helpers/interval';

const { incrementCounter, decrementCounter, setCounter, getCounter } = iCounter();

const { getInterval, changeIntervalValue, clearInternalInterval } = centralizedInterval(() => moveHeroSlider(), 4800);

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

function heroSliderDomChangeElements(currentSlideItem) {
    const baseUrl = document.querySelector('[data-base-url]')?.getAttribute('data-base-url');

    if (!baseUrl) return;

    const path = baseUrl + '/public/resources/img/slider/';

    // select slider elements
    const hero = document.querySelector('[data-js="heroSlider"]');
    if (!hero) return;

    const quoteTitle = hero.querySelector('[data-js="quoteTitle"]');
    const quote = hero.querySelector('[data-js="quote"]');

    hero.style = 'display:block;opacity:1;';

    hero.style =
        "transition: all .5s; background-image:url(" + path + currentSlideItem['img'] + ")";

    hero.backgroundImage = "url(" + path + currentSlideItem['img'] + ")";

    quoteTitle.innerText = currentSlideItem['title'];

    quote.style = 'transition:all ease-in-out .5s; transition-delay: .5s;';
    quote.innerText = currentSlideItem['quote'];

    const heroCounterItens =
        document.querySelectorAll('[data-js="heroCounterItem"]');

    if (!heroCounterItens) return;

    // remove previous active slider item
    heroCounterItens.forEach(item => item.classList.remove('active'));

    heroCounterItens[getCounter()]?.classList.add('active');
}

// function to move sliders
function moveHeroSlider(index = null, incrementSliderCount = true) {

    const sliderObj = getSliderItens();
    const sliderLength = sliderObj.length;

    const hero = document.querySelector('[data-js="heroSlider"]');
    if (!hero) return;

    hero.style = 'display:block;opacity:1;';

    // if index is provided than i receive index
    if (index !== null) setCounter(index);

    if (incrementSliderCount && index == null) incrementCounter();

    // if counter is greater than slide elements reset value
    if (getCounter() >= (sliderLength)) {
        setCounter(0);
    }

    const currentSlideItem = sliderObj[getCounter()];

    if (!currentSlideItem) return;

    heroSliderDomChangeElements(currentSlideItem);
}

function changeSliderInterval(index = null, incrementSliderCount = null) {
    clearInternalInterval();
    moveHeroSlider(index, incrementSliderCount);

    changeIntervalValue(setInterval(() => moveHeroSlider(), 4800));
}

function sliderClickControls() {

    // prev next buttons
    const prev = document.querySelector('#prev');
    const next = document.querySelector('#next');

    if (!prev || !next) return;

    const sliderLength = getSliderItens().length;

    prev.addEventListener('click', () => {

        clearInternalInterval();

        const isCounterZero = getCounter() == 0;

        setTimeout(() => {

            if (!isCounterZero) decrementCounter();

            if (isCounterZero) setCounter(sliderLength - 1);

            changeSliderInterval(null, null);
        }, 390);
    });

    next.addEventListener('click', () => {

        clearInternalInterval();

        setTimeout(() => {

            const isCounterGreaterThanSlideLength = getCounter() > sliderLength;

            if (!isCounterGreaterThanSlideLength) incrementCounter();

            if (isCounterGreaterThanSlideLength) setCounter(0);

            changeSliderInterval(null, null);
        }, 390);
    });
}

function createSliderHeroBars(sliderObj) {
    const hero = document.querySelector('[data-js="heroSlider"]');
    if (!hero) return;

    const heroCounter = hero.querySelector('[data-js="heroCounter"]');
    if (!heroCounter) return;

    if (!sliderObj) return;

    Array.from(sliderObj).forEach(() => {
        const liItem = document.createElement('li');
        liItem.className = `heroCounterItem`;
        liItem.setAttribute('data-js', 'heroCounterItem');

        heroCounter.appendChild(liItem);
        hero.appendChild(heroCounter);
    });
}

function heroBarsClick() {
    const hero = document.querySelector('[data-js="heroSlider"]');
    if (!hero) return;

    hero.addEventListener('click', (e) => {
        const heroCounterItem = e.target.closest('[data-js="heroCounterItem"]');
        if (!heroCounterItem) return;

        const childElements = Array.from(heroCounterItem.parentElement?.querySelectorAll('[data-js="heroCounterItem"]'));

        const elementIndex = childElements?.indexOf(heroCounterItem);

        if (elementIndex == null) return;

        clearInternalInterval();

        moveHeroSlider(+elementIndex);

        changeIntervalValue(setInterval(() => moveHeroSlider(), 4800));

    });
}

function heroSlider() {

    const baseUrl = document.querySelector('[data-base-url]')
        ?.getAttribute('data-base-url');

    if (!baseUrl) return;

    const path = baseUrl + '/public/resources/img/slider/';

    const sliderObj = getSliderItens();

    const sliderImgs = sliderObj.filter(img => img);
    preloadSliderImages(sliderImgs, path);

    const currentSlideItem = sliderObj?.[getCounter()];
    if (!currentSlideItem) return;

    sliderClickControls();

    createSliderHeroBars(sliderObj);

    heroSliderDomChangeElements(currentSlideItem);

    heroBarsClick();
}

addEventListener('DOMContentLoaded', heroSlider);