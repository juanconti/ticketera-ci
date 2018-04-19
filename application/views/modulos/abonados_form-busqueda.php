<?php
if(!isset($size)) 		$size = null;
if(!isset($wrapper))	$wrapper = null;

switch($size){
	case 'small':
		$formSize 	= 'form-control-sm';
		$btnSize 	= 'btn-sm';
		break;

	case 'large':
		$formSize 	= 'form-control-lg';
		$btnSize 	= 'btn-lg';
		break;

	default:
		$formSize 	= null;
		$btnSize 	= null;
		break;
}
?>
<link rel="stylesheet" href="<?=base_url('public/css/_modulo-busquedaAbonados.css')?>">

<div class="abonado-form-busqueda <?=$wrapper?>">
	<div id="buscador_abonado">
		<?php if($size!=='small'):?>
		<label>Abonado</label>
		<?php endif?>
		<div class="input-group">
			<input id="input_buscaAbonado" type="text" class="form-control <?=$formSize?>"  placeholder="<?=isset($placeholder)?$placeholder:'Seleccion de Abonado'?>">
			<div class="input-group-append">
				<button id="btn_buscaAbonado" class="btn btn-outline-secondary <?=$btnSize?>" type="button"><i class="fas fa-search"></i></button>
			</div>
			<div class="invalid-feedback"> PLACEHOLDER</div>
		</div>
	</div>

	<div id="select_abonado_wrapper" class="escondido">
		<?php if($size!=='small'):?>
		<label for="abonado_id">Seleccione abonado</label>
		<?php endif?>
		<div class="input-group">
			<select class="form-control <?=$formSize?>" id="select_abonado_id">
				<option disabled>Seleccione un abonado</option>
			</select>
			<div class="input-group-append">
				<button type="button" class="btn btn-outline-danger <?=$btnSize?>" id="btn_abonado_reset_select">	<i class="fas fa-redo"></i>			</button>
				<button type="button" class="btn btn-outline-info <?=$btnSize?>" id="btn_detalle_abonado_prev">		<i class="fas fa-info-circle"></i>	</button>
				<button type="button" class="btn btn btn-outline-success btn_selecciona_abonado <?=$btnSize?>">		<i class="fas fa-check"></i>		</button>
			</div>
		</div>
	</div>

	<div id="abonado_seleccionado" class="escondido">
		<?php if($size!=='small'):?>
		<label for="abonado_descripcion">Abonado Seleccionado</label>
		<?php endif?>
		<div class="input-group">
<!--			<div class="input-group-prepend">
				<label class="input-group-text" id="abonado_seleccionado_descripcion" name="abonado_descripcion"></label>
			</div>-->
			 <input type="text" class="form-control <?=$formSize?>" id="abonado_seleccionado_descripcion" name="abonado_descripcion" disabled> 
			<div class="input-group-append">
				<button type="button" class="btn btn-outline-info <?=$btnSize?>" id="btn_detalle_abonado"><i class="fas fa-info-circle"></i></button>
				<button type="button" class="btn btn-outline-danger <?=$btnSize?>" id="btn_abonado_reset_seleccionado"><i class="fas fa-redo"></i></button>
			</div>
		</div>
	</div>

	<input type="hidden" id="input_abonado_id" name="abonado_id">
</div>

<script type="text/javascript">
    let formBusquedaAbonados = {};
    document.addEventListener('DOMContentLoaded',function(){
	formBusquedaAbonados = new FormBusquedaAbonados();
    });
</script>