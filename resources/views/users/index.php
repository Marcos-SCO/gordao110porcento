<h1 class="text-center">Usuários ativos e inativos</h1>

<section>
    <div class="flex">
        <ul class="active">
            <?php foreach ($users as $user) {?>
                <li>
                    id <?= $user->id ?> - <a href="<?= $BASE ?>/users/edit/<?= $user->id ?>"><?= $user->name ?></a> - <?= $user->email ?>
                    <?php if ($_SESSION['adm_id'] == 1 && $user->id != 1) { 
                    ?>
                        <?php if ($user->status == 1) {
                            $active = [0, 'Desativar', 'Quer Mesmo desativar esse usuario?'];
                        } else {
                            $active = [1, 'Ativar', 'Quer Mesmo Ativar esse usuario?'];
                        }?>
                        <a href="<?= $BASE ?>/users/status/<?= $user->id ?>/<?= $active[0] ?>" method="post" name="delete" onclick="return confirm('<?=$active[2]?>')"><?=$active[1]?></a>
                    <?php } ?>
                </li>
            <?php
            } 
            ?>
        </ul>
    </div>
</section>