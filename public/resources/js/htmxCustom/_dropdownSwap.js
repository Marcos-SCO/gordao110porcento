function initializeDropdown() {
  const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
  if (!dropdownToggles) return;

  const dropdownElementList = Array.from(dropdownToggles);

  dropdownElementList.map(function (dropdownToggleEl) {
    return new bootstrap.Dropdown(dropdownToggleEl);
  });
}

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

// Reinitialize dropdown after HTMX swap
document.addEventListener('htmx:afterSwap', function (e) {

  initializeDropdown();
  outsideClickCloseDropdown();
});