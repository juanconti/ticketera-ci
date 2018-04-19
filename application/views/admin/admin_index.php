<link rel="stylesheet" href="<?=base_url('public/css/_admin.css')?>">

<div class="row header-titulo">
	<div class="col-md">
		<h2>Panel de Admin</h2>
	</div>
</div>

<div class="row">
	<div class="col-md">
		<?php if(isset($validacion)):?>
			<div class="errores-validacion alert alert-danger alert-dismissible fade show">
				<?=$validacion?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif?>

		<?php if(isset($error)):?>
			<div class="alert alert-danger alert-dismissible fade show">
				<?=$error?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif?>

		<?php if(isset($feedback)):?>
			<div class="alert alert-success alert-dismissible fade show">
				<?=$feedback?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif?>
	</div>
</div>
<div class="row">
	<div class="panel-item col-md-3">
		<div class="card sectores-abm">
			<div class="card-header">ABM Sectores</div>
			<div class="card-body">
				<div class="list-group list-group-flush list-sectores">
					<?php foreach ($sectoresExistentes as $sector):?>
					<a href="#" class="edit-sector list-group-item list-group-item-action <?=$sector['activo']?'list-group-item-info':'list-group-item-secondary'?>" id="<?=$sector['id']?>">
						<?=$sector['descripcion']?>
					</a>
					<?php endforeach?>
					<a href="#" class="list-group-item list-group-item-action list-group-item-dark" id="btn_alta_sector"/>
						<i class="fas fa-plus"></i> Agregar nuevo sector
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-item col-md-9">
		<div class="card bitacora-busquedatk">
			<div class="card-header">Bitacora de Tickets</div>
			<div class="card-body">
			<div class="row">
				<div class="col-md-4 col-lg-3">
					<form id="form_bitacora_buscatk" action="#" method="POST">
						<?php $this->view('modulos/Abonados_form-busqueda',['size' => 'small', 'placeholder' => 'Filtrar por Abonado', 'wrapper' => 'form-item'])?>

						<div class="form-item">
							<select class="form-control form-control-sm" name="sector_id" id="bitacora_query_sector">
								<option selected value>Filtrar por sector</option>
								<?php foreach($sectoresExistentes as $sector):?>
									<option value="<?=$sector['id']?>"><?=$sector['descripcion']?></option>
								<?php endforeach?>
							</select>
						</div>

						<div class="input-group form-item">
							<input type="text" class="form-control form-control-sm" id="bitacora_query" name="tickets_id" placeholder="Ingrese el Número de Ticket">
							<div class="input-group-append">
								<button type="button" class="btn btn-default btn-sm" id="btn-busqueda"><i class="fas fa-search"></i></button>
							</div>
						</div>
					</form>
				</div>

				<div class="col-md-8 col-lg-9">
					<div class="tabla-resultados">
						<table class="table table-hover">
						<thead>
							<tr>
								<th>Id</th>
								<th>Titulo</th>
								<th>Usuario</th>
								<th>Sector</th>
								<th></th>
							</tr>
						</thead>

						<tbody>
						</tbody>
						</table>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
	<div class="panel-item col-lg-4 col-md-6">
		<div class="card edita-perfil">
			<div class="card-header">Editar perfil de Usuarios</div>
			<div class="card-body">
				<form action="" id="form_edita_perfil">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-6">
						<input type="text" class="form-control form-control-sm" id="perfil_query_usuario" placeholder="Busca usuario">
					</div>
					<div class="col-sm-11 col-md-10 col-lg-5">
						<select class="form-control form-control-sm" id="perfil_sectores_id">
							<option selected value>Filtrar por sector</option>
							<?php foreach($sectoresExistentes as $sector):?>
								<option value="<?=$sector['id']?>"><?=$sector['descripcion']?></option>
							<?php endforeach?>
						</select>
					</div>
					<div class="col-sm-1 col-md-2 col-lg-1 only-button">
						<button type="submit" class="btn btn-secondary btn-sm" id="btn_busca_usuario"><i class="fas fa-search"></i></button>
					</div>

				</div>
				</form>

				<div id="tabla_resultados_usuarios">
					<div class="row align-items-center result-header">
						<div class="col-sm-4">Username</div>
						<div class="col-sm-4">Sector</div>
					</div>
					<div id="resultados_usuarios"></div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript" src="<?=base_url('/public/js/_admin.js')?>"></script>

<?php $this->view('modulos/Abonados_modal-busqueda')?>


<!-- Modal de edicion de sector -->
<div class="modal fade" id="modal_editar_sector" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	<form action="<?=base_url('admin/edita_sector')?>" method="POST" id="form_edita_sector">
		<div class="modal-body" style="min-height: 300px">
			<div class="row">
					<div class="col-md-2">
						<label for="sector_id">id</label>
						<input class="form-control" type="text" id="input_disabled_sector_id" disabled>
						<input type="hidden" id="input_sector_id" name="sector_id">
					</div>
					<div class="col-md-6">
						<label for="sector_descripcion">Descripcion</label>
						<input class="form-control" type="text" name="sector_descripcion" id="input_sector_descripcion">
					</div>
					<div class="col-md-4">
						<label for="sector_activo">Estado</label>
						<select class="form-control" name="sector_activo" id="select_sector_activo">
							<option value="1">Habilitado</option>
							<option value="0">Deshabilitado</option>
						</select>
					</div>
			</div>
			<div class="row" style="padding-top: 50px">
				<div class="col-md-2">
					<label for="sector_permisos">Permisos del Sector</label>
				</div>
				<div class="col-md-6">
					<div id="select_sector_permisos">
						<?php foreach ($allPermisos as $permiso):?>
							<div class="checkbox">
								<label>
									<input type="checkbox" value="<?=$permiso['id']?>" name="sector_permisos[]"> <?=$permiso['descripcion']?>
								</label>
							</div>
						<?php endforeach?>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary">Guardar</button>
		</div>
	</form>
	</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal de Creación de sector -->
<div class="modal fade" id="modal_alta_sector" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	<form action="<?=base_url('admin/alta_sector')?>" method="POST" id="form_alta_sector">
		<div class="modal-body" style="min-height: 300px">
			<div class="row">
					<div class="col-md-2">
						<label for="sector_id">id</label>
						<input class="form-control" type="text" disabled>
						<input type="hidden" name="sector_id">
					</div>
					<div class="col-md-6">
						<label for="sector_descripcion">Descripcion</label>
						<input class="form-control" type="text" name="sector_descripcion">
					</div>
					<div class="col-md-4">
						<label for="sector_activo">Estado</label>
						<select class="form-control" name="sector_activo">
							<option value="1">Habilitado</option>
							<option value="0">Deshabilitado</option>
						</select>
					</div>
			</div>
			<div class="row" style="padding-top: 50px">
				<div class="col-md-2">
					<label for="sector_permisos">Permisos del Sector</label>
				</div>
				<div class="col-md-6">
					<div id="select_sector_permisos">
						<?php foreach ($allPermisos as $permiso):?>
							<div class="checkbox">
								<label>
									<input type="checkbox" value="<?=$permiso['id']?>" name="sector_permisos[]"> <?=$permiso['descripcion']?>
								</label>
							</div>
						<?php endforeach?>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary">Guardar</button>
		</div>
	</form>
	</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal de perfil de usuario -->
<div class="modal fade" id="modal_perfil" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Perfil de <span id="perfil_username">[...]</span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
					<div class="form-row form-group">
						<label class="col-lg-1 col-md-2 col-form-label">Nombre </label>
						<div class="col-lg-5 col-md-4 col-sm-6">
							<input type="nombre" class="form-control" id="perfil_nombre" name="nombre">
						</div>
						<label class="col-lg-1 col-md-2 col-form-label">Apellido </label>
						<div class="col-lg-5 col-md-4 col-sm-6">
							<input type="apellido" class="form-control" id="perfil_apellido" name="apellido">
						</div>
					</div>
					<div class="form-row form-group">
						<label for="email" class="col-lg-1 col-md-2 col-form-label">E-mail</label>
						<div class="col-lg-4 col-md-4">
							<input type="email" id="perfil_email" name="email" class="form-control">
						</div>
					</div>
					<div class="form-row form-group perfil-submit-row">
						<div class="col-lg-4 offset-lg-8">
							<button type="button" class="btn btn-primary" id="perfil_guardacambios">Guardar Cambios</button>
						</div>
					</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal de edicion de clave de usuario -->
<div class="modal fade" id="modal_cambiaclave_usuario" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Modificar Contraseña</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<form method="POST" action="<?=base_url('admin/modificaclave/')?>">
	<div class="modal-body">
		<div class="form-row form-group">
			<div class="col-sm-12 form-group">
				<label for="new-clave">Nueva Contraseña</label>
				<input type="password" id="perfil_contraseña" name="new-clave" class="form-control">
			</div>
			<div class="col-sm-12 form-group">
				<label for="new-clave-repetida">Repita la Nueva Contraseña</label>
				<input type="password" id="perfil_contraseña_repetida" name="new-clave-repetida" class="form-control">
			</div>
		</div>
		<div class="row perfil-submit-row">
			<div class="col-lg-12 text-right">
				<button type="submit" class="btn btn-sm btn-success">Cambiar Contraseña</button>
			</div>
		</div>
		<input type="hidden" id="cambiaclave_usuarios_id" name="usuarios_id">
	</div>
	</form>
	</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

	
