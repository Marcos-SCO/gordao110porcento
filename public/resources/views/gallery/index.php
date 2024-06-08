<header class="galleryHeader imgBackgroundArea">
    <span style="z-index:1">
        <h2>Nossa</h2>
        <h1>Galeria de imagens</h1>
    </span>
</header>

<?php App\Classes\DynamicLinks::addLink($BASE, 'gallery', 'Adicionar mais imagens');

?>

<article class="galleryArticle container">

    <section class="row text-center text-lg-left">

        <?php foreach ($gallery as $data) : ?>

            <figure class="col-lg-3 col-md-4 col-6" data-js="loop-item">

                <a href="<?= $BASE ?>/<?= imgOrDefault('gallery', $data->img, $data->id) ?>" data-toggle="lightbox" data-lightbox="mygallery" data-title="<?= $data->img_title ?>">
                
                    <div class="galleryImgMax">
                        <img src="<?= $BASE ?>/<?= imgOrDefault('gallery', $data->img, $data->id) ?>" alt="<?= $data->img ?>" title="<?= $data->img_title ?>" class="img-fluid img-thumbnail" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';">
                    </div>

                    <figcaption style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                        <p class="text-center"><?= $data->img_title ?></p>
                    </figcaption>
                </a>

                <?php App\Classes\DynamicLinks::editDelete($BASE, 'gallery', $data, 'Quer mesmo deletar essa foto?');

                ?>
            </figure>

        <?php endforeach; ?>

    </section>
</article>