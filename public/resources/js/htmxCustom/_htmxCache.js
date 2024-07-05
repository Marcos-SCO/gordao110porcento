import iCounter from "../helpers/counter";

const { incrementCounter, getCounter } = iCounter();

const { incrementCounter: homeIncrement, getCounter: homeCounter } = iCounter();

function reloadDocument(time = 500) {
  console.clear();
  console.warn('Reloading page after swap error...');

  setTimeout(() => {
    console.warn('Page reload...');

    window.location.reload();
  }, time)
}

function reloadHomeIfMaxCounter(evt) {
  const isHomePage = evt?.target
    ?.getAttribute('data-page') == 'home';

  if (!isHomePage) return;

  homeIncrement();

  if (homeCounter() < 3) return;

  console.log(`Reload count for body: ${homeCounter()}`);

  reloadDocument(100);
}

function reloadBodyContent() {
  incrementCounter();

  if (getCounter() > 3) {
    console.log(`Reload count: ${getCounter()}`);

    reloadDocument(100);

    return;
  }

  window.htmx.ajax('GET', window.location.href, {
    target: 'body',
    select: 'body > *',
    swap: 'outerHTML',
  });
}

document.addEventListener('htmx:historyCacheMiss', function (evt) {
  // htmx.config.cache = "none";
  // htmx.config.historyEnabled = false;

  reloadBodyContent();
});

document.addEventListener('htmx:swapError', function (evt) {
  reloadDocument();
});

document.addEventListener('htmx:load', function (evt) {
  // console.log(evt);
  reloadHomeIfMaxCounter(evt);
});