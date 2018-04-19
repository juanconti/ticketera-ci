document.addEventListener('DOMContentLoaded', function() {
	let sectorABM = new SectorABM();

	//Muestra el modal de edición de sector
	$('.edit-sector').click(function(e){
		e.preventDefault();
		let sectorId = $(this).attr('id');

		$.get(base_url+'ajax/sector/'+sectorId, function(data){
			sectorABM.cargaModalEditaSector(data);
			$('#modal_editar_sector').modal('show');
		});
	});

	//Muestra el modal con el formulario de alta de sectores
	$('#btn_alta_sector').click(function(e){
		$('#modal_alta_sector').modal('show');
	});

	$('#modal_editar_sector').on('hidden.bs.modal', function(){
		sectorABM.resetModalEditaSector();
	});

	/*** Buscador de ticket para bitacora ***/
	$('#btn-busqueda').click(function(e) {
		var abonado_id 	= $('[name=abonado_id]').val();
		var sector_id 	= $('[name=sector_id]').val();
		var tickets_id 	= $('[name=tickets_id]').val();
	});


	/*** Ver modal de detalle de bitacora ***/
	$('button.modal-bitacora').click(function(e){
		var id = $(this).attr('id').replace('bitacora','');

		let bitacora = new BitacoraViewer();

		$(this).attr('disabled', true);

		$.get(base_url + 'ajax/bitacora/' + id,
			(data) => {
				console.log(data);
				bitacora.cargarModal(data);
				$('#modal_detalleBitacoraModal').modal('show');
				$(this).attr('disabled', false);
			});
	});

	$('#modal_detalleBitacoraModal').on('hidden.bs.modal', function(e){
		bitacora.resetModal()
	});

	$('#form_edita_perfil').submit(function(e){
		e.preventDefault();
		document.querySelector('#btn_busca_usuario').setAttribute('disabled', true);
		if(typeof perfil == 'undefined')
			perfil = new ModificadorPerfil();

		perfil.setQueryBuscarUsuarios();
		perfil.buscarUsuarios();
		document.querySelector('#btn_busca_usuario').removeAttribute('disabled');
	});
	
});

//Constructor de objeto de ABM de Sector
function SectorABM(){
	this.cargaModalEditaSector = function(sector){
		let permisos = sector.permisos;
		console.log(sector);

		$('#input_disabled_sector_id').val(sector.id);
		$('#input_sector_id').val(sector.id);
		$('#input_sector_descripcion').val(sector.descripcion);
		if(sector.activo == 1)
			$('#select_sector_activo option[value=1]').prop('selected', true);
		else
			$('#select_sector_activo option[value=0]').prop('selected', true);


		//Se cargan los permisos
		if(permisos.length > 1){
			for (var i = permisos.length - 1; i >= 0; i--){
				var id = permisos[i].id;
				$('#select_sector_permisos input[type=checkbox][value='+id+']').prop('checked', true);
			}
		} 
		else
			$('#select_sector_permisos input[type=checkbox][value='+permisos[0].id+']').prop('checked', true);
	}

	this.resetModalEditaSector = function(){
		$('#input_disabled_sector_id').val('');
		$('#input_sector_id').val('');
		$('#input_sector_descripcion').val('');
		$('#select_sector_activo option:selected').prop('selected', false);
		$('#select_sector_permisos input:checked').prop('checked', false);
	}
}

//Constructor de objeto de Modificador de pefil de usuario
function ModificadorPerfil(){
	this.query = {};
	this.selectedUsuario = {};

	this.setQueryBuscarUsuarios = function()
	{
		this.query.queryUsuario = $('#perfil_query_usuario').val();
		this.query.sectores_id 	= $('#perfil_sectores_id').val();
	}

	this.buscarUsuarios = function()
	{
		if(this.query.sectores_id !== '' || this.query.queryUsuario !== ''){
			$('#tabla_resultados_usuarios').slideUp();
			$.post(
				base_url+'ajax/buscarUsuarios',
				this.query,
				(data) => {
					$('div#resultados_usuarios').html('');
					if(data.length > 0){
						this.renderResultadosUsuarios(data);
						$('#tabla_resultados_usuarios').slideDown();
					}
			});
		}		
	}

	this.renderResultadosUsuarios = function(usuarios)
	{
		let resultsFragment = document.createDocumentFragment();

		for(var i = 0; i < usuarios.length; i++){
			var usuarioWapper = document.createElement('div');
				usuarioWapper.classList.add('row', 'align-items-center','result-item');
				usuarioWapper.id = 'usuario-'+usuarios[i].id;

				var usuarioUsername = document.createElement('div');
					usuarioUsername.classList.add('col-sm-4', 'usuario-username');
					usuarioUsername.textContent = usuarios[i].username;
			usuarioWapper.appendChild(usuarioUsername);

				var usuarioSector = document.createElement('div');
					usuarioSector.classList.add('col-sm-4', 'usuario-sector');
					usuarioSector.textContent = usuarios[i].sector;
			usuarioWapper.appendChild(usuarioSector);

			var usuarioOpciones = document.createElement('div');
				usuarioOpciones.classList.add('col-sm-4', 'only-button', 'usuario-opciones');
					var btnEditar = document.createElement('button');
						btnEditar.classList.add('edita-usuario', 'btn', 'btn-outline-primary', 'btn-sm');
						btnEditar.innerHTML = '<i class="fas fa-edit"></i>';
						btnEditar.setAttribute('data-toggle', 'tooltip');
						btnEditar.setAttribute('data-placement', 'bottom');
						btnEditar.setAttribute('data-original-title', 'Editar el perfil');
						btnEditar.id = usuarios[i].id;
					usuarioOpciones.appendChild(btnEditar);
					var btnCambiaPwd = document.createElement('button');
						btnCambiaPwd.classList.add('edita-usuario-pdw', 'btn', 'btn-outline-warning', 'btn-sm');
						btnCambiaPwd.innerHTML = '<i class="fas fa-key"></i>';
						btnCambiaPwd.setAttribute('data-toggle', 'tooltip');
						btnCambiaPwd.setAttribute('data-placement', 'bottom');
						btnCambiaPwd.setAttribute('data-original-title', 'Cambiar la contraseña');
						btnCambiaPwd.id = usuarios[i].id;
					usuarioOpciones.appendChild(btnCambiaPwd);
					var btnCambiaEstado = document.createElement('button');
						btnCambiaEstado.classList.add('edita-usuario-estado', 'btn', 'btn-outline-danger', 'btn-sm');
						btnCambiaEstado.setAttribute('data-toggle', 'tooltip');
						btnCambiaEstado.setAttribute('data-placement', 'bottom');
						btnCambiaEstado.setAttribute('data-original-title', 'Cambiar el estado');
						btnCambiaEstado.innerHTML = '<i class="fas fa-ban"></i>';
						btnCambiaEstado.id = usuarios[i].id;
					usuarioOpciones.appendChild(btnCambiaEstado);
			usuarioWapper.appendChild(usuarioOpciones);

			resultsFragment.appendChild(usuarioWapper);
		}

		$('div#resultados_usuarios').append(resultsFragment);

		//Asigna el event listener del boton de edición
		$('.edita-usuario').click((e) => {
			let usuarios_id = e.currentTarget.id;

			this.showModalPerfil(usuarios_id);
		});

		$('.edita-usuario-pdw').click((e) => {
			let usuarios_id = e.currentTarget.id;

			this.showModalPerfilClave(usuarios_id);
		});

		//Activa los tooltips de los botones
		$(function(){$('[data-toggle="tooltip"]').tooltip()});
	}

	this.showModalPerfil = function(usuarios_id)
	{
		$.get(base_url+'ajax/usuario/'+usuarios_id,
			null,
			function(data){
				$('#perfil_username').text(data.username);
				$('#perfil_nombre').val(data.nombre);
				$('#perfil_apellido').val(data.apellido);
				$('#perfil_email').val(data.email);
				$('#modal_perfil').modal('show');
			});
	}

	this.showModalPerfilClave = function(usuarios_id)
	{
		$('#cambiaclave_usuarios_id').val(usuarios_id);
		$('#modal_cambiaclave_usuario').modal('show');
	}
}

//Constructor de objeto de Bitacora
function BitacoraViewer(){
	this.cargarModal = function(bitacora){
		$('#bitacora_titulo').val(bitacora.titulo);
		$('#bitacora_abonado_descripcion').val(bitacora.abonado_descripcion);
		$('#bitacora_usuario_descripcion').val(bitacora.usuario_username);
		$('#bitacora_sector_descripcion').val(bitacora.sector_descripcion);
		$('#bitacora_cuerpo').val(bitacora.cuerpo);
		$('#bitacora_relacion').val(bitacora.relacion);
		$('#bitacora_estado_descripcion').val(bitacora.estado_descripcion);
	}

	this.resetModal = function (){
		$('#bitacora_titulo').val('');
		$('#bitacora_abonado_descripcion').val('');
		$('#bitacora_usuario_descripcion').val('');
		$('#bitacora_sector_descripcion').val('');
		$('#bitacora_cuerpo').val('');
		$('#bitacora_relacion').val('');
		$('#bitacora_estado_descripcion').val('');
	}
}



