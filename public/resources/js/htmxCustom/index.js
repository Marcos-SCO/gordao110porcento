import './_paginationSwap';
import './_dropdownSwap';
import './_bodyContent';

import { updateBodyDataPage } from './_bodyContent';

import { initializeDropdown } from './_dropdownSwap';

import { paginationResultsInContainer } from './_paginationSwap';

import owlCarouselFunctions from '../owlFunctions';

import { activePageMarker } from '../header/_headerActive';

import { productsModal } from '../modal/_productsModal';


// document.addEventListener('htmx:afterSwap', (evt) => {});

// document.addEventListener('htmx:afterOnLoad', () => {});

// document.addEventListener('htmx:load', function (e) {});

document.addEventListener('htmx:afterSettle', (evt) => {
  updateBodyDataPage();
  
  activePageMarker();
  productsModal();

  initializeDropdown();

  owlCarouselFunctions();

  paginationResultsInContainer(evt);
  
});