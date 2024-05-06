function heroSlider() {

    /* HERO SLIDER START */
    // elements
    let quoteTitle, quote, hero, path, slide, prev, next, url, split, i;
    // page url
    url = window.location.href;

    // change with base path
    (url.includes('=')) ? url = 'http://localhost/projetos_pessoais/gordao110porcento' : '';

    // replace /home string
    url = url.replace('/home', '');

    // initial counter
    i = 0;
    // slides content
    let windowSize = window.innerWidth;
    let imgWidthPath = '';
    if (windowSize <= 400) {
        imgWidthPath = '_400';
    } else if (windowSize <= 700) {
        imgWidthPath = '_600';
    }

    slide = [
        ['pizzasRefris_template' + imgWidthPath + '.jpg', 'Gordão a 110%', 'O melhor restaurante e lanchonete da região'],
        ['lanches' + imgWidthPath + '.png', 'Os Melhores lanches', 'Aqui você encontra váriedade e lanches com o sabor imperdivél'],
        ['hamburguerBatataTomate_template' + imgWidthPath + '.png', 'Melhor menu', 'Vasto menu feito com igredientes frescos e de qualidade'],
        ['hamburguer_template' + imgWidthPath + '.png', 'Experimente nossas ofertas', 'Mataremos sua fome com a porcentagem acima, satisfação em 110%']
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
        setTimeout(() => {
            i -= 1;
            (i == -1) ? i = slide.length - 1 : i;
            intervalSet();
        }, 390);
    });

    next.addEventListener('click', () => {
        setTimeout(() => {
            i += 1;
            (i == slide.length) ? i = 0 : i;
            intervalSet();
        }, 390);
    });

    // select slider elements
    hero = document.querySelector('#hero');
    hero.style = 'display:block;opacity:1;';
    quoteTitle = document.querySelector('#quoteTitle');
    quote = document.querySelector('#quote');
    path = '/public/resources/img/slider/';
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
        (inc !== null) ? i += inc : i;
        // if counter is greater than slide elements reset value
        (i >= slide.length) ? i = 0 : i;
        // if index is provided than i recive index
        (index !== null) ? i = index : i;
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
