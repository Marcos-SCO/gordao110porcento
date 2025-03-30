function initTinyMce() {
    if (!tinymce) return;

    tinymce.init({
        selector: 'textarea',
        plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
        toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
        toolbar_mode: 'floating',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
    });
}

function reInitializeTinyMce() {
    setTimeout(() => {
        initTinyMce();
    }, 100);
}

function handleFormSubmit(e) {
    e.preventDefault();

    // Ensure TinyMCE content is saved back to the textarea before submitting
    tinymce?.triggerSave();

    // Submit the form after TinyMCE content is saved
    const form = e.target;
    form.submit();
}

function handleAllForms() {
    const form = document.querySelector('form');

    if (!form) return;

    const isTinyMCEElement = form.querySelector('#tinyMCE');
    if (!isTinyMCEElement) return;

    form.addEventListener('submit', handleFormSubmit);
}

function setupEventListeners() {
    // Re-initialize TinyMCE after HTMX updates the content
    document.body.addEventListener('htmx:afterSwap', reInitializeTinyMce);

    // Ensure the textarea value is updated from TinyMCE content before form submission
    handleAllForms(); // Handle all forms on the page
}

document.addEventListener('DOMContentLoaded', function () {
    initTinyMce();
    setupEventListeners();
});

export { initTinyMce };
