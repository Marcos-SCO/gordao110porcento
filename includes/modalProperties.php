<a style="border:none!important;background:none!important;outline:none!important" data-toggle="modal" data-target="#itemModal" id="product_<?= $h->id ?>" onclick="callItem(this)">
    <!-- <a> -->
    <span style="display:none;" id="inputItens">
        <input type="hidden" name="id" value="<?= $h->id ?>">
        <input type="hidden" name="id_category" value="<?= $h->id_category ?>">
        <input type="hidden" name="product_name" value="<?= $h->product_name ?>">
        <input type="hidden" name="category_name" value="<?= ($h->id_category == 1) ? 'Hamburgueres' : 'Pizzas' ?>">
        <input type="hidden" name="product_description" value="<?= $h->product_description ?>">
        <input type="hidden" name="img" value="<?= $h->img ?>">
        <input type="hidden" name="price" value="<?= $h->price ?>">
    </span>