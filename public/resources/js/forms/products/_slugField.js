import { formSlugFieldHandler } from "../../helpers/dom/strings";

function productSlugField() {
  const slugFieldForm = document.querySelector('[data-js="product-form"]');
  if (!slugFieldForm) return;

  formSlugFieldHandler('[data-slug-origin]', '[data-slug-receptor]');

}

document.addEventListener('DOMContentLoaded', productSlugField);

document.addEventListener('htmx:afterSettle', productSlugField);