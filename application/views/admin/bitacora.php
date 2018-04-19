<?php $dateFormat = 'H:i d-m-y';?>

<link rel="stylesheet" href="<?=base_url('public/css/_admin.css')?>">


<div class="row header-titulo">
	<div class="col-md">
		<h2>Bitacora del Ticket <a href="<?=base_url('tickets/ver/'.$bitacoraTk[0]['tickets_id'])?>">Id <?=$bitacoraTk[0]['tickets_id']?></a></h2>
	</div>
</div>

<div class="row tabla-bitacora">
	<div class="col-lg-10 offset-lg-1">
		<table class="table table-hover">
		<thead>
			<tr>
				<th>id Bitacora</th>
				<th>Titulo</th>
				<th>Usuario</th>
				<th>Sector</th>
				<th>Estado</th>
				<th>Fecha</th>
				<th></th>
			</tr>
		</thead>

		<tbody>
		<?php foreach($bitacoraTk as $iteracionTk):?>
			<tr>
				<td><?=$iteracionTk['id']?></td>
				<td><?=$iteracionTk['titulo']?></td>
				<td><?=$iteracionTk['usuario_username']?></td>
				<td><?=$iteracionTk['sector_descripcion']?></td>
				<td><?=$iteracionTk['estado_descripcion']?></td>
				<td><?=date($dateFormat, strtotime($iteracionTk['fecha']))?></td>
				<td>
					<button class="btn btn-outline-primary btn-xs modal-bitacora" id="bitacora<?=$iteracionTk['id']?>">
						<i class="fas fa-info-circle"></i>
					</button>
				</td>
			</tr>
		<?php endforeach?>
		</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">var base_url = "<?=base_url()?>";</script>
<script type="text/javascript" src="<?=base_url('/public/js/_admin.js')?>"></script>

<!-- Modal de detalle de ticket previo -->
<div class="modal fade" id="modal_detalleBitacoraModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4>Detalle de Bitacora</h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-6 wrapper-detalleBitacora">
					<label>Titulo</label>
					<input class="form-control" id="bitacora_titulo" disabled/>
				</div>
				<div class="col-md-6 wrapper-detalleBitacora">
					<label>Abonado</label>
					<input class="form-control" id="bitacora_abonado_descripcion" disabled/>
				</div>
				<div class="col-md-6 wrapper-detalleBitacora">
					<label>Usuario</label>
					<input class="form-control" id="bitacora_usuario_descripcion" disabled/>
				</div>
				<div class="col-md-6 wrapper-detalleBitacora">
					<label>Sector</label>
					<input class="form-control" id="bitacora_sector_descripcion" disabled/>
				</div>
				<div class="col-md-12 wrapper-detalleBitacora">
					<label>Cuerpo</label>
					<textarea class="form-control" id="bitacora_cuerpo" style="resize:none; min-height: 150px;" disabled></textarea>
				</div>
				<div class="col-md-6 wrapper-detalleBitacora">
					<label>Relacion</label>
					<input class="form-control" id="bitacora_relacion" disabled/>
				</div>
				<div class="col-md-6 wrapper-detalleBitacora">
					<label>Estado</label>
					<input class="form-control" id="bitacora_estado_descripcion" disabled/>
				</div>
			</div>
		</div>
	</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
