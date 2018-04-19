document.addEventListener('DOMContentLoaded',function(){
	//Habilitacion y deshabilitación de usuarios
	perfilEventListeners();

	//Filtrar los usuarios de la tabla
	$('#form_usuarios_filtrar').submit(function(event){
		event.preventDefault();
		let activos = document.querySelector('#filtro_estado').checked;
		let sectores_id = $('#filtro_sector').val();

		let tablaUsuarios = new TablaUsuarios();
		
		let filtros = {};
		if(sectores_id !== '')
			filtros.sectores_id = sectores_id;
		filtros.activos = activos;


		$.get(base_url+'ajax/usuarios/',
			filtros,
			function(datos){
				if(typeof datos.error !== 'undefined'){
					tablaUsuarios.showError(datos.error);
				}
				else{
					tablaUsuarios.showUsuariosConFiltros(datos);
					$('[data-toggle="tooltip"]').tooltip();
				}
		});
	});

	//Alta y validacion de Usuarios
	$('#form_usuarios_alta').submit(function(e){
		e.preventDefault();
		let usuarioForm = {};
		usuarioForm.username 	= $('#input_username');
		usuarioForm.sector 	= $('#select_sector');
		usuarioForm.nombre 	= $('#input_nombre');
		usuarioForm.apellido 	= $('#input_apellido');
		usuarioForm.email 	= $('#input_email');
		usuarioForm.password 	= $('#input_password');
		usuarioForm.passwordCon	= $('#input_passwordConfirma');

		let altaUsuario = new ValidadorUsuario(usuarioForm);

		altaUsuario.resetFormValidation();

		let validacion = altaUsuario.validate();

		if(validacion === true)
			this.submit();		
	});

	$('#checkbox_estado').change(function(e){
		var chkboxStatus = e.target.checked;
		if(chkboxStatus === false){
			$('.form-check-label.chk-true').addClass('escondido');
			$('.form-check-label.chk-false').removeClass('escondido');
		}
		else{
			$('.form-check-label.chk-false').addClass('escondido');
			$('.form-check-label.chk-true').removeClass('escondido');
		}
	});
});

function ValidadorUsuario(formElements)
{
	this.formElements = formElements;

	this.validate = function(){
		let validationStatus = true;

		let sololetrasRegExp 		= /^[a-zA-ZñÑ\s]*$/;
		let letrasynumerosRegExp 	= /^[0-9a-zA-ZñÑ\s]*$/;
		let emailRegExp 			= /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

		//Valida el username
		let usernameString = this.formElements.username.val();

		if(!letrasynumerosRegExp.test(usernameString)){
			validationStatus = false;
			var errorMsj = 'Solo debe tener letras y números.';
			this.assignErrorToElemnt(this.formElements.username, errorMsj);
		}
		else if(usernameString.length < 4){
			validationStatus = false;
			var errorMsj = 'Debe tener como mínimo 4 caracteres.';
			this.assignErrorToElemnt(this.formElements.username, errorMsj);
		}
		else if(usernameString.length > 15){
			validationStatus = false;
			var errorMsj = 'Debe tener como máximo 15 caracteres.';
			this.assignErrorToElemnt(this.formElements.username, errorMsj);
		}

		//Valida el sector
		let sectorSeleccionado = this.formElements.sector.val();

		if(sectorSeleccionado === null || sectorSeleccionado < 2)
			this.assignErrorToElemnt(this.formElements.sector);


		//Valida el nombre
		let nombreString = this.formElements.nombre.val();

		if(nombreString.length > 0){
			if(!sololetrasRegExp.test(nombreString)){
				validationStatus = false;
				var errorMsj = 'Solo debe tener letras.';
				this.assignErrorToElemnt(this.formElements.nombre, errorMsj);
			}
			else if(usernameString.length > 25){
				validationStatus = false;
				var errorMsj = 'Debe tener como máximo 25 caracteres.';
				this.assignErrorToElemnt(this.formElements.nombre, errorMsj);
			}
		};

		//Valida el apellido
		let apellidoString = this.formElements.apellido.val();

		if(apellidoString.length > 0){
			if(!sololetrasRegExp.test(apellidoString)){
				validationStatus = false;
				var errorMsj = 'Solo debe tener letras.';
				this.assignErrorToElemnt(this.formElements.apellido, errorMsj);
			}
			else if(apellidoString.length > 25){
				validationStatus = false;
				var errorMsj = 'Debe tener como máximo 25 caracteres.';
				this.assignErrorToElemnt(this.formElements.apellido, errorMsj);
			}
		}

		//Valida el email
		let emailString = this.formElements.email.val();

		if(emailString.length > 0 && !emailRegExp.test(emailString)){
			validationStatus = false;
			var errorMsj = 'Debe indicar un email valido.';
			this.assignErrorToElemnt(this.formElements.email, errorMsj);
		}

		//Valida las contraseñas
		let passwordString 		= this.formElements.password.val();
		let passwordConString 	= this.formElements.passwordCon.val();

		if(passwordString.length < 1){
			validationStatus = false;
			var errorMsj = 'Este campo es obligatorio.';
			this.assignErrorToElemnt(this.formElements.password, errorMsj);
		}
		else if(passwordString.length < 5){
			validationStatus = false;
			var errorMsj = 'Debe tener como mínimo 5 caracteres.';
			this.assignErrorToElemnt(this.formElements.password, errorMsj);
		}
		else if(passwordString.length > 25){
			validationStatus = false;
			var errorMsj = 'Debe tener como máximo 25 caracteres.';
			this.assignErrorToElemnt(this.formElements.password, errorMsj);
		}
		else if(!letrasynumerosRegExp.test(passwordString)){
			validationStatus = false;
			var errorMsj = 'Solo debe tener letras y números.';
			this.assignErrorToElemnt(this.formElements.password, errorMsj);
		}

		if(passwordString !== passwordConString){
			validationStatus = false;
			var errorMsj = 'Las contraseñas deben coincidir.';
			this.assignErrorToElemnt(this.formElements.password);
			this.assignErrorToElemnt(this.formElements.passwordCon, errorMsj);
		}

		if(passwordConString.length < 1){
			validationStatus = false;
			var errorMsj = 'Este campo es obligatorio.';
			this.assignErrorToElemnt(this.formElements.passwordCon, errorMsj);
		}

		return validationStatus;
	}

	this.assignErrorToElemnt = function(element, errorMsj = null){
		if(errorMsj !== null){
			var feedbackElement = element.siblings('.invalid-feedback');
			feedbackElement.text(errorMsj);
		}
		element.addClass('is-invalid');
	}

	this.resetFormValidation = function(){
		this.formElements.username.removeClass('is-invalid');
		this.formElements.username.siblings('.invalid-feedback').text('');
		this.formElements.sector.removeClass('is-invalid');
		this.formElements.nombre.removeClass('is-invalid');
		this.formElements.nombre.siblings('.invalid-feedback').text('');
		this.formElements.apellido.removeClass('is-invalid');
		this.formElements.apellido.siblings('.invalid-feedback').text('');
		this.formElements.email.removeClass('is-invalid');
		this.formElements.email.siblings('.invalid-feedback').text('');
		this.formElements.password.removeClass('is-invalid');
		this.formElements.password.siblings('.invalid-feedback').text('');
		this.formElements.passwordCon.removeClass('is-invalid');
		this.formElements.passwordCon.siblings('.invalid-feedback').text('');
	}
}

function perfilEventListeners(){
	$('.baja-usuario').click(function(event) {
		var id = $(this).attr('id');
		
		modificarEstado(id, false, function(data){
			if(data.status == 1){
				$('tr#'+id+' td.estado a.baja-usuario').fadeOut(400, function(){
					$('tr#'+id+' td.estado a.activa-usuario').fadeIn();
				});
			}
		});
	});

	$('.activa-usuario').click(function(event) {
		var id = $(this).attr('id');

		modificarEstado(id, true, function(data){
			if(data.status == 1){
				$('tr#'+id+' td.estado a.activa-usuario').fadeOut(400,function(){
					$('tr#'+id+' td.estado a.baja-usuario').fadeIn();
				});
			}
		});
	});

	$('.ver-perfil').click(function(){
		let usuario_id = $(this).attr('id');
		
		$.get(base_url + 'ajax/usuario/' + usuario_id, function(data){
			$('#perfil_id').text(data.id);
			$('#perfil_username').text(data.username);
			$('#perfil_sector_descripcion').text(data.sectores_descripcion);
			$('#perfil_nombre').text(data.nombre);
			$('#perfil_apellido').text(data.apellido);
			$('#perfil_email').text(data.email);
			$('#perfil_fecha_creado').text(formatDate(data.created_at));
			$('#perfil_fecha_modificado').text(formatDate(data.updated_at));

			if(data.activo == 0)
				$('.perfil-icon-placeholder i').addClass('deshabilitado');
			else
				$('.perfil-icon-placeholder i').removeClass('deshabilitado');

			$('#modal_perfil').modal('show');
		});
	});
}

let TablaUsuarios = function(){
	this.showUsuariosConFiltros = function(usuarios){
		this.hideTabla(() => {
			this.setResultadosUsuario(usuarios);
		});
		$('#tablaUsuario').fadeIn();
	}

	this.hideTabla = function(callback){
		$('#tablaUsuario').fadeOut(function(){
			$('.placeholder.error').addClass('escondido');
			$('#tablaUsuario tbody').html('');
			callback();
		});
	}

	this.setResultadosUsuario = function(usuarios){
		let resultFragment = document.createDocumentFragment();

		for (var i = 0; i < usuarios.length; i++){
			var fila = document.createElement('tr');
			fila.id = usuarios[i].id;
			if(usuarios[i].activo == 0)
				fila.classList.add('usuario-inactivo');

				var id = document.createElement('th');
					id.classList.add('id');
					id.setAttribute('scope', 'row');
					id.innerHTML = usuarios[i].id;
					fila.appendChild(id);
				var username = document.createElement('td');
					username.classList.add('username');
					username.innerHTML = usuarios[i].username;
					fila.appendChild(username);
				var sector = document.createElement('td');
					sector.classList.add('sector');
					sector.innerHTML = usuarios[i].sectores_descripcion;
					fila.appendChild(sector);
				var perfil = document.createElement('td');
					perfil.classList.add('perfil');
					var btnPerfil = document.createElement('button');
						btnPerfil.id = usuarios[i].id;
						btnPerfil.classList.add('btn', 'btn-outline-info', 'btn-sm', 'ver-perfil');
						btnPerfil.setAttribute('data-toggle', 'tooltip');
						btnPerfil.setAttribute('data-placement', 'bottom');
						btnPerfil.setAttribute('title', 'Ver más información');
						btnPerfil.innerHTML = '<i class="far fa-user-circle"></i>';
						perfil.appendChild(btnPerfil);
					fila.appendChild(perfil);
				var estado = document.createElement('td');
					estado.classList.add('estado');
						var btnBajaUsuario = document.createElement('a');
							btnBajaUsuario.classList.add('btn', 'btn-outline-danger', 'btn-sm', 'baja-usuario');
							btnBajaUsuario.setAttribute('data-toggle', 'tooltip');
							btnBajaUsuario.setAttribute('data-placement', 'bottom');
							btnBajaUsuario.setAttribute('title', 'Deshabilita el usuario');
							btnBajaUsuario.innerHTML = '<i class="fas fa-ban"></i>';
							btnBajaUsuario.id = usuarios[i].id;
						var btnActivaUsuario = document.createElement('a');
							btnActivaUsuario.classList.add('btn', 'btn-outline-warning', 'btn-sm', 'activa-usuario');
							btnActivaUsuario.setAttribute('data-toggle', 'tooltip');
							btnActivaUsuario.setAttribute('data-placement', 'bottom');
							btnActivaUsuario.setAttribute('title', 'Reactiva el usuario');
							btnActivaUsuario.innerHTML = '<i class="fas fa-redo"></i>';
							btnActivaUsuario.id = usuarios[i].id;
						if(usuarios[i].activo == 1)
							btnActivaUsuario.classList.add('escondido');
						else
							btnBajaUsuario.classList.add('escondido');
					estado.appendChild(btnBajaUsuario);
					estado.appendChild(btnActivaUsuario);
				fila.appendChild(estado);

			resultFragment.appendChild(fila);
		}

		document.querySelector('#tablaUsuario tbody').append(resultFragment);

		perfilEventListeners();
	}

	this.showError = function(errorMsj){
		this.hideTabla(() => {
			$('#placeholder_msg_error').text(errorMsj);
			$('.placeholder.error').removeClass('escondido');
		});
	}
}

function modificarEstado(id, nuevoEstado, callback)
{
	if(nuevoEstado)
		urlDestino = base_url + 'usuarios/reactiva/';
	else
		urlDestino = base_url + 'usuarios/baja/';
	$.post(
		urlDestino,
		{id: id},
		function(data){
			if(data.error !== undefined)
				console.error(data.error);
			else
				callback(data);
		}
	);
}
