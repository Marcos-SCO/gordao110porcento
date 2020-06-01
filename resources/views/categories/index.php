<article class="products flex-wrap flex-column">
    <header class="text-center">
        <h1>Categorias</h1>
    </header>
    <section class="products flex-wrap card-group">
        <?php foreach ($categories as $data) { ?>
            <a href='<?= $BASE ?>/categories/show/<?= $data->id ?>'>
                <figure class="card" style="color:#333!important">
                    <img src="<?= $BASE ?>/public/img/categories/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->category_name ?>">
                    <figcaption class="card-body" style="height:142px;">
                        <h5 class="card-title"><?= $data->category_name ?></h5>
                        <?= "<p class='card-text'>$data->category_description</p>" ?>
                    </figcaption>
                </figure>
            </a>
        <?php } ?>
    </section>
</article>