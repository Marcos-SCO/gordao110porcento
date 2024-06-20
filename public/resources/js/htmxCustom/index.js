import './_paginationSwap';
import './_dropdownSwap';
import './_bodyContent';

import { updateBodyDataPage } from './_bodyContent';

import { paginationResultsInContainer } from './_paginationSwap';

import { activePageMarker } from '../header/_headerActive';

import { productsModal } from '../modal/_productsModal';

import { bodyRefreshScriptTags } from './_bodyScripts';

import { owlCarouselFunctions } from '../owlFunctions';


// document.addEventListener('htmx:afterSwap', (evt) => {});

// document.addEventListener('htmx:afterOnLoad', () => {});

// document.addEventListener('htmx:load', function (e) {});


document.addEventListener('htmx:afterSettle', (evt) => {
  updateBodyDataPage();

  activePageMarker();

  paginationResultsInContainer(evt);

  productsModal();

  bodyRefreshScriptTags(evt, ['[data-js="bootstrap"]']);

  owlCarouselFunctions();

});