<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/_tickets.css')?>">

<div class="row header-titulo">
	<div class="col-md">
		<h2>Editar Ticket</h2>
	</div>
</div>


<div class="row">
	<div class="col-md-8 offset-md-2 col-sm-12">
		<div class="errores-validacion alert alert-danger" style="display:none;"></div>
	</div>
</div>

<div class="row">
	<div class="col-md-8 offset-md-2 col-sm-12">
		<form role="form" id="form_ticket_alta" method="POST" action="<?=base_url('tickets/editar_post')?>" autocomplete="off">
				<input type="hidden" name="tickets_id" value="<?=$ticket['id']?>">
				<input type="hidden" id="input_abonado_id" name="abonado_id" value="<?=$abonado['id']?>">

				<div class="form-row form-group">
						<div class="col-md-4">
							<label for="titulo">Titulo</label>
							<input type="text" class="form-control" id="input_titulo" name="titulo" value="<?=trim($ticket['titulo'])?>">
						</div>
						<div class="col-md-4">
							<label for="abonado_descripcion">Abonado</label>
							<div class="input-group">
								<input type="text" class="form-control" id="input_abonado_descripcion" name="abonado_descripcion" value="<?=trim($abonado['descripcion'])?>" disabled>
								<div class="input-group-append">
									<button type="button" class="btn btn-info" id="btn_detalle_abonado"><i class="fas fa-info-circle"></i></button>		
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<label for="prioridad">Prioridad</label>
							<select class="form-control" id="input_prioridad" name="prioridad">
								<option disabled <?php if($ticket['prioridad']==null) print "selected"?>>Seleccione un prioridad</option>
								<option value="0" <?php if($ticket['prioridad']==0) print "selected"?>>Baja</option>
								<option value="1" <?php if($ticket['prioridad']==1) print "selected"?>>Intermedia</option>
								<option value="2" <?php if($ticket['prioridad']==2) print "selected"?>>Alta</option>
								<option value="3" <?php if($ticket['prioridad']==3) print "selected"?>>Muy Alta</option>
							</select>
						</div>
				</div>

				<?php if($ticket['relacion'] !== '0'):?>
				<div class="form-row form-group">
					<div class="col-md-4">
						<label for="abonado_descripcion">Ticket Anterior</label>
						<div class="input-group">
							<input type="text" class="form-control" id="id_ticket_previo" disabled value="<?=$ticket['relacion']?>">
							<div class="input-group-append">
								<button type="button" class="btn btn-info" id="btn_detalle_tkPrevio">
									<i class="fas fa-info-circle"></i>
								</button >
							</div>
						</div>
					</div>
				</div>
				<?php endif?>

				<div class="form-row form-group">
					<div class="col-md-12">
						<label for="cuerpo">Cuerpo</label>
						<textarea class="form-control" rows="8" id="textarea_cuerpo" name="cuerpo" style="resize:vertical;"><?=trim($ticket['cuerpo'])?></textarea>
					</div>
				</div>
				
				<div class="form-row form-group">
					<div class="col-md-3 offset-md-9" style="text-align: right;">
						<div class="input-group">
							<select class="form-control" id="select_estado" name="estado">
							<?php if($ticket['estado'] == 1 || $ticket['estado'] == 3):?>
								<option value="1" <?php if($ticket['estado'] == 1) print 'selected'?>>Pendiente</option>
								<option value="3" <?php if($ticket['estado'] == 3) print 'selected'?>>Cerrado</option>
							<?php else:?>
								<option value="2" <?php if($ticket['estado'] == 2) print 'selected'?>>Continuado</option>
							<?php endif?>
							</select>
							<div class="input-group-append">
								<button class="btn <?php if($ticket['estado'] == 3) print 'btn-warning';else print 'btn-danger';?>" type="submit" id="submit_edit">Editar</button>
							</div>
						</div>
					</div>
				</div>
		</form>
	</div>
</div>

<script type="text/javascript">var base_url = "<?=base_url()?>";</script>
<script type="text/javascript" src="<?=base_url('/public/js/_tickets.js')?>"></script>

<?php $this->view('modulos/Abonados_modal-busqueda');?>

<!-- Modal de detalle de ticket previo -->
<div class="modal fade" id="modal_detalleTkPrevio" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h4>Detalle de Ticket Anterior</h4>
		</div>
		<div class="modal-body">
			<div class="detalle_tkPrevio">
				<div class="row">
					<div class="col-sm-6">
						<dl>
							<dt>ID</dt>
							<dd><?=$ticket['relacion']?></dd>
						</dl>
					</div>
					<div class="col-sm-6">
						<dl>
							<dt>Titulo</dt>
							<dd><span id="ticket_prev_titulo"></span></dd>
						</dl>
					</div>
					<div class="col-md-12">
						<label>Cuerpo</label>
						<textarea class="form-control" id="ticket_prev_cuerpo" style="resize:none;" disabled></textarea>
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