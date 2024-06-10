function updateBodyDataPage() {
  const footerDataPage = document.querySelector('footer[data-page]');
  if (!footerDataPage) return;

  const attributeValue = footerDataPage.getAttribute('data-page');

  document.body.setAttribute('data-page', attributeValue);
}

// document.addEventListener('htmx:afterSettle', updateBodyDataPage);

export { updateBodyDataPage };