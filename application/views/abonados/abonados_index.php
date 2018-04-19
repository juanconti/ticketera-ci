<link rel="stylesheet" href="<?=base_url('public/css/_abonados.css')?>">

<div class="row header-titulo">
	<div class="col-md">
		<h2>Abonados</h2>
	</div>
</div>

<?php if (isset($feedback)):?>
<div class="row">
	<div class="col-md-12 col-lg-12">
		<div class="feedback alert alert-success alert-dismissible fade show" role="alert">
			<?=$feedback?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</div>
</div>
<?php endif?>

<div class="row form-busqueda">
	<div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-10 offset-sm-1 col-busqueda-serchbar">
	<form action="#" class="form-inline" method="GET" id="form_busca_abonado">
		<input class="form-control" id="buscador_query" name="query" type="search" placeholder="Buscar por descripción, cuit o id" value="<?=$query?>"><i class="fas fa-search"></i>
	</div>
	<div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-10 offset-sm-1 col-busqueda-filtros">
		<div class="busqueda-filtro">
			<div class="item-filtro">
				<label class="checkbox-inline">
					 <input type="checkbox" name="activos" id="buscador_estado" <?=$activos=='false'?'':'checked'?>> Solo Activos
				</label>
			</div>
			<div class="item-filtro">
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="criterio" id="radio_descripcion" value="descripcion" checked>
					<label class="form-check-label" for="radio_descripcion">Descripción</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="criterio" id="radio_cuit" value="cuit">
					<label class="form-check-label" for="radio_cuit">Cuit</label>
				</div>
			</div>
			<button type="submit" id="buscador_submit" class="btn btn-sm btn-outline-secondary">Filtrar</button>
		</div>
	</form>
	</div>
</div>

<div class="row">
	<div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
		<div class="placeholder">
			<span id="placeholder_msg">Realize la busqueda del abonado</span>
		</div>
		<div class="placeholder error escondido">
			<span id="placeholder_msg_error"></span>
		</div>
		<input type="hidden" id="input_abonado_id">
		<table class="table table-hover" id="tabla_abonados" style="display: none;">
			<thead>
				<tr>
					<th style="width: 75px">Id</th>
					<th>Descripcion</th>
					<th>Cuit</th>
					<th>Telefono</th>
					<th>E-mail</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
			</tbody>
		</table>
	</div>
</div>


<?php $this->view('modulos/Abonados_modal-busqueda')?>
<script type="text/javascript" src="<?=base_url('public/js/_abonados.js')?>"></script>
<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function(){
		(() => {
			var prevQuery 	= "<?=$query?>";
			var activos 	= "<?=$activos?>"
			if(prevQuery)
				$('#form_busca_abonado').submit();
		})();	
	});
</script>