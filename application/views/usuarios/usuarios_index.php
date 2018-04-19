<link rel="stylesheet" href="<?=base_url('public/css/_usuarios.css')?>">

<div class="row header-titulo">
	<div class="col-md">
		<h2>Usuarios</h2>
	</div>
</div>

<?php if(isset($feedback)):?>
	<div class="row">
		<div class="col-md">
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?=$feedback?>
			</div>
		</div>
	</div>
<?php elseif(isset($error)):?>
	<div class="row">
		<div class="col-md">
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?=$error?>
			</div>
		</div>
	</div>
<?php endif?>

<div class="row filtros">
	<div class="col-md-6 offset-md-3" style="text-align: center">
	<form action="ajax/usuarios/con-filtro" method="GET" id="form_usuarios_filtrar">
		<div class="item-filtro">
			<select class="form-control form-control-sm" name="sector" id="filtro_sector">
				<option value="" selected>Filtrar por sector</option>
				<?php foreach($sectores as $sector):?>
					<option value="<?=$sector['id']?>"><?=$sector['descripcion']?></option>
				<?php endforeach?>
			</select>
		</div>
		<div class="item-filtro">
			<label class="checkbox-inline">
				 <input type="checkbox" name="activos" id="filtro_estado"> Solo Activos
			</label>
		</div>
		<div class="item-filtro">
			<button role="button" class="btn btn-sm btn-outline-secondary" id="filtro_submit">Filtrar</button>
		</div>
	</form>
	</div>
</div>

<div class="row">
	<div class="col-lg-8 offset-lg-2 col-md-12">
		<div class="placeholder error escondido">
			<span id="placeholder_msg_error"></span>
		</div>
		<table class="table table-hover" id="tablaUsuario">
			<thead class="">
				<tr>
					<th scope="col" id="id">Id</th>
					<th scope="col" id="username">Username</th>
					<th scope="col" id="sector">Sector</th>
					<!-- <th scope="col" id="email">E-mail</th> -->
					<th scope="col" id="verPerfil">Perfil</th>
					<th scope="col" id="cambiaEstado">Estado</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($usuarios as $usuario):?>
				<?php if(!$usuario['activo']):?>
					<tr class="usuario-inactivo" id="<?=$usuario['id']?>">
				<?php else:?>
					<tr id="<?=$usuario['id']?>">
				<?php endif?>
						<th scope="row" class="id"><?=$usuario['id']?></th>
						<td class="username"><?=$usuario['username']?></td>
						<td class="sector"><?=$usuario['sector_descripcion']?></td>
						<!-- <td id="email"><?=$usuario['email']?></td> -->
						<td class="perfil">
							<button class="btn btn-outline-info btn-sm ver-perfil" data-toggle="tooltip" data-placement="bottom" title="Ver más información" id="<?=$usuario['id']?>">
								<i class="far fa-user-circle"></i>
							</button>
						</td>
						<td class="estado">
							<a class="btn btn-outline-danger btn-sm baja-usuario <?=$usuario['activo']?'':'escondido'?>" data-toggle="tooltip" data-placement="bottom" title="Deshabilita el usuario" id="<?=$usuario['id']?>">
								<i class="fas fa-ban"></i>
							</a>
							<a class="btn btn-outline-warning btn-sm activa-usuario <?=!$usuario['activo']?'':'escondido'?>" data-toggle="tooltip" data-placement="bottom" title="Reactiva el usuario" id="<?=$usuario['id']?>">
								<i class="fas fa-redo"></i>
							</a>
						</td>

					</tr>
			<?php endforeach?>
			</tbody>
		</table>
	</div>
</div>

<!-- Modal de perfil de usuario -->
<div class="modal fade" id="modal_perfil" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">Información de Perfil</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-lg-3 col-md-12 perfil-icon-placeholder">
					<i class="fas fa-user-circle"></i>

					<div class="perfil-header-icono">
						<p id="perfil_id"></p><p id="perfil_username"></p>
					</div>		

					<span class="badge badge-pill badge-success" id="perfil_sector_descripcion"></span>
				</div>
				<div class="col-lg-9 col-md-12 pefil-info">
					<div class="row">
						<label class="col-lg-2">Nombre </label>
						<div class="col-lg-10">
							<span id="perfil_nombre"></span> <span id="perfil_apellido"></span>
						</div>
					</div>
					<div class="row">
						<label class="col-lg-2">E-mail</label>
						<div class="col-lg-10">
							<span id="perfil_email"></span>
						</div>
					</div>
					<div class="row">
						<label for="fcreado" class="col-lg-2 col-form-label">Fecha de creación</label>
						<div class="col-lg-4">
							<span id="perfil_fecha_creado"></span>
						</div>
						<label for="fmodificado" class="col-lg-2 col-form-label">Fecha de modificación</label>
						<div class="col-lg-4">
							<span id="perfil_fecha_modificado"></span>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
</div>

<script type="text/javascript" src="<?=base_url('public/js/_usuarios.js')?>"></script>


