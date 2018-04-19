<div class="row header-titulo">
	<div class="col-md">
		<h2>Editar Abonado</h2>
	</div>
</div>

<?php if (isset($validacion)):?>
<div class="row errores">
	<div class="col-md-12 col-lg-6 offset-lg-3">
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
				<form role="form" id="form_edita_abonado" method="POST" action="<?=base_url('abonados/edita_post')?>" autocomplete="off" novalidate>

					<div class="form-row">
						<div class="form-group col-md-8">
							<label for="descripcion">Descripcion</label>
							<input type="text" class="form-control" id="input_descripcion" name="descripcion" value="<?=$abonado['descripcion']?>" placeholder="Descripcion" maxlength="25">
							<div class="invalid-feedback"></div>
						</div>
						<div class="form-group col-md-4 align-self-center">
							<label for="estado"></label>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="checkbox_estado" name="estado" value="1" <?=!$abonado['activo']?:'checked'?>>
								<label class="form-check-label chk-true" for="checkbox_estado">Habilitado</label>
								<label class="form-check-label chk-false escondido" for="checkbox_estado">Deshabilitado</label>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="cuit" class="control-label">Cuit</label>
							<input type="text" class="form-control" id="input_cuit" name="cuit" value="<?=$abonado['cuit']?>" placeholder="Cuit" maxlength="13">
							<div class="invalid-feedback"></div>
						</div>
						<div class="form-group col-md-8">
							<label for="razonsocial" class="control-label">Razón Social</label>
							<input type="text" class="form-control" id="input_razonsocial" name="razonSocial" value="<?=$abonado['razonsocial']?>" maxlength="75">
							<div class="invalid-feedback"></div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="telefono">Teléfono</label>
							<input type="text" class="form-control" id="input_telefono" name="telefono" value="<?=$abonado['telefono']?>" placeholder="Teléfono" maxlength="50">
							<div class="invalid-feedback"></div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="email" class="control-label">E-mail</label>
							<input type="email" class="form-control" id="input_email" name="email" value="<?=$abonado['email']?>" placeholder="E-mail" maxlength="50">
							<div class="invalid-feedback"></div>
						</div>
					</div>
					<div class="form-row form-footer">
						<div class="col text-right">
							<div class="form-group">
								<button class="btn btn-primary" id="submit_abonado" type="sumbit">Guardar Cambios</button>
							</div>
						</div>
					</div>
				<input type="hidden" name="abonados_id" value="<?=$abonado['id']?>">
				</form>
			</div>
		</div>

	</div>
</div>


<script type="text/javascript" src="<?=$this->config->base_url('public/js/_abonados.js');?>"></script>