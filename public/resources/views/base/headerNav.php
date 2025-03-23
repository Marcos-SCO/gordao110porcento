<!-- Nav -->
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:#f8f9fa;" hx-boost="true" hx-target="body" hx-swap="outerHTML">

  <!-- Show this only on mobile to medium screens -->
  <a class="navbar-brand d-lg-none" href="<?= $BASE ?>">
    <img src="<?= $RESOURCES_PATH ?>/img/template/gordao110Logo100.png" alt="Gordão a 110%" title="Gordão a 110%">
  </a>

  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-between" id="navbarToggle" style="padding-right: 4.4rem;" data-js="navbar-collapse">

    <ul class="navbar-nav">
      <li class="nav-item" data-active-page="home">
        <a class="nav-link" href="<?= $BASE ?>">
          Home<span class="visually-hidden">(current)</span>
        </a>
      </li>

      <li class="nav-item <?= activePageClass(['products', 'categories'], $dataPage); ?>">
        <a class="nav-link" href="<?= $BASE ?>/products">Ofertas</a>
      </li>

      <li class="nav-item" data-active-page="posts">
        <a class="nav-link" href="<?= $BASE ?>/posts">Blog</a>
      </li>

      <li class="nav-item" data-active-page="gallery">
        <a class="nav-link" href="<?= $BASE ?>/gallery">Galeria</a>
      </li>
    </ul>

    <!-- Show this only lg screens and up -->
    <a class="navbar-brand d-none d-lg-block" style="position:absolute;top:0;margin:0!important;" href="<?= $BASE ?>">
      <img src="<?= $RESOURCES_PATH ?>/img/template/gordao110Logo100.png" alt="Gordão a 110%" title="Gordão a 110%">
    </a>

    <ul class="navbar-nav">
      <li class="nav-item" data-active-page="about">
        <a class="nav-link" href="<?= $BASE ?>/about">Sobre</a>
      </li>

      <li id="headerDropdown" class="nav-item dropdown  <?= activePageClass(['contact', 'contact/work', 'contact/message'], $dataPage); ?>" data-active-page="contact" hx-history="false">

        <a class="nav-link dropdown-toggle header-menu" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Contato</a>

        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <li data-active-page="contact/message">
            <a class="dropdown-item" href="<?= $BASE ?>/contact/message">Enviar Mensagem</a>
          </li>

          <li data-active-page="contact/work">
            <a class="dropdown-item" href="<?= $BASE ?>/contact/work">Trabalhe conosco</a>
          </li>
        </ul>

      </li>

      <?php if (!$isUserLoggedIn) : ?>
        <li class="nav-item" data-active-page="users-login">
          <a class="nav-link" href="<?= $BASE ?>/login">Login</a>
        </li>
      <?php endif; ?>

      <?php if ($isUserLoggedIn) : ?>

        <li class="nav-item dropdown <?= activePageClass(['users/create', 'categories/create', 'products/create', 'posts/create', 'gallery/create'], $dataPage); ?>" hx-history="false">

          <a class="nav-link dropdown-toggle" style="background:#f8f9fa!important" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Adicionar</a>

          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

            <li data-active-page="users/create">
              <a class="dropdown-item" href="<?= $BASE ?>/users/create">Usuário</a>
            </li>

            <li data-active-page="categories/create">
              <a class="dropdown-item" href="<?= $BASE ?>/categories/create">Categorias</a>
            </li>

            <li data-active-page="products/create">
              <a class="dropdown-item" href="<?= $BASE ?>/products/create">Produtos</a>
            </li>

            <li data-active-page="posts/create">
              <a class="dropdown-item" href="<?= $BASE ?>/posts/create">Postagens</a>
            </li>

            <li data-active-page="gallery/create">
              <a class="dropdown-item" href="<?= $BASE ?>/gallery/create">Fotos</a>
            </li>
          </ul>

        </li>

        <li class="nav-item dropdown <?= activePageClass(['users', 'users/edit', 'users/show'], $dataPage); ?>" hx-history="false">

          <a class="nav-link dropdown-toggle" style="background:#f8f9fa!important" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= $sessionUserFirstName ?? "" ?></a>

          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

            <li data-active-page="users/edit"><a class="dropdown-item" href="<?= $BASE ?>/users/edit/<?= $sessionUserId ?>">Meu perfil</a></li>

            <li data-active-page="users/show"><a class="dropdown-item" href="<?= $BASE ?>/user/<?= $sessionUserName ?>">Página</a></li>

            <li data-active-page="users"><a class="dropdown-item" href="<?= $BASE ?>/users/">Usuários</a></li>

            <li class="nav-item <?= activePageClass(['categories'], $dataPage); ?>">
              <a class="dropdown-item" href="<?= $BASE ?>/categories">Categorias</a>
            </li>

            <li><a class="dropdown-item" href="<?= $BASE ?>/logout">Sair</a></li>
          </ul>

        </li>

      <?php endif; ?>
    </ul>
  </div>

</nav>
<!-- end nav -->