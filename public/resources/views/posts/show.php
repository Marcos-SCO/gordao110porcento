<?php

$username = objParamExistsOrDefault($user, 'username');

$postImgUrl = $BASE_WITH_PUBLIC . '/' . imgOrDefault('posts', $data->img, $data->id);

$userPageUrl = $BASE . '/users/';
if ($username) $userPageUrl = $BASE . '/user/' . $username;

$postSlug = objParamExistsOrDefault($data, 'slug');

?>

<header class="postShow imgBackgroundArea" style="background-image:url('<?= $postImgUrl ?>');" hx-boost="true" hx-target="body" hx-swap="outerHTML">
    <h1><?= $data->title ?></h1>

    <small class='smallInfo'>
        Escrito por <a href='<?= $userPageUrl ?>'><?= $user->name ?></a> em <?= dateFormat($data->created_at) ?>
    </small>
</header>

<?php if ($_SESSION['user_status'] == 1) : ?>
    <div class="d-flex flex-wrap justify-content-center align-items-center postShowAdm">
        <?php

        App\Classes\DynamicLinks::editDelete($BASE, 'posts', $data, 'Quer mesmo deletar essa postagem?');

        App\Classes\DynamicLinks::addLink($BASE, 'posts', 'Adicionar mais postagens');
        ?>
    </div>
<?php endif; ?>

<article class="pr-4 pl-4" hx-boost="true" hx-target="body" hx-swap="outerHTML">

    <section class="postShowSection mb-3" data-post-slug="<?= $postSlug ?>" data-base-url="<?= $BASE; ?>">
        <figure class="postFigure">
            <header>
                <h3 class="text-left p-1 mb-2"><?= $data->title ?></h3>
            </header>
            <img src="<?= $postImgUrl ?>" title="<?= $data->title ?>" onerror="this.onerror=null;this.src='<?= $RESOURCES_PATH ?>/img/not_found/no_image.jpg';">
        </figure>

        <div class="postText"><?= htmlspecialchars_decode($data->body); ?></div>
    </section>

    <section class="aboutUser m-auto">

        <a href="<?= $userPageUrl ?>">

            <h5>Sobre o Autor</h5>

            <figure class="d-flex align-items-center justify-content-left">

                <style>
                    .imgUserBox::before {
                        content: '<?= $user->name ?>';
                        position: absolute;
                        z-index: 9999;
                        word-break: break-all;
                        bottom: 30px;
                        left: 17px;
                        font-size: 1rem;
                        background: #d95f1b;
                        padding: .01rem;
                        min-width: 100px;
                        max-width: 100px;
                        text-align: center;
                        text-decoration: none;
                    }

                    a:hover .imgUserBox::before {
                        background-color: #fff !important
                    }

                    @media screen and (max-width:600px) {
                        .imgUserBox::before {
                            left: 1rem;
                            top: -15px;
                            min-width: 149px !important;
                            max-height: 25px;
                        }
                    }
                </style>

                <div class="imgUserBox">
                    <img src="<?= $BASE_WITH_PUBLIC ?>/<?= imgOrDefault('users', $user->img, $user->id) ?>" alt="<?= $user->img ?>" title="<?= $user->name ?>" class="imgFitUser" onerror="this.onerror=null;this.src='<?= $RESOURCES_PATH ?>/img/not_found/no_image.jpg';">
                    <span><?= $user->name ?></span>
                </div>

                <figcaption class="p-2">
                    <p><?= $user->bio ?></p>
                </figcaption>
            </figure>
        </a>

    </section>

</article>

<!-- Disqus -->
<div id="disqus_thread" class="mb-5"></div>
<script>
    window.dataBaseUrl = document.querySelector('[data-base-url]')
        ?.getAttribute('data-base-url');

    window.dataPostSlug = document.querySelector('[data-post-slug]')?.getAttribute('data-post-slug');

    var disqus_config = function() {
        this.page.url = dataBaseUrl + '/post/' + dataPostSlug;
        this.page.identifier = dataBaseUrl + '/post/' + dataPostSlug;
    };

    (function() {
        var d = document,
            s = d.createElement('script');
        s.src = 'https://gordao110.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        s.onload = function() {};
        (d.head || d.body).appendChild(s);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>