// Htmtx
// import 'htmx.org';
import htmx from 'htmx.org';
window.htmx = htmx;

// Owl functions
import './owlFunctions';

import './modal/index';

// Loader animation
// import './_loaderAnimation';

// import './_headerTop';
import './_heroSlider';
import './_dataAnimation';

function scrollToTop(selector) {
  const element = document.querySelector(selector);
  if (element) {
    console.log('Scrolling to:', element);
    element.scrollIntoView({ behavior: 'smooth' });
  } else {
    console.log('Element not found for selector:', selector);
  }
}

function updatePaginationContainer(previousUrl) {
  // const baseUrl = document.querySelector('[data-base-url]').getAttribute('data-base-url');
  
  htmx.ajax('GET', previousUrl, {
    target: '[data-js="pagination-container"]',
    // swap: 'outerHTML',
    select:"[data-js='pagination-container']"
  });
}

document.addEventListener('htmx:afterSwap', function (evt) {
  // Check if the event target is the items result container
  if (evt.detail.target.matches('[data-js="itens-result-container"]')) {
    // Perform your update actions here
    // For example, updating the pagination container

    const previousUrl = window.location.href;
    updatePaginationContainer(previousUrl);

    scrollToTop('.productDropdown');
  }
});

