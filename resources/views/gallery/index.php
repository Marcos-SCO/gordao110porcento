<h1>Welcome</h1>

<?php
Core\Controller::createMore($BASE, 'gallery', 'Quer adicionar Mais imagens?');
?>
<?php foreach ($gallery as $data) { ?>
    <div>
        <a href="<?= $BASE ?>/gallery/show/<?= $data->id ?>">
            <h1><?= $data->img_title ?></h1>
            <figure>
                <img src="<?= $BASE ?>/<?= imgOrDefault('gallery', $data->img, $data->id) ?>" alt="<?= $data->img ?>" title="<?= $data->img_title ?>">
                <figcaption style="white-space: nowrap;width: 450px;overflow: hidden;text-overflow: ellipsis;">
                </figcaption>
            </figure>
        </a>

        <?php
        Core\Controller::editDelete($BASE, 'gallery', $data, 'Quer mesmo deletar essa foto?');
        ?>
    </div>
<?php } ?>

<!--GALERIA-->
<div id="menu4">
    <h4 class="semana">Galeria de imagens</h4>
    <div class="galeria">
        <a href="https://unsplash.it/1200/768.jpg?image=256" data-toggle="lightbox" data-lightbox="mygallery">
            <img src="https://unsplash.it/600.jpg?image=256" class="img-fluid rounded">
        </a>
        <a href="https://unsplash.it/1200/768.jpg?image=256" data-toggle="lightbox" data-lightbox="mygallery">
            <img src="https://unsplash.it/600.jpg?image=256" class="img-fluid rounded">
        </a>
        <a href="https://unsplash.it/1200/768.jpg?image=256" data-toggle="lightbox" data-lightbox="mygallery">
            <img src="https://unsplash.it/600.jpg?image=256" class="img-fluid rounded">
        </a>
        <a href="https://unsplash.it/1200/768.jpg?image=256" data-toggle="lightbox" data-lightbox="mygallery">
            <img src="https://unsplash.it/600.jpg?image=256" class="img-fluid rounded">
        </a>
    </div>
</div>