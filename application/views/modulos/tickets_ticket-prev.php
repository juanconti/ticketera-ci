<?php $dateFormat = 'H:i d-m-y';?>

<div class="ticket-prev">
	<div class="ticket-prev-head">
			<div class="row">
				<div class="col-xs-6 col-md-9">
					<h5><b>
						<?=$titulo?>
						<?php if($estado == 1):?>			<div class="label label-warning">	Pendiente</div>
						<?php elseif($estado == 2):?>		<div class="label label-info">		Cerrado	 </div>
						<?php elseif($estado == 3):?>		<div class="label label-default">	Continuado</div>
						<?php endif?>
					</h5></b>
				</div>
					
				<div class="col-xs-6 col-md-3 ticket-date">
					<p><?=date($dateFormat, strtotime($fcreado))?></p>
				</div>
			</div>
			
	</div>
	<div class="ticket-prev-cuerpo">
			<p>
			<?=substr($cuerpo,0,300)?>
			<?php if(strlen($cuerpo) > 300) print "<b>...</b>"?>
			</p>
	</div>

	<div class="ticket-prev-footer">
		<div class="btn-group" role="group">
			<a role="button" class="btn btn-default btn-sm"	href="<?=base_url('tickets/ver/'.$id)?>">				Detalles</a>
			<?php if($usuarios_id == $_SESSION['usuario']['id'] || tienePermisos(['ADMIN'])):?>
			<a role="button" class="btn btn-warning btn-sm"	href="<?=base_url("tickets/editar/".$id)?>">		Editar	</a>
			<?php else:?>
			<button role="button" class="btn btn-warning btn-sm" disabled>													Editar	</button>
			<?php endif?>
			<a role="button" class="btn btn-primary btn-sm"	href="<?=base_url("tickets/continuar/".$id)?>">			Seguir	</a>
		</div>
	</div>
</div>