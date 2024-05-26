function productsModal() {

  const modalItemContainers =
    document.querySelectorAll('[modal-item-container]');

  if (!modalItemContainers) return;

  Array.from(modalItemContainers).forEach(modalItemContainer => {

    modalItemContainer.addEventListener('click', e => {
      const target = e.target;

      const targetHasModalItem = target.closest('[modal-item]');

      if (!targetHasModalItem) return;

      const item = targetHasModalItem;

      // Get the information in the selected product
      let qtdInputs, inputs, values, i;
      // Count inputs
      qtdInputs = document.querySelector(`#${item.id} #inputItens`).children;
      // get Inputs
      inputs = document.querySelector(`#${item.id} #inputItens`).children;
      values = [];

      for (i = 0; i < qtdInputs.length; i++) {
        // Store on array
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

      // console.log(id, product_name, category_name, product_description, img, price);

      let itemModal = document.getElementById('itemModal');
      // console.log(itemModal[1]);
      let url = window.location.href;
      url = url.replace('/home', '/');

      let modalContent =
        `<div class="modal-dialog" role="document">
        <div class="modal-content">
        <header class="modal-header">
        <h3 class="modal-title" id="name">${product_name}</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </header>
        <div class="modal-body">
        <figure>
        <img src="${url}/public/resources/img/products/category_${id_category}/id_${id}/${img}" alt="${img}" title="${product_name}"  onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';">
        <figcaption>
        <p>Categoria: <a href='${url}categories/show/${id_category}'>${category_name}</a></p>
        <p>${product_description = values[4]}</>
        <p>Valor: <a href='${url}categories/show/${id_category}'>R$ ${price}</a></p>
        </figcaption>
        </figure>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn" style="background:#fff;color:#676767;border:1px solid #ccc" data-dismiss="modal">Fechar</button>
        </div>
        </div>
        </div>`;

      itemModal.innerHTML = modalContent;

    })

  });

}

document.addEventListener('DOMContentLoaded', productsModal)