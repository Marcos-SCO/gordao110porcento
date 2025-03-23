<?php

$userId = objParamExistsOrDefault($user, 'id');
$username = objParamExistsOrDefault($user, 'username');
$userImg = objParamExistsOrDefault($user, 'img');
$userBio = objParamExistsOrDefault($user, 'bio');

$userImgUrl = $BASE . '/' . imgOrDefault('users', $userImg, $userId);

$nameUserProfile = objParamExistsOrDefault($user, 'name');
$lastNameUserProfile = objParamExistsOrDefault($user, 'last_name');

$emailUserProfile = objParamExistsOrDefault($user, 'email');

?>

<header class="imgBackgroundArea usersAdmBackground d-flex flex-wrap justify-content-center align-items-center flex-column">
    <span>
        <h2>Funcionário</h2>
        <h1><?= $nameUserProfile ?> <?= $lastNameUserProfile ?></h1>
    </span>
</header>

<section class="user d-flex flex-wrap align-items-center justify-items-center m-auto">
    <figure class="d-flex flex-wrap m-auto justify-content-center">
        <img class="img-prevent-drag " src="<?= $userImgUrl ?>" title="<?= $nameUserProfile ?>" onerror="this.onerror=null;this.src='<?= $RESOURCES_PATH ?>/img/not_found/no_image.jpg';">

        <figcaption class="bg-light mt-5">
            <h5>Sobre <?= $nameUserProfile ?></h5>
            <p><?= $userBio ?></p>
        </figcaption>
    </figure>
</section>

<?php if ($_SESSION['user_status'] != null) echo "<ul class='text-center' hx-boost='true' hx-target='body' hx-swap='outerHTML'><li><a href='$BASE/users/edit/$userId'>Id de usuário $userId | Username: $username | Nome: $nameUserProfile | E-mail: $emailUserProfile</a></li></ul>";

?>

<?php if (count($posts) > 0) : ?>

    <article class="userPosts flex flex-column justify-content-center" data-js="top-page-header">

        <header class="text-center m-auto p-3">
            <h3>Postagens feitas por <?= $nameUserProfile ?></h3>
        </header>

        <?php

        // PostsSection
        include_once __DIR__ . '/../components/posts/postsSection.php';

        ?>

    <?php endif; ?>

    </article>