<header class="galleryHeader imgBackgroundArea">
    <span style="z-index:1">
        <h2>Nossa</h2>
        <h1>Galeria de imagens<h1>
    </span>
</header>
<?php
Core\Controller::createMore($BASE, 'gallery', 'Quer adicionar Mais imagens?');
?>
<article class="galleryArticle container">
    <header>
        <h2 class="font-weight-light text-center text-lg-left mt-4 mb-0">Galeria de imagens</h2>
    </header>
    <hr class="mt-2 mb-5" style="width:40%;">
    <section class="row text-center text-lg-left">
        <?php foreach ($gallery as $data) { ?>
            <figure class="col-lg-3 col-md-4 col-6">
                <a href="<?= $BASE ?>/<?= imgOrDefault('gallery', $data->img, $data->id) ?>" data-toggle="lightbox" data-lightbox="mygallery" data-title="<?= $data->img_title ?>">
                    <div class="galleryImgMax"><img src="<?= $BASE ?>/<?= imgOrDefault('gallery', $data->img, $data->id) ?>" alt="<?= $data->img ?>" title="<?= $data->img_title ?>" class="img-fluid img-thumbnail"></div>
                    <figcaption style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><p class="text-center"><?= $data->img_title ?></p>
                    </figcaption>
                </a>
                <?php
                Core\Controller::editDelete($BASE, 'gallery', $data, 'Quer mesmo deletar essa foto?');
                ?>
            </figure>
        <?php } ?>
    </section>
</article>