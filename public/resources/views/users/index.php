<?php

$activeUsersNumber = objParamExistsOrDefault($activeNumber, 'active');

$inactiveUsersNumber = objParamExistsOrDefault($inactiveNumber, 'inactive');

echo "<style>main {min-height:100%}</style>";

$linkCommonHtmlAttributes =
    'hx-push-url="true"  
hx-swap="show:body:top"  
hx-target="[data-js=\'result-itens-container\']"  
hx-select="[data-js=\'result-itens-container\'] [data-js=\'users-container-data\']"';

?>

<header class="imgBackgroundArea usersAdmBackground">
    <span class="text-left">
        <h2>Usuários</h2>
        <h1>Ativos e Inativos</h1>
    </span>
</header>

<div hx-boost="true" hx-target="body" hx-swap="outerHTML">
    <?php App\Classes\DynamicLinks::addLink($BASE, 'users', 'Adicionar mais Usuários');

    ?>
</div>

<section data-js="result-itens-container" hx-boost="true" hx-target="body" hx-swap="outerHTML">

    <div class="usersAdm flex justify-content-center align-content-center" data-js="users-container-data">

        <?php if ($activeUsersNumber > 0) :

            $users = $activeUsers;
            $informationNumber = $activeUsersNumber;

            include __DIR__ . '/components/_usersList.php';

        endif;

        ?>

        <?php if ($inactiveUsersNumber > 0) :

            $users = $inactiveUsers;
            $informationNumber = $inactiveUsersNumber;
            $ulListName = 'inactiveList';

            include __DIR__ . '/components/_usersList.php';

        endif;

        ?>

    </div>

</section>