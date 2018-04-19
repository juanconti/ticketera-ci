<link rel="stylesheet" href="<?=base_url('public/css/_usuarios.css')?>">

<div class="row header-titulo">
	<div class="col-md">
	<?php if($usuario['nombre'] !== ''):?>
		<h2>Perfil de <?=ucfirst($usuario['nombre']).' '.ucfirst($usuario['apellido'])?></h2>
	<?php else:?>
		<h2>Perfil de <?=$usuario['username']?></h2>
	<?php endif?>
	</div>
</div>

<div class="row align-items-center">
	<div class="col-lg-2 col-md-12 perfil-icon-placeholder">
		<i class="fas fa-user-circle"></i><br>
		<p>usuario id <?=$usuario['id']?></p>
	</div>
	<div class="col-lg-6 col-md-12 pefil-info">
		<div class="form-row form-group">
			<label class="col-lg-1 col-md-2 col-form-label">Nombre </label>
			<div class="col-lg-5 col-md-4 col-sm-6">
				<input type="nombre" class="form-control" id="input_nombre" name="nombre" placeholder="Nombre" value="<?=$usuario['nombre']?>">
			</div>
			<div class="col-lg-5 col-md-4 col-sm-6">
				<input type="apellido" class="form-control" id="input_apellido" name="apellido" placeholder="Apellido" value="<?=$usuario['apellido']?>">
			</div>
		</div>
		<div class="form-row form-group">
			<label for="email" class="col-lg-1 col-md-2 col-form-label">E-mail</label>
			<div class="col-lg-4 col-md-4">
				<input type="email" class="form-control" value="<?=$usuario['email']?>">
			</div>
		</div>
		<div class="form-row form-group">
			<label for="sector" class="col-lg-1 col-md-2col-form-label">Sector</label>
			<div class="col-lg-1 col-md-1 col-sm-2">
				<input class="form-control" name="sector_id" value="<?=$usuario['sectores_id']?>">
			</div>
			<div class="col-lg-3 col-md-6 col-sm-10">
				<input class="form-control" name="sector_descripcion" value="<?=$usuario['sectores_descripcion']?>">
			</div>
		</div>
		<div class="form-row form-group">
			<label for="fcreado" class="col-md-2 col-form-label">Fecha de creación</label>
			<div class="col-lg-2 col-md-9">
				<input class="form-control" name="fcreado" value="<?=$usuario['created_at']?>">
			</div>
			<label for="fmodificado" class="col-md-2 col-form-label">Fecha de modificación</label>
			<div class="col-lg-2 col-md-9">
				<input class="form-control" name="sector_descripcion" value="<?=$usuario['updated_at']?>">
			</div>
		</div>
	</div>
</div>
