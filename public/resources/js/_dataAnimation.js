function dataAnimaInit() {

  const dataAnimaElements = document.querySelectorAll("[data-anima]");

  if (!dataAnimaElements) return;

  window.addEventListener("scroll", function () {

    let scrollYDifference = window.scrollY + 3 * window.innerHeight / 4;

    dataAnimaElements.forEach(function (dataAnimaItem) {
      scrollYDifference > dataAnimaItem.offsetTop
        ? dataAnimaItem.classList.add("animation")
        : dataAnimaItem.classList.remove("animation")
    });
  });
}

document.addEventListener('DOMContentLoaded', dataAnimaInit);
document.addEventListener('htmx:afterSwap', dataAnimaInit);