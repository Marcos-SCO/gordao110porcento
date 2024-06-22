window.htmx = htmx;

import './_htmxCache';

import { updateBodyDataPage } from './_bodyContent';

import { paginationResultsInContainer } from './_paginationSwap';

import { activePageMarker } from '../header/_headerActive';

import { productsModal } from '../modal/_productsModal';

import { bodyRefreshScriptTags } from './_bodyScripts';

import { owlCarouselFunctions } from '../owlFunctions';

import { navHeaderScroll } from '../header/_scrollHeader';
import { heroSlider } from '../_heroSlider';

// document.addEventListener('htmx:afterSwap', (evt) => {});

// document.addEventListener('htmx:afterOnLoad', () => {});

// document.addEventListener('htmx:load', function (e) {});

// Refresh function after HTMX settle
document.addEventListener('htmx:afterSettle', (evt) => {
  updateBodyDataPage();

  activePageMarker();

  navHeaderScroll();

  heroSlider();

  paginationResultsInContainer(evt);

  bodyRefreshScriptTags(evt, ['[data-js="bootstrap"]']);

  productsModal();

  owlCarouselFunctions();

});