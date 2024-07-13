import { formSlugFieldHandler } from "../../helpers/dom/strings";

function categoriesSlugField() {
  const slugFieldForm = document.querySelector('[data-js="category-form"]');
  if (!slugFieldForm) return;

  formSlugFieldHandler('[data-slug-origin]', '[data-slug-receptor]');

}

document.addEventListener('DOMContentLoaded', categoriesSlugField);

document.addEventListener('htmx:afterSettle', categoriesSlugField);