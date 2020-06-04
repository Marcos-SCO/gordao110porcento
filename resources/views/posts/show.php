<header class="postShow imgBackgroundArea" style="background-image:url('<?= $BASE . '/' . imgOrDefault('posts', $data->img, $data->id) ?>');">
    <h1><?= $data->title ?></h1>
    <small class='smallInfo'>Escrito por <a href='$BASE/users/show/$user->id'><?= $user->name ?></a> em <?= dateFormat($data->created_at) ?></small>
</header>
<?php if ($_SESSION['user_status'] == 1) { ?>
    <div class="d-flex flex-wrap justify-content-center align-items-center postShowAdm">
        <?php
        Core\Controller::editDelete($BASE, 'posts', $data, 'Quer mesmo deletar essa postagem?');
        ?>
        <?php
        Core\Controller::createMore($BASE, 'posts', 'Adicionar mais postagens');
        ?>
    </div>
<?php } ?>
<article class="pr-4 pl-4">
    <section class="postShowSection mb-3">
        <figure class="postFigure">
            <header>
                <h3 class="text-left p-1 mb-2"><?= $data->title ?></h3>
            </header>
            <img src="<?= $BASE ?>/<?= imgOrDefault('posts', $data->img, $data->id) ?>" title="<?= $data->title ?>">

            <figcaption class="postText"><?= $data->body ?></figcaption>

        </figure>
    </section>
    <section class="aboutUser m-auto">
        <a href="<?= $BASE ?>/users/show/<?= $user->id ?>">
            <h5>Sobre o Autor</h5>
            <figure class="d-flex align-items-center justify-content-left">
                <style>.imgUserBox::before{content:'<?= $user->name ?>';position:absolute;z-index:9999;word-break:break-all;bottom:30px;left:17px;font-size:1rem;background:#d95f1b;padding:.01rem;min-width:100px;max-width:100px;text-align:center;text-decoration:none;}a:hover .imgUserBox::before{background-color:#fff!important}@media screen and (max-width:600px){.imgUserBox::before{left:1rem;top:-15px;min-width: 149px!important;max-height: 25px;}}</style>
                <div class="imgUserBox">
                    <img src="<?= $BASE ?>/<?= imgOrDefault('users', $user->img, $user->id) ?>" alt="<?= $user->img ?>" title="<?= $user->name ?>" class="imgFitUser">
                    <span><?= $user->name ?></span>
                </div>
                <figcaption class="p-2">
                    <p><?= $user->bio ?></p>
                </figcaption>
            </figure>
        </a>
    </section>

    <!-- Disqus -->
    <input type="hidden" value="<?= $data->id ?>" id="pageId">
    <div id="disqus_thread" class="mb-5"></div>
    <script>
        /**
         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
        let pageUrl = window.location.href;
        let pageId = document.getElementById('pageId').value;
        var disqus_config = function(pageUrl, pageId) {
            this.page.url = PAGE_URL; // Replace PAGE_URL with your page's canonical URL variable
            this.page.identifier =
                PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };

        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document,
                s = d.createElement('script');
            s.src = 'https://lanchao110porcento.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    <!-- <script id="dsq-count-scr" src="//lanchao110porcento.disqus.com/count.js" async></script> -->
</article class="p-4