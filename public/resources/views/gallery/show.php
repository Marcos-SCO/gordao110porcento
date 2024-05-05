<header class="galleryHeader productHeader imgBackgroundArea">
    <span>
        <h2>Mostrar imagem</h2>
        <h1><?= $data->img_title ?></h1>
    </span>
</header>

<?php if ($_SESSION['user_status'] == 1) {

    echo "<style>.createBtn{max-width:207px!important}</style><div style='display:flex;flex-wrap:wrap;justify-content:center;max-width:442px;align-items:center;margin:1rem auto'><a href='$BASE/gallery' class='createBtn btn'>Voltar para Galeria</a>";
    Core\Controller::createMore($BASE, 'gallery', 'Adicionar mais imagens');
    echo "</div>";
}

?>
<section>
    <figure class="d-flex flex-column justify-content-center align-items-center m-auto">
        <a href="<?= $BASE ?>/<?= imgOrDefault('gallery', $data->img, $data->id) ?>" data-toggle="lightbox" data-lightbox="mygallery" data-title="<?= $data->img_title ?>">
            <figure style="max-width: 250px">
                <img src="<?= $BASE ?>/<?= imgOrDefault('gallery', $data->img, $data->id) ?>" alt="<?= $data->img ?>" title="<?= $data->img_title ?>" class="m-auto img-thumbnail" onerror="this.onerror=null;this.src='<?=$BASE?>/public/resources/img/not_found/no_image.jpg';">
                <figcaption style="white-space:nowrap;width: 450px;overflow:hidden;text-overflow:ellipsis;">
                    <p style="max-width:250px;color:#ff7a08;background-color:#fff;border:1px solid #dee2e6;border-radius:44px;border-top: none!important;padding-left:.3rem;overflow:hidden;text-align:center"><?= $data->img_title ?></p>
                </figcaption>
            </figure>
        </a>

        <?php
        Core\Controller::editDelete($BASE, 'gallery', $data, 'Quer mesmo deletar essa foto?');

        ?>
    </figure>
</section>