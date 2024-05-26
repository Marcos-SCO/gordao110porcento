<?php

$activeUsers = $activeNumber->active;

$inactiveUsers = $inactiveNumber->inactive;

echo "<style>main {min-height:100%}</style>";

?>

<header class="imgBackgroundArea usersAdmBackground">
    <span class="text-left">
        <h2>Usuários</h2>
        <h1>Ativos e Inativos</h1>
    </span>
</header>

<?php App\Classes\DynamicLinks::addLink($BASE, 'users', 'Adicionar mais Usuários');

?>
<section>
    <div class="usersAdm flex justify-content-center align-content-center">

        <?php if ($activeUsers > 0) : ?>

            <ul class="activeList list-group">
                <li class="list-group-item">Quantidade <?= $activeUsers ?></li>

                <?php foreach ($users as $user) :

                    $isUserStatusOne = $user->status == 1;

                    if (!$isUserStatusOne) continue;

                ?>
                    <li class="d-flex flex-wrap list-group-item">

                        <figure class="userPic mr-2">
                            <img src="<?= $BASE ?>/<?= imgOrDefault('users', $user->img, $user->id) ?>" class="userImg" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';">
                        </figure>

                        id <?= $user->id ?> - <a href="<?= $BASE ?>/users/<?= ($_SESSION['adm_id'] == 1) ? 'edit' : 'show' ?>/<?= $user->id ?>" class="ml-1 mr-1"><?= $user->name ?></a> - <?= $user->email ?>

                        <?php

                        if ($_SESSION['adm_id'] == 1 && $user->id != 1) :

                            if ($user->status == 1) {
                                $active = [0, 'Desativar', 'Quer Mesmo desativar esse usuário?'];
                            }

                        ?>
                            <form action="<?= $BASE ?>/users/status/<?= $user->id ?>/<?= $active[0] ?>" method="post" name="delete">
                                <input type="hidden" value="<?= $active[0] ?>" />
                                <button onclick="return confirm('<?= $active[2] ?>')"><?= $active[1] ?></button>
                            </form>
                        <?php endif; ?>
                    </li>

                <?php endforeach; ?>
            </ul>

        <?php endif; ?>

        <?php if ($inactiveUsers > 0) : ?>

            <ul class="inactiveList list-group">
                <li class="list-group-item">Quantidade <?= $inactiveUsers ?></li>

                <?php foreach ($users as $user) :

                    $isUserStatusZero = $user->status == 0;

                    if (!$isUserStatusZero) continue;

                ?>
                    <li class="d-flex flex-wrap list-group-item">
                        <figure class="userPic mr-2">
                            <img src="<?= $BASE ?>/<?= imgOrDefault('users', $user->img, $user->id) ?>" class="userImg" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';">
                        </figure>

                        id <?= $user->id ?> - <a href="<?= $BASE ?>/users/<?= ($_SESSION['adm_id'] == 1) ? 'edit' : 'show' ?>/<?= $user->id ?>" class="ml-1 mr-1"><?= $user->name ?></a> - <?= $user->email ?>

                        <?php

                        if ($_SESSION['adm_id'] == 1 && $user->id != 1) :

                            if ($user->status == 0) {

                                $active = [1, 'Ativar', 'Quer Mesmo Ativar esse usuário?'];
                            }

                        ?>

                            <form action="<?= $BASE ?>/users/status/<?= $user->id ?>/<?= $active[0] ?>" method="post" name="delete">
                                <input type="hidden" value="<?= $active[0] ?>" />
                                <button onclick="return confirm('<?= $active[2] ?>')"><?= $active[1] ?></button>
                            </form>

                        <?php endif; ?>

                    </li>

                <?php endforeach; ?>
            </ul>

        <?php endif; ?>

    </div>
</section>