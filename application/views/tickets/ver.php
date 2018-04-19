<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/_tickets.css')?>">

<div class="row">
	<div class="errores-validacion alert alert-danger" style="display:none;"></div>
</div>

<div class="row form-group">
		<div class="col-md-5">
			<label for="titulo">Titulo</label>
			<input type="text" class="form-control" value="<?=trim($ticket['titulo'])?>" disabled>
		</div>
		<div class="col-md-3">
			<label for="prioridad">Prioridad</label>
			<?php if($ticket['prioridad']==null):?> <input class="form-control" value="Sin Prioridad" disabled/>
			<?php elseif($ticket['prioridad']==0):?><input class="form-control" value="Baja" disabled/>
			<?php elseif($ticket['prioridad']==1):?><input class="form-control" value="Intermedia" disabled/>
			<?php elseif($ticket['prioridad']==2):?><input class="form-control" value="Alta" disabled/>
			<?php elseif($ticket['prioridad']==3):?><input class="form-control" value="Muy Alta" disabled/>
			<?php endif?>
		</div>
		<div class="col-md-4">
			<label>Estado</label>
			<?php if($ticket['estado'] == 1):?>
				<input class="form-control" value="Pendiente" disabled/>
			<?php elseif($ticket['estado'] == 2):?>
				<input class="form-control" value="Continuado" disabled/>
			<?php elseif($ticket['estado'] == 3):?>
				<input class="form-control" value="Cerrado" disabled/>
			<?php endif?>
		</div>
</div>

<div class="row form-group">
	<div class="col-md-4">
		<label for="abonado_descripcion">Abonado</label>
		<div class="input-group">
				<input type="text" class="form-control" value="<?=trim($abonado['descripcion'])?>" disabled>
				<span class="input-group-append">
					<button type="button" class="btn btn-info" id="btn_detalle_abonado"><i class="fas fa-info-circle"></i></button>		
				</span>
			</div>
	</div>
	<?php if($ticket['relacion'] !== '0'):?>
	<div class="col-md-4">
		<label for="abonado_descripcion">Ticket Anterior</label>
		<div class="input-group">
			<input type="text" id="id_ticket_previo" class="form-control" value="<?=$ticket['relacion']?>" disabled>
			<span class="input-group-btn">
				<a class="btn btn-info" id="btn_detalle_tkPrevio">
					<span class="glyphicon glyphicon-list-alt"></span>
				</a>
			</span>
		</div>
	</div>
	<div class="col-md-4">
	<?php elseif($ticket['estado'] == '2'):?>
	<div class="col-md-4">
		<label for="abonado_descripcion">Ticket Posterior</label>
		<div class="input-group">
			<input type="text" id="id_ticket_posterior" class="form-control" value="<?=$ticketPosterior['id']?>" disabled>
			<span class="input-group-btn">
				<a class="btn btn-success" href="<?=base_url('/tickets/ver/'.$ticketPosterior["id"])?>" id="btn_detalle_tkPosterior">
					<span class="glyphicon glyphicon-list-alt"></span>
				</a>
			</span>
		</div>
	</div>
	<div class="col-md-4">
	<?php else:?>
	<div class="col-md-4 col-md-offset-4">
	<?php endif;?>
		<label for="Usuario">Usuario</label>
		<input class="form-control" value="<?=$ticket['usuarios_username']?>" disabled/>
	</div>
	<input type="hidden" id="input_abonado_id" name="abonado_id" value="<?=$abonado['id']?>">
</div>

<div class="row form-group">
	<div class="col-md-12">
		<label for="cuerpo">Cuerpo</label>
		<textarea class="form-control" rows="8" style="resize:vertical;" disabled><?=trim($ticket['cuerpo'])?></textarea>
	</div>
</div>

<div class="row form-group">
	<div class="col-md-3 col-md-offset-9" style="text-align: right;">
		<?php if($ticket['estado'] == 3 || $ticket['estado'] == 1):?>
			<div class="btn-group">
				<a class="btn btn-warning" href="<?=base_url('tickets/editar/'.$ticket['id'])?>">		Editar		</a>
				<a class="btn btn-primary" href="<?=base_url('tickets/continuar/'.$ticket['id'])?>">	Continuar	</a>
			</div>
		<?php endif?>
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
