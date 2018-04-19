<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/_tickets.css')?>">

<div class="row header-titulo">
	<div class="col-md">
		<h2>Nuevo Ticket</h2>
	</div>
</div>

<div class="row">
	<div class="col-md-8 offset-md-2 col-sm-12">
		<div class="errores-validacion alert alert-danger" style="display:none;"></div>
	</div>
</div>

<div class="row">
	<div class="col-md-8 offset-md-2 col-sm-12">
	<form role="form" id="form_ticket_alta" method="POST" action="<?=base_url('tickets/alta_post')?>" autocomplete="off">

		<input id="input_estado" type="hidden" name="estado">
		<input id="input_ticketPrevio_id" type="hidden" name="ticketPrevio_id">
		
		<div class="form-row form-group">
				<div class="col-md-4">
					<label for="titulo">Titulo</label>
					<input type="text" class="form-control" id="input_titulo" name="titulo" maxlength="50">
				</div>
				<div class="col-md-4">
					<?php $this->view('modulos/Abonados_form-busqueda')?>
				</div>
				<div class="col-md-4">
					<label for="prioridad">Prioridad</label>
					<select class="form-control" id="input_prioridad" name="prioridad">
						<option disabled selected>Seleccione un prioridad</option>
						<option value="0">Baja</option>
						<option value="1">Intermedia</option>
						<option value="2">Alta</option>
						<option value="3">Muy Alta</option>
					</select>
				</div>
		</div>
		
		<div class="form-row form-group">
			<div class="col-md-12">
				<label for="cuerpo">Cuerpo</label>
				<textarea class="form-control" rows="13" id="textarea_cuerpo" name="cuerpo" style="resize:vertical;"></textarea>
			</div>
		</div>

		<div class="form-row form-group">
			<div class="col-md" style="text-align: right;">
				<div class="btn-group form-submit" role="group">
					<button id="submit_pendiente" class="btn btn-info btn-lg" type="submit" value="1" name="estado">Pendiente</button>
					<button id="submit_cerrar" class="btn btn-success btn-lg" type="submit" value="3" name="estado">Cerrar</button>
				</div>
			</div>
		</div>
	</form>
	</div>
</div>

<script type="text/javascript" src="<?=base_url('/public/js/_tickets.js')?>"></script>

<?php $this->view('modulos/Abonados_modal-busqueda');?>


<?php if($validacion != ""):?>
	<script type="text/javascript">
		var error = ["<?=trim(preg_replace('/\s+/', ' ', $validacion))?>"];
		cargaErrorValidacion(error);
	</script>
<?php endif?>
