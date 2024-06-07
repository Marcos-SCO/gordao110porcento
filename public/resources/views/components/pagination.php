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

// ------------ ------------ ------------


$basePath = $BASE . '/' . $path;

$lastPageLink = $basePath . '/' . $totalPages;
$nextPage = $basePath . '/' . $next;
$prevPage = $basePath . '/' . $prev;

$linkCommonHtmlAttributes
  = 'hx-push-url="true"  
    hx-swap="show:[data-js=\'top-page-header\']:top"  
    hx-target="[data-js=\'result-itens-container\']"  
    hx-select="[data-js=\'result-itens-container\'] [data-js=\'loop-item\']"';

function displayPaginationItens($paginationNumbers, $basePath, $linkCommonHtmlAttributes)
{
  foreach ($paginationNumbers as $paginationNumber) {
    echo "<li class='page-item'><a href='$basePath/$paginationNumber' hx-get='$basePath/$paginationNumber' $linkCommonHtmlAttributes><span class='page-link'>$paginationNumber</span></a></li></a></li>";
  }
}

?>

<!-- Pagination -->
<nav class="d-flex justify-content-center flex-wrap p-2 my-3" data-js="pagination-container">

  <ul class="pagination">

    <?php

    $disabled = ($pageId != 1) ? '' : 'disabled';

    echo "<li class='page-item $disabled'><span class='page-link'><a href='$basePath/1' hx-get='$basePath/1' $linkCommonHtmlAttributes>Primeira</a></span></li>";

    echo "<li class='page-item $disabled'><span class='page-link'><a href='$prevPage' hx-get='$prevPage' $linkCommonHtmlAttributes><</a></span></li>";

    $previousNumbers = array_reverse(getPreviousNumbers($pageId, 5));

    displayPaginationItens($previousNumbers, $basePath, $linkCommonHtmlAttributes);

    echo "<li class='page-item active'><a href='$basePath/$pageId' hx-get='$basePath/$pageId' $linkCommonHtmlAttributes><span class='page-link'>$pageId</span></a></li></a></li>";


    $nextNumbers = getNextNumbers($pageId, 5, $totalPages);

    displayPaginationItens($nextNumbers, $basePath, $linkCommonHtmlAttributes);

    $totalDisable =
      ($pageId != $totalPages) ? '' : 'disabled';

    ?>

    <li class="page-item <?= $totalDisable ?>">
      <a class="page-link" href="<?= $nextPage; ?>" hx-get="<?= $nextPage; ?>" <?= $linkCommonHtmlAttributes ?>>></a>
    </li>

    <li class="page-item <?= $totalDisable ?>">
      <span class="page-link">
        <a href="<?= $lastPageLink; ?>" hx-get="<?= $lastPageLink; ?>" <?= $linkCommonHtmlAttributes ?>>Última</a>
      </span>
    </li>

  </ul>

</nav>