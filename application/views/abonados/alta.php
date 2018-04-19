

<div class="row header-titulo">
	<div class="col-md">
		<h2>Añadir Abonado</h2>
	</div>
</div>

<?php if (isset($validacion)):?>
<div class="row errores">
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
				<form role="form" id="form_abonados_alta" method="POST" action="<?=base_url('abonados/alta_post');?>" autocomplete="off" novalidate>

					<div class="form-row">
						<div class="form-group col-md-8">
							<label for="descripcion">Descripcion<strong>*</strong></label>
							<input type="text" class="form-control" id="input_descripcion" name="descripcion" placeholder="Descripcion" maxlength="25" requiered>
							<div class="invalid-feedback"></div>
						</div>
						<div class="form-group col-md-4 align-self-center">
							<label for="estado"></label>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="checkbox_estado" name="estado" value="1" checked>
								<label class="form-check-label chk-true" for="checkbox_estado">Habilitado</label>
								<label class="form-check-label chk-false escondido" for="checkbox_estado">Deshabilitado</label>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="cuit" class="control-label">Cuit<strong>*</strong></label>
							<input type="text" class="form-control" id="input_cuit" name="cuit" placeholder="Cuit" maxlength="13">
							<div class="invalid-feedback"></div>
						</div>
						<div class="form-group col-md-8">
							<label for="razonsocial" class="control-label">Razón Social<strong>*</strong></label>
							<input type="text" class="form-control" id="input_razonsocial" name="razonSocial" placeholder="Razon Social" maxlength="75" requiered>
							<div class="invalid-feedback"></div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="telefono">Teléfono<strong>*</strong></label>
							<input type="text" class="form-control" id="input_telefono" name="telefono" placeholder="Teléfono" maxlength="50" requiered>
							<div class="invalid-feedback"></div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="email" class="control-label">E-mail</label>
							<input type="email" class="form-control" id="input_email" name="email" placeholder="E-mail" maxlength="50">
							<div class="invalid-feedback"></div>
						</div>
					</div>
					<div class="form-row form-footer">
						<div class="col">
							<p class="text-muted"><strong>*</strong> Estos campos son obligatorios.</p>
						</div>
						<div class="col text-right">
							<div class="form-group">
								<button class="btn btn-primary" id="submit_abonado" type="sumbit">Agregar Abonado</button>
							</div>
						</div>
					</div>

				</form>
			</div>
		</div>

	</div>
</div>


<script type="text/javascript" src="<?=$this->config->base_url('public/js/_abonados.js');?>"></script>