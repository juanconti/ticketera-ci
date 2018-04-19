<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/_tickets.css')?>">

<div class="row header-titulo">
	<div class="col-md">
		<h2>Continuar Ticket</h2>
	</div>
</div>

<div class="row">
	<div class="col-md-8 offset-md-2 col-sm-12">
		<div class="errores-validacion alert alert-danger" style="display:none;"></div>
	</div>
</div>

<div class="form-row">
	<div class="col-md-8 offset-md-2 col-sm-12">
	<form role="form" id="form_ticket_alta" method="POST" action="<?=base_url('tickets/alta_post')?>" autocomplete="off">

		<input id="input_estado" type="hidden" name="estado">
		<input id="input_ticketPrevio_id" type="hidden" name="ticketPrevio_id" value="<?=$ticketPrevio['id']?>">
		<input id="input_abonado_id" type="hidden" 		name="abonado_id" value="<?=$ticketPrevio['abonados_id']?>">
		
		<div class="form-row form-group">
				<div class="col-md-4">
					<label for="titulo">Titulo</label>
					<input type="text" class="form-control" id="input_titulo" name="titulo" maxlength="50">
				</div>
				<div class="col-md-4">
					<label for="abonado_descripcion">Abonado</label>
					<div class="input-group">
						<input type="text" class="form-control" id="input_abonado_descripcion" name="abonado_descripcion" disabled value="<?=$ticketPrevio['abonados_descripcion']?>">
						<div class="input-group-append">
							<button type="button" class="btn btn-info" id="btn_detalle_abonado"><i class="fas fa-info-circle"></i></button>
						</div>
					</div>
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
			<div class="col-md-2">
				<label>Ticket Anterior</label>
				<div class="input-group">
					<div class="input-group">
						<input type="text" id="ticket_previo_id" class="form-control" value="Ticket <?=$ticketPrevio['id']?>" disabled>
						<div class="input-group-append">
							<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_detalleTkPrevio">
								<i class="fas fa-info-circle"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 offset-md-6">
				<label>Usuario Original</label>
				<input type="text" id="usuario_tk_prev" class="form-control" disabled value="<?=$ticketPrevio['usuarios_username']?>">
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

<script type="text/javascript">var base_url = "<?=base_url()?>";</script>
<script type="text/javascript" src="<?=base_url('/public/js/_tickets.js')?>"></script>

<<?php $this->view('modulos/Abonados_modal-busqueda');?>

<!-- Modal de detalle de ticket previo -->
<div class="modal fade" id="modal_detalleTkPrevio" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">	<h4>Detalle de Ticket <?=$ticketPrevio['id']?></h4>	</div>
		<div class="modal-body">
			<div class="detalle_tkPrevio">
				<div class="row">
					<?php if($ticketPrevio['titulo']):?>
					<div class="col-md-12">
						<dt>Titulo</dt>	<?=$ticketPrevio['titulo']?>
					</div>
					<?php endif?>
					<div class="col-md-12">
						<textarea class="form-control" disabled><?=$ticketPrevio['cuerpo']?></textarea>
					</div>
					<div class="col-md">
						<a class="btn btn-link" href="<?=base_url('tickets/ver/'.$ticketPrevio['id'])?>"> Ver el Ticket id <?=$ticketPrevio['id']?></a>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php if($validacion != ""):?>
	<script type="text/javascript">
		var error = ["<?=trim(preg_replace('/\s+/', ' ', $validacion))?>"];
		cargaErrorValidacion(error);
	</script>
<?php endif?>
