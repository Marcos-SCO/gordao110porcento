<header class="imgBackgroundArea usersAdmBackground d-flex flex-wrap justify-content-center align-items-center flex-column">
    <span>
        <h2>Funcionário</h2>
        <h1><?= $user->name ?> <?= $user->last_name ?></h1>
    </span>
</header>
<section class="user d-flex flex-wrap align-items-center justify-items-center m-auto">
    <figure class="d-flex flex-wrap m-auto justify-content-center">
        <img class="img-prevent-drag " src="<?= $BASE ?>/<?=imgOrDefault('users',$user->img, $user->id)?>" title="<?= $user->name ?>" onerror="this.onerror=null;this.src='<?=$BASE?>/public/resources/img/not_found/no_image.jpg';">
        <figcaption class="bg-light mt-5">
            <h5>Sobre <?= $user->name ?></h5>
            <p><?=$user->bio?></p>
        </figcaption>
    </figure>
</section>

<?= ($_SESSION['user_status'] != null) ? "<ul class='text-center'><li><a href='$BASE/users/edit/$user->id'>Id de usuário $user->id | Nome: $user->name | E-mail: $user->email</a></li></ul>" : ''; ?>

<?php if (count($posts) > 0) { ?>
    <article class="userPosts flex flex-column justify-content-center">
        <header class="text-center m-auto p-3">
            <h3>Postagens feitas por <?= $user->name ?></h3>
        </header>
        <section class="blog flex-wrap card-group">
            <?php foreach ($posts as $data) { ?>
                <figure class="d-flex justify-content-center blogFig card">
                    <a href="<?= $BASE ?>/posts/show/<?= $data->id ?>">
                        <div class="imgMax">
                            <img class="card-img-top" src="<?=$BASE?>/<?=imgOrDefault('posts', $data->img, $data->id)?>" alt="<?= $data->img ?>" title="<?= $data->title ?>" onerror="this.onerror=null;this.src='<?=$BASE?>/public/resources/img/not_found/no_image.jpg';">
                        </div>
                        <figcaption class="blogBody card-body">
                            <h5 class="blogTitle card-title"><?= $data->title ?></h5>
                            <span class="blogSpan card-text"><?= $data->body ?></span>
                            <small class="updated card-text">Atualizado em <?= dateFormat($data->updated_at) ?></small>
                        </figcaption>
                    </a>
                    <?php
                    Helpers\Classes\DynamicLinks::editDelete($BASE, 'posts', $data, 'Quer mesmo deletar essa postagem?');
                    ?>
                </figure>
            <?php } ?>
        </section>
    <?php } ?>
    </article>