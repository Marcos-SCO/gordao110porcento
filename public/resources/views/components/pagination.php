<?php

$isPagination =
  (isset($totalPages) && ($totalPages) > 1);

if (!$isPagination) return;

if (!isset($path)) return;

function getPreviousNumbers($initialValue, $count = 5)
{
  $numbers = [];

  $initialValueMinusOne = $initialValue - 1;
  $initialValueMinusCount = $initialValueMinusOne - $count;

  for ($i = $initialValueMinusOne; $i > $initialValueMinusCount; $i--) {

    if ($i <= 0) break;

    $numbers[] = $i;
  }

  return $numbers;
}

function getNextNumbers($initialValue, $count = 5, $maxNumber = false)
{
  $numbers = [];

  for ($i = $initialValue + 1; $i <= ($initialValue + $count); $i++) {

    if ($maxNumber && $i > $maxNumber) {
      break;
    }

    $numbers[] = $i;
  }

  return $numbers;
}

function displayPaginationItens($paginationNumbers, $path)
{
  global $BASE;

  foreach ($paginationNumbers as $paginationNumber) {
    echo "<li class='page-item'><a href='$BASE/$path/$paginationNumber'><span class='page-link'>$paginationNumber</span></a></li></a></li>";
  }
}

?>

<!-- Pagination -->
<nav class="d-flex justify-content-center flex-wrap p-2 mt-4">

  <ul class="pagination">

    <?php

    $disabled = ($pageId != 1) ? '' : 'disabled';

    echo "<li class='page-item $disabled'><span class='page-link'><a href='$BASE/$path/1'>Primeira</a></span></li>";

    echo "<li class='page-item $disabled'><span class='page-link'><a href='$BASE/$path/$prev'><</a></span></li>";

    $previousNumbers = array_reverse(getPreviousNumbers($pageId, 5));

    displayPaginationItens($previousNumbers, $path);

    echo "<li class='page-item active'><a href='$BASE/$path/$pageId'><span class='page-link'>$pageId</span></a></li></a></li>";


    $nextNumbers = getNextNumbers($pageId, 5, $totalPages);

    displayPaginationItens($nextNumbers, $path);

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