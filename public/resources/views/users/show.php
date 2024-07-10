<header class="imgBackgroundArea usersAdmBackground d-flex flex-wrap justify-content-center align-items-center flex-column">
    <span>
        <h2>Funcionário</h2>
        <h1><?= $user->name ?> <?= $user->last_name ?></h1>
    </span>
</header>

<section class="user d-flex flex-wrap align-items-center justify-items-center m-auto">
    <figure class="d-flex flex-wrap m-auto justify-content-center">
        <img class="img-prevent-drag " src="<?= $BASE ?>/<?= imgOrDefault('users', $user->img, $user->id) ?>" title="<?= $user->name ?>" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';">
        <figcaption class="bg-light mt-5">
            <h5>Sobre <?= $user->name ?></h5>
            <p><?= $user->bio ?></p>
        </figcaption>
    </figure>
</section>

<?= ($_SESSION['user_status'] != null) ? "<ul class='text-center'><li><a href='$BASE/users/edit/$user->id'>Id de usuário $user->id | Nome: $user->name | E-mail: $user->email</a></li></ul>" : ''; ?>

<?php if (count($posts) > 0) :

    // $linkCommonHtmlAttributes
    //     = 'hx-push-url="true"  
    // hx-swap="show:body:top"  
    // hx-target="[data-js=\'result-itens-container\']"  
    // hx-select="[data-js=\'result-itens-container\'] [data-js=\'loop-item\']"';

?>

    <article class="userPosts flex flex-column justify-content-center" data-js="top-page-header">

        <header class="text-center m-auto p-3">
            <h3>Postagens feitas por <?= $user->name ?></h3>
        </header>

        <?php

        // PostsSection
        include_once __DIR__ . '/../components/posts/postsSection.php';

        ?>

    <?php endif; ?>

    </article>