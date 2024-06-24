import { debounce } from "../helpers/debounce";

function navHeaderScroll() {
  const navHeader = document.querySelector('[data-js="navHeader"] [data-js="header-inner-container"]');
  
  if (!navHeader) return;

  let lastScrollY = window.scrollY;

  const scrollHandler = debounce(() => {

    let pageYOffsetMoreThan = window.scrollY >= 400;

    let currentScrollY = window.scrollY;

    // if (pageYOffsetMoreThan || (currentScrollY < lastScrollY)) navHeader.classList.add('fixed-top');
    if ((currentScrollY < lastScrollY)) {
      navHeader.classList.add('fixed-top');
      navHeader.classList.remove('hide');
    }

    // if (!pageYOffsetMoreThan || (currentScrollY > lastScrollY)) navHeader.classList.remove('fixed-top');
    if ((currentScrollY > lastScrollY)) {
      navHeader.classList.remove('fixed-top');
      navHeader.classList.add('hide');
    }

    lastScrollY = currentScrollY;

    console.log('iaaa')

  }, 100);

  document.addEventListener('scroll', scrollHandler, { passive: true });

}

document.addEventListener('DOMContentLoaded', navHeaderScroll);

export { navHeaderScroll };