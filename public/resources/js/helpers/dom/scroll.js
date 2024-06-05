function scrollToTop(selector) {
  const element = document.querySelector(selector);
  if (!element) return;

  element.scrollIntoView({ behavior: 'smooth' });
}

export default scrollToTop;