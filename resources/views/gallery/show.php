<?php
Core\Controller::createMore($BASE, 'gallery', 'Quer adicionar Mais imagens?');
?>
<figure>
    <a href="<?= $BASE ?>/<?= imgOrDefault('gallery', $data->img, $data->id) ?>" data-toggle="lightbox" data-lightbox="mygallery" data-title="<?= $data->img_title ?>">
        <figure>
            <img src="<?= $BASE ?>/<?= imgOrDefault('gallery', $data->img, $data->id) ?>" alt="<?= $data->img ?>" title="<?= $data->img_title ?>">
            <figcaption style="white-space: nowrap;width: 450px;overflow: hidden;text-overflow: ellipsis;">
                <p><?= $data->img_title ?></p>
            </figcaption>
        </figure>
    </a>
    <?php
    Core\Controller::editDelete($BASE, 'gallery', $data, 'Quer mesmo deletar essa foto?');
    ?>
</figure>