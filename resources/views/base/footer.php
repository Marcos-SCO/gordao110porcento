</main>
<?php if (isset($totalPages) && ($totalPages) > 1) { ?>
    <!-- Pagination -->
    <nav class="d-flex justify-content-center flex-wrap p-2 mt-4">
        <ul class="pagination">

            <?php if (isset($path)) {
                $explodedPath = explode('/', $path);

                $pageId = ($explodedPath[1] == 'show') ? $page : $pageId;

                $disabled = ($pageId != 1) ? '' : 'disabled';

                echo "<li class='page-item $disabled'><span class='page-link'><a href='$BASE/$path/1'>Primeira</a></span></li>";

                echo "<li class='page-item $disabled'><span class='page-link'><a href='$BASE/$path/$prev'><</a></span></li>";

                if ($pageId <= $totalPages) {
                    $elements = 0;
                    for ($i = $pageId; $i <= $totalPages; $i++) {
                        $elements += 1;
                        if ($elements < 5) {
                            $active = ($pageId == $i) ? 'active' : '';
                            echo "<li class='page-item $active'><a href='$BASE/$path/$i'><span class='page-link'>$i</span></a></li></a></li>";
                        }
                    }
                }
                $totalDisable = ($pageId != $totalPages) ? '' : 'disabled';
            ?>
                <li class="page-item <?= $totalDisable ?>">
                    <a class="page-link" href="<?= $BASE ?>/<?= $path . '/' . $next ?>">></a>
                </li>
                <li class="page-item <?= $totalDisable ?>">
                    <span class="page-link"><a href="<?= $BASE ?>/<?= $path . '/' . $totalPages ?>">Última</a></span>
                </li>
            <?php } ?>
        </ul>
    </nav>
<?php } ?>

<!-- Footer -->
<footer class="page-footer font-small blue pt-4">
    <article style="position:relative">
        <section class="container-fluid text-center text-md-left">
            <div class="row">
                <header class="col-md-6 mt-md-0 mt-3">
                    <h5 class="text-uppercase">Footer Content</h5>
                    <p>Here you can use rows and columns to organize your footer content.</p>
                </header>
                <hr class="clearfix w-100 d-md-none pb-3">
                <div class="col-md-3 mb-md-0 mb-3">
                    <h5 class="text-uppercase">Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#!">Link 1</a></li>
                        <li><a href="#!">Link 2</a></li>
                        <li><a href="#!">Link 3</a></li>
                        <li><a href="#!">Link 4</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-md-0 mb-3">
                    <h5 class="text-uppercase">Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#!">Link 1</a></li>
                        <li><a href="#!">Link 2</a></li>
                        <li><a href="#!">Link 3</a></li>
                        <li><a href="#!">Link 4</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <adress class="d-block footer-copyright text-center py-3">© 2020 Desenvolvido por <a href="https://www.linkedin.com/in/marcos-dos-santos-carvalho-67a51715a/" target="_blank" style="font-weight:bolder">Marcos dos Santos Carvalho</a>
        </adress>
    </article>
</footer>
<!-- Footer -->

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