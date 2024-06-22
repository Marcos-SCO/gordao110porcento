window.htmx = htmx;

import './_htmxCache';

import { updateBodyDataPage } from './_bodyContent';

import { paginationResultsInContainer } from './_paginationSwap';

import { activePageMarker } from '../header/_headerActive';

import { productsModal } from '../modal/_productsModal';

import { bodyRefreshScriptTags } from './_bodyScripts';

import { owlCarouselFunctions } from '../owlFunctions';

import { navHeaderScroll } from '../header/_scrollHeader';

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

  owlCarouselFunctions();

});