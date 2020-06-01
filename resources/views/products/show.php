<?php
Core\Controller::createMore($BASE, 'products', 'Adicionar mais produtos');
?>
<div>
    <h1><?= $data->product_name ?></h1>
    <small class="bg-secondary text-white p-2 mb-3">
        <?php if ($_SESSION['user_status'] != null) { ?>
            Produto adicionado por <a href="<?= $BASE ?>/users/show/<?= $user->id ?>"><?= $user->name ?></a> em <?= $data->created_at ?>
        <?php } ?>
    </small>
    <figure>
        <img src="<?= $BASE ?>/public/img/products/category_<?=$data->id_category?>/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->product_name ?>">
        <figcaption>
            <p><?= $data->product_description ?></p>
        </figcaption>
    </figure>
</div>

<?php 
 Core\Controller::editDelete($BASE, 'products', $data, 'Quer mesmo deletar esse produto?');
?>