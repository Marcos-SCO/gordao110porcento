<?php

$isPagination =
  (isset($totalPages) && ($totalPages) > 1);

if (!$isPagination) return;

if (!isset($path)) return;

?>

<!-- Pagination -->
<nav class="d-flex justify-content-center flex-wrap p-2 mt-4">

  <ul class="pagination">

    <?php
    
    $disabled = ($pageId != 1) ? '' : 'disabled';

    echo "<li class='page-item $disabled'><span class='page-link'><a href='$BASE/$path/1'>Primeira</a></span></li>";

    echo "<li class='page-item $disabled'><span class='page-link'><a href='$BASE/$path/$prev'><</a></span></li>";

    if ($pageId <= $totalPages) {
      $elements = 0;

      for ($i = $pageId; $i <= $totalPages; $i++) {
        $elements += 1;

        if ($elements <= 3) {
          $active = ($pageId == $i) ? 'active' : '';
          echo "<li class='page-item $active'><a href='$BASE/$path/$i'><span class='page-link'>$i</span></a></li></a></li>";
        }
        
      }

    }

    $totalDisable =
      ($pageId != $totalPages) ? '' : 'disabled';

    ?>

    <li class="page-item <?= $totalDisable ?>">
      <a class="page-link" href="<?= $BASE ?>/<?= $path . '/' . $next ?>">></a>
    </li>

    <li class="page-item <?= $totalDisable ?>">
      <span class="page-link"><a href="<?= $BASE ?>/<?= $path . '/' . $totalPages ?>">Última</a></span>
    </li>

  </ul>

</nav>