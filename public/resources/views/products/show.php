<section class="card" style="max-width: 500px;margin:1rem auto">
    <header>
        <h1 class="text-center"><?= $data->product_name ?></h1>
    </header>

    <figure class="productShow d-flex flex-column justify-content-center align-items-center">
        <?php echo getImgWithAttributes(imgOrDefault('products', $data->img, $data->id, "/category_$data->id_category"), [
            'alt' => $data->product_name,
            'title' => $data->product_name,
            'width' => '299px',
            'height' => '224px',
            'loading' => 'eager'
        ]);
        
        ?>

        <figcaption class="card-body bg-light" style="width:100%;min-height: auto!important;">
            <p><?= $data->product_description ?><br>Preço: <?= $data->price ?><br>
                <a href="<?= $BASE ?>/categories/show/<?= $data->id_category ?>">Ver Categoria</a><br><?= ($_SESSION['user_status'] != null) ? "<small class='mb-3'>Produto adicionado por <a href='$BASE/users/show/$user->id'> $user->name</a> em $data->created_at</small>" : ''; ?>
            </p>
        </figcaption>

        <div style="padding:1rem">
            <?php

            App\Classes\DynamicLinks::editDelete($BASE, 'products', $data, 'Quer mesmo deletar esse produto?');

            App\Classes\DynamicLinks::addLink($BASE, 'products', 'Adicionar mais produtos');
            ?>
        </div>
    </figure>
</section>