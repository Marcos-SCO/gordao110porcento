<?php

$ulClassName =  $ulListName ?? 'activeList';

$isSessionAdmin = $_SESSION['adm_id'] == 1;

?>

<ul class="<?= $ulClassName ?> list-group">
  <li class="list-group-item">Quantidade <?= $informationNumber ?></li>

  <?php foreach ($users as $user) :

    $userStatus = objParamExistsOrDefault($user, 'status');

    // $isUserStatusOne = $userStatus == 1;
    // if (!$isUserStatusOne) continue;

    $userId = objParamExistsOrDefault($user, 'id');
    $username = objParamExistsOrDefault($user, 'username');
    $userEmail = objParamExistsOrDefault($user, 'email');
    $userImg = objParamExistsOrDefault($user, 'img');
    $userName = objParamExistsOrDefault($user, 'name');

    $userImgUrl = $BASE . '/' . imgOrDefault('users', $userImg, $userId);

    $userPageUrl = $BASE . '/users';

    if ($isSessionAdmin) {
      $userPageUrl = $BASE . '/users/edit/' . $userId;
    }

    if (!$isSessionAdmin && $username) {
      $userPageUrl = $BASE . '/user/' . $username;
    }


    $isUserAdmin = $_SESSION['adm_id'] == 1 && $userId != 1;

  ?>
    <li class="d-flex flex-wrap justify-content-between list-group-item">

      <div class="d-flex" hx-boost="true" hx-target="body" hx-swap="outerHTML">
        <figure class="userPic mr-2">
          <img src="<?= $userImgUrl ?>" class="userImg" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';">
        </figure>

        <p class="px-2">
          <a href="<?= $userPageUrl ?>" class="ml-1 mr-1">id <?= $userId ?> - <?= $userName ?> - <?= $userEmail ?></a>
        </p>
      </div>

      <?php

      if ($userId == 1) {
        echo '<button type="button" class="btn btn-warning disabledButton disabled">
        Desativar</button>';
      }

      if ($isUserAdmin) :

        if ($userStatus == 1) {

          $statusInfo = [0, 'Desativar', 'Quer Mesmo desativar esse usuário?'];
          $buttonColor = 'btn-warning';
        }

        if ($userStatus == 0) {

          $statusInfo = [1, 'Reativar', 'Quer Mesmo Ativar esse usuário?'];
          $buttonColor = 'btn-success';
        }

        $userStatusAction = $BASE . '/users/status/' . $userId . '/' . $statusInfo[0];

      ?>
        <form action="<?= $userStatusAction ?>" method="post" name="delete">

          <input type="hidden" value="<?= $statusInfo[0] ?>" />

          <button type="submit" onclick="return confirm('<?= $statusInfo[2] ?>')" class="btn <?= $buttonColor ?>">
            <?= $statusInfo[1] ?>
          </button>

        </form>

      <?php endif; ?>

    </li>

  <?php endforeach; ?>
</ul>