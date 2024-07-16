import { formSlugFieldHandler } from "../../helpers/dom/strings";

function postsSlugField() {
  const slugFieldForm = document.querySelector('[data-js="posts-form"]');
  if (!slugFieldForm) return;

  formSlugFieldHandler('[data-slug-origin]', '[data-slug-receptor]');

}

document.addEventListener('DOMContentLoaded', postsSlugField);

document.addEventListener('htmx:afterSettle', postsSlugField);