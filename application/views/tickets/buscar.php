<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/_tickets.css')?>">

<div class="row header-titulo">
	<div class="col-md">
		<h2>Buqueda de Tickets</h2>
	</div>
</div>

<div class="row busqueda">
	<div class="col-lg-2 col-md-4 col-sm-12">
		<div class="busqueda-parametros">
				<form action="/" id="form_busqueda_tk">
					<div class="item-parametro">
						<label for="query_usuario">Por Usuario</label>
						<select class="form-control form-control-sm" id="query_usuario" name="usuario">
							<option selected value>Filtrar por Usuario</option>
							<?php foreach($usuariosDeSector as $usuario):?>
								<option value="<?=$usuario['id']?>"><?=ucfirst($usuario['username'])?></option>
							<?php endforeach?>
						</select>
					</div>
					
					<div class="item-parametro">
						<label>Por Abonado</label>
						<?php $this->view('modulos/Abonados_form-busqueda', ['size' => 'small', 'placeholder' => 'Filtrar por Abonado']) ?>
					</div>

					<div class="item-parametro">
						<label for="estados_id">Por Estado</label>
						<select class="form-control form-control-sm" id="query_estado" name="estados_id">
							<option selected value>Filtrar por Estado</option>
							<?php foreach($tkEstados as $tkEstado):?>
								<option value="<?=$tkEstado['id']?>"><?=ucfirst($tkEstado['descripcion'])?></option>
							<?php endforeach?>
						</select>
					</div>

					<div class="item-parametro">
						<label for="tickets_id">Por Número de Ticket</label>
						<input type="text" class="form-control form-control-sm" id="query_ticket_id" name="tickets_id" placeholder="Buscar por id de Ticket">
						<div class="invalid-feedback"></div>
					</div>

					<div class="item-parametro">
						<label for="query_order_by">Ordenar Por</label>
						<select class="form-control form-control-sm" id="query_order_by" name="query_order_by">
							<option selected value>Ordenar por</option>
							<option value="estado">Estado</option>
							<option value="prioridad">Prioridad</option>
							<option value="antiguos_primero">Antiguos Primero</option>
							<option value="recientes_primero">Recientes Primero</option>
						</select>
					</div>
					
					<div class="item-parametro">
						<button type="button" class="btn btn-success btn-block" id="btn_busqueda">Buscar</button>
					</div>
				</form>
		</div> 
	</div>

	<div class="col-lg-10 col-md-8 col-sm-12">
		<div class="resultados-tickets escondido">
			<table class="table table-hover table-sm">
				<thead>
					<tr>
						<th>Id</th>
						<th>Titulo</th>
						<th>Cuerpo</th>
						<th>Abonado</th>
						<th>Usuario</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Id</td>
						<td>Titulo</td>
						<td>Cuerpo</td>
						<td>Abonado</td>
						<td>Usuario</td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="row loading-screen">
			<div class="col">
				<p>Indique los parámetros de la busqueda</p>
			</div>
		</div>
	</div>
</div>


<?php $this->view('modulos/Abonados_modal-busqueda')?>
<script type="text/javascript" src="<?=base_url('public/js/_busquedaTickets.js')?>"></script>
