<nav class="navbar fixed-top navbar-dark bg-dark navbar-expand-lg">
  <a class="navbar-brand" href="/">Ticketera CI</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="mainNav">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Tickets
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownTickets">
          <a class="dropdown-item" href="<?=base_url('tickets')?>">       Home</a>
          <a class="dropdown-item" href="<?=base_url('tickets/alta')?>">  Nuevo</a>
	  <?php if(tienePermisos('ADMIN')):?>
	    <a class="dropdown-item" href="<?=base_url('admin/tickets')?>">Busqueda</a>
	  <?php else:?>
	    <a class="dropdown-item" href="<?=base_url('tickets/buscar')?>">Busqueda</a>
	  <?php endif?>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Abonados
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownAbonados">
          <?php if(tienePermisos(['ABONADOS_ABM'])):?>
              <a class="dropdown-item" href="<?=base_url('abonados/alta')?>">       Nuevo</a>
          <?php endif?>
          <a class="dropdown-item" href="<?=base_url('abonados')?>">            Buscar</a>
        </div>
      </li>

      <?php if(tienePermisos(['USUARIOS_ABM'])):?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Usuarios
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownUsuarios">
          <a class="dropdown-item" href="<?=base_url('usuarios/alta')?>"> Nuevo</a>
          <a class="dropdown-item" href="<?=base_url('usuarios')?>">      Buscar</a>
        </div>
      </li>
      <?php endif?>
    </ul>

    <ul class="navbar-nav">
      <li class="nav-item dropdown ml-auto">
        <a class="nav-link dropdown-toggle perfil-dropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle icon-user <?php if($_SESSION['usuario']['sector']['id'] == 1) echo 'admin'?>"></i>
          <?=$_SESSION['usuario']['username']?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownPerfil">
          <?php if($_SESSION['usuario']['sector']['id'] == 1):?>
          <a class="dropdown-item" href="<?=base_url('admin')?>">     Panel Admin</a>
          <?php endif?>
          <a class="dropdown-item" href="<?=base_url('perfil')?>">    Perfil</a>
          <a class="dropdown-item" href="<?=base_url('logout')?>">    Cerrar Sesión</a>
        </div>
      </li>
    </ul>
  </div>
</nav>