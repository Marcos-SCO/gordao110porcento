function navHeaderScroll() {
  const navHeader = document.querySelector('[data-js="navHeader"] [data-js="header-inner-container"]');
  if (!navHeader) return;

  let lastScrollY = window.scrollY;

  document.addEventListener('scroll', () => {

    let pageYOffsetMoreThan = window.scrollY >= 400;

    let currentScrollY = window.scrollY;

    // if (pageYOffsetMoreThan || (currentScrollY < lastScrollY)) navHeader.classList.add('fixed-top');
    if ((currentScrollY < lastScrollY)) navHeader.classList.add('fixed-top');

    // if (!pageYOffsetMoreThan || (currentScrollY > lastScrollY)) navHeader.classList.remove('fixed-top');
    if ((currentScrollY > lastScrollY)) navHeader.classList.remove('fixed-top');

    lastScrollY = currentScrollY;

  });
}

document.addEventListener('DOMContentLoaded', navHeaderScroll);

export { navHeaderScroll };