function outsideClickCloseDropdown() {
  // Close the dropdown when clicking outside
  document.addEventListener('click', function (e) {

    const dropdown = document.querySelector('.dropdown-menu.show');
    if (!dropdown) return;

    const targetContainsDropdown = dropdown.parentElement.contains(e.target);

    if (targetContainsDropdown) return;

    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    if (!dropdownToggles) return;

    dropdownToggles.forEach(function (dropdownToggleEl) {
      dropdownToggleEl.setAttribute('aria-expanded', 'false');
    });

    dropdown.classList.remove('show');

  });

}

function toggleHeaderNavbar() {
  const mainHeader = document.querySelector('.main-header');
  if (!mainHeader) return;

  const headerNavbarToggle = mainHeader.querySelector('.navbar-toggler');
  if (!headerNavbarToggle) return;

  const navbarColapse = mainHeader.querySelector('[data-js="navbar-collapse"]');
  // console.log(navbarColapse, 'collapese')
  if (!navbarColapse) return;

  navbarColapse.classList.toggle('disable-display');

  headerNavbarToggle.addEventListener('click', () => {
    navbarColapse.classList.toggle('disable-display');
  });
}

function initializeDropdown() {
  const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
  if (!dropdownToggles) return;

  // Check if there are any dropdown toggles found
  if (!dropdownToggles || dropdownToggles.length === 0) return;

  // console.log('toggle init...')

  // const dropdownElementList = Array.from(dropdownToggles);

  dropdownToggles.forEach(function (dropdownToggleEl) {
    // Create a new dropdown instance
    return new bootstrap.Dropdown(dropdownToggleEl);
  });

  outsideClickCloseDropdown();

  toggleHeaderNavbar();
}

// Reinitialize dropdown after HTMX swap
// afterSwap  | afterSettle

// document.addEventListener('DOMContentLoaded', initializeDropdown);

export { initializeDropdown };