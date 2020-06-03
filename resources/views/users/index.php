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
                        <li class="d-flex flex-wrap list-group-item">
                            <figure class="userPic mr-2"><img src="<?= $BASE ?>/<?= imgOrDefault('users', $user->img, $user->id) ?>" class="userImg"></figure> id <?= $user->id ?> - <a href="<?= $BASE ?>/users/<?= ($_SESSION['adm_id'] == 1) ? 'edit' : 'show' ?>/<?= $user->id ?>" class="ml-1 mr-1"><?= $user->name ?></a> - <?= $user->email ?>
                            <?php if ($_SESSION['adm_id'] == 1 && $user->id != 1) {
                                if ($user->status == 1) {
                                    $active = [0, 'Desativar', 'Quer Mesmo desativar esse usuario?'];
                                }
                            ?>
                                <form action="<?= $BASE ?>/users/status/<?= $user->id ?>/<?= $active[0] ?>" method="post" name="delete">
                                    <input type="hidden" value="<?= $active[0] ?>" />
                                    <button onclick="return confirm('<?= $active[2] ?>')"><?= $active[1] ?></button>
                                </form>
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
                        <li class="d-flex flex-wrap list-group-item">
                            <figure class="userPic mr-2"><img src="<?= $BASE ?>/<?= imgOrDefault('users', $user->img, $user->id) ?>" class="userImg">
                            </figure> id <?= $user->id ?> - <a href="<?= $BASE ?>/users/<?= ($_SESSION['adm_id'] == 1) ? 'edit' : 'show' ?>/<?= $user->id ?>" class="ml-1 mr-1"><?= $user->name ?></a> - <?= $user->email ?>
                            <?php if ($_SESSION['adm_id'] == 1 && $user->id != 1) {
                                ($user->status == 0) ? $active = [1, 'Ativar', 'Quer Mesmo Ativar esse usuario?'] : ''; ?>
                                <form action="<?= $BASE ?>/users/status/<?= $user->id ?>/<?= $active[0] ?>" method="post" name="delete">
                                    <input type="hidden" value="<?= $active[0] ?>" />
                                    <button onclick="return confirm('<?= $active[2] ?>')"><?= $active[1] ?></button>
                                </form>
                            <?php } ?>
                        </li>
                <?php }
                }
                ?>
            </ul>
        <?php } ?>
    </div>
</section>