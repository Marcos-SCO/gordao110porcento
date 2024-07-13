function getAccentMap() {
  return {
    'À': 'A', 'Á': 'A', 'Â': 'A', 'Ã': 'A', 'Ä': 'A', 'Å': 'A',
    'à': 'a', 'á': 'a', 'â': 'a', 'ã': 'a', 'ä': 'a', 'å': 'a',
    'È': 'E', 'É': 'E', 'Ê': 'E', 'Ë': 'E',
    'è': 'e', 'é': 'e', 'ê': 'e', 'ë': 'e',
    'Ì': 'I', 'Í': 'I', 'Î': 'I', 'Ï': 'I',
    'ì': 'i', 'í': 'i', 'î': 'i', 'ï': 'i',
    'Ò': 'O', 'Ó': 'O', 'Ô': 'O', 'Õ': 'O', 'Ö': 'O',
    'ò': 'o', 'ó': 'o', 'ô': 'o', 'õ': 'o', 'ö': 'o',
    'Ù': 'U', 'Ú': 'U', 'Û': 'U', 'Ü': 'U',
    'ù': 'u', 'ú': 'u', 'û': 'u', 'ü': 'u',
    'Ç': 'C', 'ç': 'c',
    'Ñ': 'N', 'ñ': 'n',
    'Ý': 'Y', 'ý': 'y', 'ÿ': 'y',
    'Æ': 'AE', 'æ': 'ae', 'Ø': 'O', 'ø': 'o', 'Å': 'A', 'å': 'a'
  };
}

function stringSlugFormat(slug) {
  // Map accented characters to ASCII equivalents
  const accentMap = getAccentMap();

  // Replace accented characters
  slug = slug.split('').map(char => accentMap[char] || char).join('');

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