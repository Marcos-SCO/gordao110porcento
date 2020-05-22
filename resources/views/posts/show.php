<?php
Core\Controller::createMore($BASE, 'posts', 'Adicionar mais postagens');
?>
<div>
    <h1><?= $data->title ?></h1>
    <small class="bg-secondary text-white p-2 mb-3"><?php $link = ($_SESSION['user_status'] == 1) ? $BASE . '/users/show/' . $user->id : ''; ?>Escrito por <a href="<?= $link ?>"><?= $user->name ?></a> em <?= $data->created_at ?>
    </small>
    <figure>
        <img src="<?= $BASE ?>/public/img/posts/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->title ?>">
        <figcaption><?= $data->body ?></figcaption>
    </figure>
</div>

<?php 
 Core\Controller::editDelete($BASE, 'posts', $data, 'Quer mesmo deletar essa postagem?');
?>

<input type="hidden" value="<?= $data->id ?>" id="pageId">
<div id="disqus_thread"></div>
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
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by
        Disqus.</a></noscript>
<!-- <script id="dsq-count-scr" src="//lanchao110porcento.disqus.com/count.js" async></script> -->
