<link rel="stylesheet" href="<?=base_url('public/css/_usuarios.css')?>">

<div class="row header-titulo">
	<div class="col-md">
		<h2>Añadir Usuario</h2>
	</div>
</div>

<?php if(isset($validacion)):?>
	<div class="row justify-content-center">
		<div class="col-md-12 col-lg-6">
			<div class="errores-validacion alert alert-danger">
				<?=$validacion?>
			</div>
		</div>
	</div>
<?php endif?>

<div class="row justify-content-center">
	<div class="col-md-12 col-lg-6">

		<div class="card form-alta">
			<div class="card-body col-md">
				<form role="form" id="form_usuarios_alta" method="POST" action="<?=base_url('usuarios/alta_post')?>" autocomplete="off" novalidate>
					
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="username">Usuario<strong>*</strong></label>
							<input type="text" class="form-control" maxlength="15" id="input_username" name="username" placeholder="Username" value="<?=$oldValues['username']?>" required>
							<div class="invalid-feedback"></div>
						</div>
						<div class="form-group col-md-4 offset-md-2 align-self-center">
							<label for="activo"></label>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="checkbox_estado" name="estado" value="1" checked>
								<label class="form-check-label chk-true" for="checkbox_estado">Habilitado</label>
								<label class="form-check-label chk-false escondido" for="checkbox_estado">Deshabilitado</label>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="sector">Sector<strong>*</strong></label>
							<select class="form-control" id="select_sector" name="sector" required>
								<option value="" disabled <?=$oldValues['sector']?'':'selected'?>>Seleccione un sector</option>
								<?php
								foreach($sectores as $sector)
									if($sector['id'] !== '1' && $sector['id'] === $oldValues['sector'])
										print '<option value="' . $sector['id'] . '" selected>' . $sector['descripcion'] . '</option>';
									else if($sector['id'] !== '1')
										print '<option value="' . $sector['id'] . '">' . $sector['descripcion'] . '</option>';
								?>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md">
							<label for="nombre" class="control-label">Nombre</label>
							<input type="nombre" class="form-control" id="input_nombre" name="nombre" placeholder="Nombre" value="<?=$oldValues['nombre']?>">
							<div class="invalid-feedback"></div>
						</div>
						<div class="form-group col-md">
							<label for="apellido" class="control-label">Apellido</label>
							<input type="apellido" class="form-control" id="input_apellido" name="apellido" placeholder="Apellido" value="<?=$oldValues['apellido']?>">
							<div class="invalid-feedback"></div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-8">
							<label for="email" class="control-label">E-mail</label>
							<input type="email" class="form-control" id="input_email" name="email" placeholder="E-mail" value="<?=$oldValues['email']?>">
							<div class="invalid-feedback"></div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md">
							<label for="password" class="control-label">Contraseña<strong>*</strong></label>
							<input type="password" class="form-control" id="input_password" name="password" placeholder="Contraseña" required>
							<div class="invalid-feedback"></div>
						</div>
						<div class="form-group col-md">
							<label for="passwordConfirma" class="control-label">Confirmar Contraseña<strong>*</strong></label>
							<input type="password" class="form-control" id="input_passwordConfirma" name="passwordConfirma" placeholder="Confirmar contraseña" requiered>
							<div class="invalid-feedback"></div>
						</div>
					</div>
					<div class="form-row form-footer">
						<div class="col">
							<p class="text-muted"><strong>*</strong> Estos campos son obligatorios.</p>
						</div>
						<div class="col text-right">
							<div class="form-group">  <button class="btn btn-primary" id="submit_usuario" type="sumbit">Agregar Usuario</button>  </div>
						</div>
					</div>

				</form>
			</div>
		</div>
		
	</div>
</div>

<script type="text/javascript" src="<?=base_url('public/js/_usuarios.js')?>"></script>
