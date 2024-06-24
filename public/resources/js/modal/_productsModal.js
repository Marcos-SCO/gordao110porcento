function productsModal() {

  const modalItemContainers = document.querySelectorAll('[modal-item-container]');

  if (!modalItemContainers) return;

  const baseUrl = document.querySelector('footer')?.getAttribute('data-page');

  const navHeader = document.querySelector('[data-js="navHeader"] [data-js="header-inner-container"]');

  Array.from(modalItemContainers).forEach(modalItemContainer => {

    modalItemContainer.addEventListener('click', e => {

      const target = e.target;
      const currentElement = e.currentTarget;

      const targetHasModalItem = target.closest('[modal-item]');

      if (!targetHasModalItem) return;


      if (navHeader) navHeader.classList.remove('fixed-top');

      const item = targetHasModalItem;

      // Get the information in the selected product
      let qtdInputs, inputs, values, i;
      // Count inputs
      qtdInputs = document.querySelector(`#${item.id} #inputItens`).children;
      // Get Inputs
      inputs = document.querySelector(`#${item.id} #inputItens`).children;
      values = [];

      for (i = 0; i < qtdInputs.length; i++) {
        // Store in array
        values[i] = inputs[i].defaultValue;
      }

      // Product values
      let id, id_category, product_name, category_name, product_description, img, price;
      // Get array values
      id = values[0];
      id_category = values[1];
      product_name = values[2];
      category_name = values[3];
      product_description = values[4];
      img = values[5];
      price = values[6];

      // Create the modal content
      let itemModal = document.getElementById('itemModal');
      let url = window.location.href.replace('/home', '/');

      let modalContent = `
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title" id="name">${product_name}</h3>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <figure>
                <img src="${url}/public/resources/img/products/category_${id_category}/id_${id}/${img}" alt="${img}" title="${product_name}" onerror="this.onerror=null;this.src='${baseUrl}/public/resources/img/not_found/no_image.jpg';">
                <figcaption>
                  <p>Categoria: 
                    <a 
                      href='${url}categories/show/${id_category}' 
                      hx-boost="true" 
                      hx-target="body"
                      hx-swap="outerHTML show:top"
                      data-bs-dismiss="modal" data-js="dismissal"
                      >
                      ${category_name}
                    </a>
                  </p>
                  <p>${product_description}</p>
                  <p>Valor: R$ ${price}</p>
                </figcaption>

              </figure>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-js="dismissal">Fechar</button>
            </div>
          </div>
        </div>`;

      itemModal.innerHTML = modalContent;

      // Show the modal using Bootstrap's JS API
      let modal = new bootstrap.Modal(itemModal);
      modal.show();
      
      // if (window.htmx) window.htmx.process(itemModal);
      if (window.htmx) window.htmx.process(document);

    });

  });

}

document.addEventListener('DOMContentLoaded', productsModal);

// document.addEventListener('htmx:afterSwap', productsModal);

export { productsModal };