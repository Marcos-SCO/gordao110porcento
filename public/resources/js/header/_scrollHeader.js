function navHeaderScroll() {
  const navHeader = document.querySelector('[data-js="navHeader"]');
  if (!navHeader) return;

  document.addEventListener('scroll', () => {

    let pageYOffsetMoreThan300 = window.scrollY >= 400;

    if (pageYOffsetMoreThan300) navHeader.classList.add('fixed-top');

    if (!pageYOffsetMoreThan300) navHeader.classList.remove('fixed-top');

  });
}

// document.addEventListener('DOMContentLoaded', navHeaderScroll);
