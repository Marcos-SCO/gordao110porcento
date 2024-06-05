import scrollToTop from '../helpers/dom/scroll';

function updatePaginationContainer(previousUrl) {

  htmx.ajax('GET', previousUrl, {
    target: '[data-js="pagination-container"]',
    select: "[data-js='pagination-container']"
  });
}

document.addEventListener('htmx:afterSwap', function resultItensContainer(evt) {
  const eventIsResultContainer =
    evt.detail.target.matches('[data-js="itens-result-container"]');

  if (!eventIsResultContainer) return;

  const eventCurrentUrl = window.location.href;
  updatePaginationContainer(eventCurrentUrl);

  scrollToTop('[data-js="top-page-header"]');
});