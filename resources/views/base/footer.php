</main>
<?php if (isset($totalPages) && ($totalPages) > 1) { ?>
    <!-- Pagination -->
    <ul>
        <?php if (isset($method) && $method == 'show') { ?>
            <?php if ($page != 1) { ?>
                <li><a href="<?= $BASE ?>/<?= $table ?>/<?= $method ?>/<?= $pageId ?>/1">Inicio</a></li>
                <li><a href="<?= $BASE ?>/<?= $table ?>/<?= $method ?>/<?= $pageId ?>/<?= $prev ?>">Anterior</a></li>
            <?php } ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li><a href="<?= $BASE ?>/<?= $table ?>/<?= $method ?>/<?= $pageId ?>/<?= $i ?>"><?= $i ?></a></li>
            <?php } ?>

            <?php if ($page != $totalPages) { ?>
                <li><a href="<?= $BASE ?>/<?= $table ?>/<?= $method ?>/<?= $pageId ?>/<?= $next ?>">Próxima</a></li>
                <li><a href="<?= $BASE ?>/<?= $table ?>/<?= $method ?>/<?= $pageId ?>/<?= $totalPages ?>">Final</a></li>
            <?php } ?>
        <?php } ?>

        <?php if (!isset($method) && isset($pageId)) { ?>
            <?php if ($pageId != 1) { ?>
                <li><a href="<?= $BASE ?>/<?= $table ?>/index/1">Inicio</a></li>
                <li><a href="<?= $BASE ?>/<?= $table ?>/index/<?= $prev ?>">Anterior</a></li>
            <?php } ?>

            <?php if ($pageId != $totalPages) { ?>
                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                    <li><a href="<?= $BASE ?>/<?= $table ?>/index/<?= $i ?>"><?= $i ?></a></li>
                <?php } ?>
            <?php } ?>
            <?php if ($pageId != $totalPages) { ?>
                <li><a href="<?= $BASE ?>/<?= $table ?>/index/<?= $next ?>">Próxima</a></li>
                <li><a href="<?= $BASE ?>/<?= $table ?>/index/<?= $totalPages ?>">Final</a></li>
            <?php } ?>
        <?php } ?>
    </ul>
<?php } ?>

<!-- Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
</script>

<!-- <script src='<?= $BASE ?>/public/js/jquery.min.js'></script> -->
<!-- Owl -->
<script src='<?= $BASE ?>/public/js/owl.carousel.min.js'></script>
<!-- App -->
<script src="<?= $BASE ?>/public/js/app.js"></script>
</body>

</html>