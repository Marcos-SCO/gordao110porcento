function updateScripts(previousUrl, htmxReference, tagSelectorsArray) {
  if (!htmxReference) return;

  for (let scriptSelector of tagSelectorsArray) {

    const scriptItemExists = document.querySelector(scriptSelector);
    if (!scriptItemExists) continue;

    htmxReference.ajax('GET', previousUrl, {
      target: scriptSelector,
      select: scriptSelector,
      swap: 'outerHTML',
    });
  }
}

function bodyRefreshScriptTags(evt, scriptSelectorsArray) {
  const eventIsResultContainer =
    evt.detail.target.matches('body');

  if (!eventIsResultContainer) return;

  const eventCurrentUrl = window.location.href;

  updateScripts(eventCurrentUrl, window.htmx, scriptSelectorsArray);
}

export { bodyRefreshScriptTags, updateScripts };