document.addEventListener('htmx:historyCacheMiss', function (evt) {
  // htmx.config.cache = "none";
  // htmx.config.historyEnabled = false;
  
  window.htmx.ajax('GET',  window.location.href, {
    target: 'body',
    select: 'body > *',
    swap: 'innerHTML',
  });
});