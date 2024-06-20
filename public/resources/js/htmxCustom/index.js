import './_paginationSwap';
import './_dropdownSwap';
import './_bodyContent';

import { updateBodyDataPage } from './_bodyContent';

import { paginationResultsInContainer } from './_paginationSwap';

import { activePageMarker } from '../header/_headerActive';

import { productsModal } from '../modal/_productsModal';

import { bodyRefreshScriptTags } from './_bodyScripts';

import { owlCarouselFunctions } from '../owlFunctions';

import { navHeaderScroll } from '../header/_scrollHeader';
import { initializeDropdown } from './_dropdownSwap';


// document.addEventListener('htmx:afterSwap', (evt) => {});

// document.addEventListener('htmx:afterOnLoad', () => {});

// document.addEventListener('htmx:load', function (e) {});


document.addEventListener('htmx:afterSettle', (evt) => {
  updateBodyDataPage();

  activePageMarker();

  navHeaderScroll();

  paginationResultsInContainer(evt);

  bodyRefreshScriptTags(evt, ['[data-js="bootstrap"]']);

  productsModal();
    
  initializeDropdown();

  owlCarouselFunctions();

  if (evt.detail.trigger === 'history') {
    // Add your logic here to handle actions after settling due to history navigation
    console.log('User navigated back using browser history.');
  }
  
});