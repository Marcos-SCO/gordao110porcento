function stringSlugFormat(slug) {
  // Convert the string to lowercase
  let slugToLower = slug.toLowerCase();

  // Replace non-letter or digits with hyphens
  let string = slugToLower.replace(/[^a-z0-9-]/g, '-');

  // Replace multiple hyphens with a single hyphen
  string = string.replace(/-+/g, '-');

  // Trim hyphens from the beginning and end of the string
  string = string.replace(/^-|-$/g, '');

  return string;
}

function formSlugFieldHandler(slugFieldOrigenSelector, slugValueReceptorSelector) {

  const slugOrigen =
    document.querySelector(slugFieldOrigenSelector);

  const slugReceptor =
    document.querySelector(slugValueReceptorSelector);

  if (!slugOrigen || !slugReceptor) return;

  slugOrigen.addEventListener('keyup', (e) => {
    const slugOrigenValue = e.target.value;

    if (!slugOrigenValue) return;

    slugReceptor.value = stringSlugFormat(slugOrigenValue);
  });
}

export { stringSlugFormat, formSlugFieldHandler };