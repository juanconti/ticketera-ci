<link rel="stylesheet" href="<?= base_url('public/css/_perfil.css')?>">
<?php if(isset($validacion)):?>
	<div class="alert alert-danger">
		<?=$validacion?>
	</div>
<?php endif?>

<?php if(isset($feedback)):?>
	<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?=$feedback?>
	</div>
<?php endif?>

<div class="row header-titulo">
    <div class="col-md">
	<h1>Editar tu Perfil</h1>
    </div>
</div>
<form action="<?=base_url('perfil/editar_post')?>" class="form-horizontal" method="POST">
<div class="row">
    <div class="col-8 offset-2">
	<div class="row form-row">
	    <label for="id" class="col-md-2 col-form-label">Id</label>
	    <div class="col-md-6">
		<input type="text" class="form-control" name="id" value="<?=$usuario['id']?>" disabled>
	    </div>
	</div>
		
	<div class="row form-row">
		<label for="username" class="col-md-2 col-form-label">Usuario</label>
		<div class="col-md-6">
			<input type="text" class="form-control" id="input_username" name="username" value="<?=$usuario['username']?>" disabled>
		</div>
	</div>
	<div class="row form-row">
		<label for="email" class="col-md-2 col-form-label">E-mail</label>
		<div class="col-md-6">
			<input type="text" class="form-control" id="input_email" name="email" value="<?=$usuario['email']?>">
		</div>
	</div>
	<div class="row form-row">
		<label for="nombre" class="col-md-2 col-form-label">Nombre</label>
		<div class="col-md-6">
			<input type="text" class="form-control" id="input_nombre" name="nombre" value="<?=$usuario['nombre']?>">
		</div>
	</div>
	<div class="row form-row">
		<label for="apellido" class="col-md-2 col-form-label">Apellido</label>
		<div class="col-md-6">
			<input type="text" class="form-control" id="input_apellido" name="apellido" value="<?=$usuario['apellido']?>">
		</div>
	</div>
	<div class="row form-row">
		<label for="sector" class="col-md-2 col-form-label">Sector</label>
		<div class="col-md-6">
			<input type="text" class="form-control" id="input_sector" value="<?=$usuario['sectores_descripcion']?>" disabled>
		</div>			
	</div>
	<div class="row form-row">
		<label class="col-md-2 col-form-label">Contraseña</label>
		<div class="col-md-6">
		    <button class="btn btn-primary" id="muestra-modifica-contraseña">Modificar Contraseña</button>
		</div>			
	</div>
    </div>
</div>
<div class="row form-submit">
	<div class="col-md-2 offset-md-8">
		<button class="btn btn-success" type="submit">Guardar Perfil</button>
	</div>
</div>
</form>

<script type="text/javascript" src="<?=base_url('/public/js/_perfil.js')?>"></script>

<!-- Modal de cambio de contraseña -->
<div class="modal fade" id="modal_cambiaContraseña" tabindex="-1" role="dialog">
  <div class="modal-dialog  modal-dialog-centered" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Modifica la Contraseña</h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
	<div class="modal-body"> 
	<div id="error-validacion" style="display:none; padding-bottom: 15px;">
		<div class="alert alert-danger" role="alert">
			<span id="error-validacion-msj"></span>
		</div>
	</div>

		<form action="<?=base_url('perfil/cambiaClave_post')?>" id="form_cambiaContraseña" class="form-horizontal" method="POST">
			<div class="row form-row">
				<label for="oldClave" class="col-md-5 col-form-label">Contraseña Anterior</label>
				<div class="col-md-7">
					<input type="password" class="form-control" id="input_oldClave" name="oldClave">
				</div>	
			</div>
			<div class="row form-row">
				<label for="clave" class="col-md-5 col-form-label">Nueva Contraseña</label>
				<div class="col-md-7">
					<input type="password" class="form-control" id="input_newClave" name="newClave">
				</div>	
			</div>
			<div class="row form-row">
				<label for="claveConfirma" class="col-md-5 col-form-label">Confirme Nueva Contraseña</label>
				<div class="col-md-7">
					<input type="password" class="form-control" id="input_newClaveConfirma" name="newClaveConfirma">
				</div>	
			</div>
	</div>
	<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" class="btn btn-primary" id="btn_cambiaContraseña">Cambiar</button>
			</form>
	</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->