<?php

if (!$products) return;

$loopCount = 0;

$linkCommonHtmlAttributes
    = 'hx-push-url="true"  
  hx-swap="show:window:top"  
  hx-target="main"  
  hx-select="main > *"';

foreach ($products as $data) :
  
?>
  <figure class="card" data-js="loop-item">
    <?php

    $loopCount += 1;

    $imgPath =
      imgOrDefault('products', $data->img, $data->id, "/category_$data->id_category");

    $imgLoading =
      $loopCount <= 4 ? 'eager' : 'lazy';

    echo getImgWithAttributes($imgPath, [
      'alt' => $data->product_name,
      'title' => $data->product_name,
      'width' => '299px',
      'height' => '224px',
      'loading' => $imgLoading
    ]);
    ?>

    <figcaption class="card-body">
      <h5 class="card-title"><?= $data->product_name ?></h5>
      <?php

      if ($categoryElements) {
        // Get category name from categories table
        foreach ($categoryElements as $element) {

          if ($element->id == $data->id_category) $categoryName = $element->category_name;
        }

        echo "<p class='card-text'>$data->product_description</p><p class='card-text'>Preço: $data->price</p><small class='text-muted'>Categoria: 
                  <a href='$BASE/categories/show/$data->id_category' hx-get='$BASE/categories/show/$data->id_category' $linkCommonHtmlAttributes> $categoryName</a>
              </small><br>";
      }

      echo ($_SESSION['user_status'] && $_SESSION['user_status'] == 1) ? "
            <a href='$BASE/products/show/$data->id' hx-get='$BASE/products/show/$data->id' $linkCommonHtmlAttributes>Ver detalhes</a>" : '';

      ?>
    </figcaption>

    <?php

    App\Classes\DynamicLinks::editDelete($BASE, 'products', $data, 'Quer mesmo deletar esse produto?');

    ?>
  </figure>

<?php endforeach; ?>