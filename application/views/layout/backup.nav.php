<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">Ticketera</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="nav navbar-nav">
        <li class="dropdown" id="tickets">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tickets
                <?php if($tkPendientes > 0):?>
                  <span class="badge"><?=$tkPendientes?></span>
                <?php endif ?>
              <span class="caret"/></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url('tickets')?>">Home</a></li>
            <li><a href="<?=base_url('tickets/alta')?>">Nuevo</a></li>
            <li><a href="<?=base_url('tickets/buscar')?>">Busqueda</a></li>
          </ul>
        </li>

        
        <li class="dropdown" id="abonados">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Abonados <span class="caret"/></a>
          <ul class="dropdown-menu">
          <?php if(tienePermisos(['ABONADOS_ABM'])):?>
            <li><a href="<?=base_url('abonados/alta')?>">Nuevo</a></li>
          <?php endif?>
            <li><a href="<?=base_url('abonados')?>">Ver Todos</a></li>
          </ul>
        </li>
        

        <?php if(tienePermisos(['USUARIOS_ABM'])):?>
        <li class="dropdown" id="usuarios">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuarios <span class="caret"/></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url('usuarios/alta')?>">Nuevo</a></li>
            <li><a href="<?=base_url('usuarios')?>">Ver Todos</a></li>
          </ul>
        </li>
        <?php endif?>
      </ul>


      <ul class="nav navbar-nav navbar-right">
      <?php if(isset($_SESSION['usuario']['username'])):?>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="user-button">
              <span class="glyphicon glyphicon-user icon-user <?php if($_SESSION['usuario']['sector']['id'] == 1) echo 'admin'?>" ></span>
              <?=$_SESSION['usuario']['username'];?> <span class="caret"/>
            </a>
            <ul class="dropdown-menu">
            <?php if($_SESSION['usuario']['sector']['id'] == 1):?>
              <li><a href="<?=base_url('admin')?>">Admin Panel</a></li>
            <?php endif?>
              <li><a href="<?=base_url('perfil')?>">Perfil</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="<?=base_url('logout')?>">Cerrar Sesión</a></li>
            </ul>
          </li>

      <?php else:?>

          <li class="login-button"><a href="<?=base_url('auth/login')?>"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>

      <?php endif;?>
      </ul>
    </div>
  </div>
</nav>