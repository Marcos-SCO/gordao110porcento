function activePageMarker() {
  const dataPage = document.querySelector('[data-page]');
  if (!dataPage) return;

  const pageAttribute = dataPage.getAttribute('data-page');

  const dataActivePage = document.querySelector(`[data-active-page="${pageAttribute}"]`);

  if (!dataActivePage) return;

  dataActivePage.classList.add('active');

}

document.addEventListener('DOMContentLoaded', activePageMarker);

// document.addEventListener('htmx:afterSettle', activePageMarker);

export { activePageMarker };