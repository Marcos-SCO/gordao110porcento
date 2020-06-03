<header class="imgBackgroundArea usersAdmBackground">
    <span class="text-left">
        <h2>Usuários</h2>
        <h1>Ativos e Inativos</h1>
    </span>
</header>
<section>
    <div class="usersAdm flex justify-content-center align-content-center">
        <?php if ($activeNumber->active > 0) { ?>
            <ul class="activeList list-group">
                <li class="list-group-item">Quantidade <?= $activeNumber->active ?></li>
                <?php foreach ($users as $user) {
                    if ($user->status == 1) { ?>
                        <li class="list-group-item">
                            id <?= $user->id ?> - <a href="<?= $BASE ?>/users/edit/<?= $user->id ?>"><?= $user->name ?></a> - <?= $user->email ?>
                            <?php if ($_SESSION['adm_id'] == 1 && $user->id != 1) {
                            ?>
                                <?php if ($user->status == 1) {
                                    $active = [0, 'Desativar', 'Quer Mesmo desativar esse usuario?'];
                                }
                                ?>
                                <a href="<?= $BASE ?>/users/status/<?= $user->id ?>/<?= $active[0] ?>" method="post" name="delete" onclick="return confirm('<?= $active[2] ?>')"><?= $active[1] ?></a>
                            <?php } ?>
                        </li>
                <?php }
                }
                ?>
            </ul>
        <?php } ?>
        <?php if ($inactiveNumber->inactive > 0) { ?>
            <ul class="inactiveList list-group">
                <li class="list-group-item">Quantidade <?= $inactiveNumber->inactive ?></li>
                <?php foreach ($users as $user) {
                    if ($user->status == 0) { ?>
                        <li class="list-group-item">
                            id <?= $user->id ?> - <a href="<?= $BASE ?>/users/edit/<?= $user->id ?>"><?= $user->name ?></a> - <?= $user->email ?>
                            <?php if ($_SESSION['adm_id'] == 1 && $user->id != 1) {
                            ?>
                                <?php if ($user->status == 0) {
                                    $active = [1, 'Ativar', 'Quer Mesmo Ativar esse usuario?'];
                                } ?>
                                <a href="<?= $BASE ?>/users/status/<?= $user->id ?>/<?= $active[0] ?>" method="post" name="delete" onclick="return confirm('<?= $active[2] ?>')"><?= $active[1] ?></a>
                            <?php } ?>
                        </li>
                <?php }
                }
                ?>
            </ul>
        <?php } ?>
    </div>
</section>