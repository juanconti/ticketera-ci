document.addEventListener('DOMContentLoaded', function(){
	/* Realiza la busqueda*/
	$('#form_busca_abonado').submit(function(e){
		$('.busqueda-filtro').removeClass('desplegado');
		e.preventDefault();
		//Toma los parametros de busqueda
		var query		= $('#buscador_query').val();
		var activos		= $('#buscador_estado').is(':checked');
		var criterio	= $('input[name=criterio]:checked').val();
		
		//Resetea la tabla de busqueda
		$('.placeholder').addClass('escondido');
		$('table').fadeOut(function(){
			$('tbody').html('');
		});

		let buscadorAbonados = new BuscadorAbonados();
		
		buscadorAbonados.buscaAbonados.setParametros(query, activos, criterio);
		var validacion = buscadorAbonados.buscaAbonados.validaParametros();

		if(!validacion.estado){
			buscadorAbonados.showError(validacion.msj);
		}
		else{
			buscadorAbonados.buscaAbonados.getResultados(function(abonados, puedeEditar){
				if (typeof abonados.error !== 'undefined')
					buscadorAbonados.showError(abonados.error);
				else{
					document.querySelector('input#buscador_query').blur();
					buscadorAbonados.cargaResultados(abonados, puedeEditar);
				}
			});
			
		}
	});

	/* Sumitea el from de alta de abonados */
	$('#form_abonados_alta, #form_edita_abonado').submit(function(e){
		e.preventDefault();
		let abonadoForm = [];
		abonadoForm.descripcion = $('#input_descripcion');
		abonadoForm.cuit 	= $('#input_cuit');
		abonadoForm.razonSocial	= $('#input_razonsocial');
		abonadoForm.telefono	= $('#input_telefono');
		abonadoForm.email	= $('#input_email');

		let altaAbonado = new AltaAbonado(abonadoForm);

		altaAbonado.resetValidacion();

		let validacion = altaAbonado.validaAbonado();

		if(!validacion.status)
			console.error('No success');
		else
			this.submit();
	});

	/* Modifica el label del checkbox de habilitacion de entidad*/
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

	$('#buscador_query').on('focus', function(){
		$('.busqueda-filtro').addClass('desplegado');
	});
});

let AltaAbonado = function(formElements)
{
	this.formElements = formElements;

	this.validaAbonado = function(){
		let response = [];
		response.status = true;

		//Valida descripcion
		var descripcionString = this.formElements.descripcion.val();

		if(descripcionString.length < 4){
			var errorMsj = 'La descripción del abonado debe de ser de un mínimo de 4 caracteres.';
			this.assignErrorToElemnt(this.formElements.descripcion, errorMsj);
			response.status = false;
		}
		else if(descripcionString.length > 25){
			var errorMsj = 'La descripción del abonado debe de tener un máximo de 25 caracteres.';
			this.assignErrorToElemnt(this.formElements.descripcion, errorMsj);
			response.status = false;
		}

		//Valida razón social
		var razonSocialString = this.formElements.razonSocial.val();

		if(razonSocialString.length < 5 ){
			var errorMsj = 'La razón social debe de tener de un mínimo de 5 caracteres.';
			this.assignErrorToElemnt(this.formElements.razonSocial, errorMsj);
			response.status = false;
		}
		else if(razonSocialString.length > 75 ){
			var errorMsj = 'La razón social debe de tener de un máximo de 75 caracteres.';
			this.assignErrorToElemnt(this.formElements.razonSocial, errorMsj);
			response.status = false;
		}

		//Valida CUIT
		var cuit = this.formElements.cuit.val().replace(/-/g, '');
		var cuitRegExp = /^([0-9]{1,13})$/;

		if(!cuitRegExp.test(cuit)){
			var errorMsj = 'El cuit solo debe tener numeros y guiones.';
			this.assignErrorToElemnt(this.formElements.cuit, errorMsj);
			response.status = false;
		}
		else if(cuit.length !== 11){
			var errorMsj = 'El cuit debe tener 11 digitos.';
			this.assignErrorToElemnt(this.formElements.cuit, errorMsj);
			response.status = false;
		}

		var emailString = this.formElements.email.val();
		var emailRegExp = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

		if(!emailRegExp.test(emailString) && emailString !== ''){
			var errorMsj = 'Debe indicar un email valido.';
			this.assignErrorToElemnt(this.formElements.email, errorMsj);
			response.status = false;
		}

		var telefonoString = this.formElements.telefono.val();
		var telefonoRegExp = /^[- +()]*[0-9][- +()0-9]*$/;

		if(telefonoString.length < 1){
			var errorMsj = 'Este campo es obligatorio.';
			this.assignErrorToElemnt(this.formElements.telefono, errorMsj);
			response.status = false;
		}
		else if(!telefonoRegExp.test(telefonoString)){
			var errorMsj = 'Solo debe indicar numeros, guiones y signos +.';
			this.assignErrorToElemnt(this.formElements.telefono, errorMsj);
			response.status = false;
		}
		else if(telefonoString.length < 4 || telefonoString.length > 50){
			var errorMsj = 'El telefono debe tener entre 4 y 50 caracteres.';
			this.assignErrorToElemnt(this.formElements.telefono, errorMsj);
			response.status = false;
		}

		return response;
	}

	this.resetValidacion = function(){
		$('form#form_abonados_alta').removeClass('was-validated')
		this.formElements.descripcion.removeClass('is-invalid');
		this.formElements.descripcion.siblings('.invalid-feedback').text('');
		this.formElements.cuit.removeClass('is-invalid');
		this.formElements.cuit.siblings('.invalid-feedback').text('');
		this.formElements.razonSocial.removeClass('is-invalid');
		this.formElements.razonSocial.siblings('.invalid-feedback').text('');
		this.formElements.telefono.removeClass('is-invalid');
		this.formElements.telefono.siblings('.invalid-feedback').text('');
		this.formElements.email.removeClass('is-invalid');
		this.formElements.email.siblings('.invalid-feedback').text('');
	}

	this.assignErrorToElemnt = function(element, errorMsj){
		var feedbackElement = element.siblings('.invalid-feedback');
		feedbackElement.text(errorMsj);
		element.addClass('is-invalid');
	}
}

let BuscadorAbonados = function()
{
	this.buscaAbonados = new BuscaAbonados();

	this.cargaResultados = function(abonados, puedeEditar){
		this.hideError();
		$('tbody').html('');
		for (var i=0; i < abonados.length; i++)
			this.cargaFila(abonados[i], puedeEditar);
		$('.info_abonado').click(function(){
			var abonados_id = this.id;
			showModalAbonado(abonados_id);
		});
		$('table').fadeIn();
	}

	this.cargaFila = function(abonado, puedeEditar){
		$('tbody').append("<tr id='id" + abonado.id + "'></tr>");
			$('#id'+abonado.id).append("<td class='id'>" + abonado.id + "</td>");
			$('#id'+abonado.id).append("<td class='descripcion'>"	+ abonado.descripcion	+ "</td>");
			$('#id'+abonado.id).append("<td class='cuit'>"		+ abonado.cuit		+ "</td>");
			$('#id'+abonado.id).append("<td class='telefono'>"	+ abonado.telefono	+ "</td>")
			$('#id'+abonado.id).append("<td class='email'>"		+ abonado.email		+ "</td>");
			$('#id'+abonado.id).append("<td class='opciones'></td>");

			$('#id'+abonado.id+' .opciones').append("<button class='btn btn-outline-info btn-sm info_abonado'  data-toggle='tooltip' data-placement='bottom' title='Ver más informacion'><i class='fas fa-info-circle'></i></button>");
			if(puedeEditar)
				$('#id'+abonado.id+' .opciones').append("<a class='btn btn-outline-primary btn-sm' href='"+base_url+"abonados/edita/"+abonado.id+"'   data-toggle='tooltip' data-placement='bottom' title='Edita abonados'><i class='fas fa-edit'></i></a>");
			$('#id'+abonado.id+' .opciones').append("<button class='btn btn-outline-danger baja-abonado btn-sm'  data-toggle='tooltip' data-placement='bottom' title='Deshabilitar abonado'><i class='fas fa-ban'></i></button>");
			$('#id'+abonado.id+' .opciones').append("<button class='btn btn-outline-warning alta-abonado btn-sm'  data-toggle='tooltip' data-placement='bottom' title='Habilitar abonado'><i class='fas fa-redo'></i></button>");

			$('#id'+abonado.id+' .info_abonado').attr('id', abonado.id);

			if(abonado.activo == 1)
				$('#id'+abonado.id+' button.alta-abonado').addClass('escondido');
			else
				$('#id'+abonado.id+' button.baja-abonado').addClass('escondido');
	}

	this.showError = function(error){
		this.hideError();
		$('.placeholder.error #placeholder_msg_error').text(error);
		$('.placeholder.error').removeClass('escondido');
		
	}

	this.hideError = function(){
		$('.placeholder.error').addClass('escondido');
		$('.placeholder.error #placeholder_msg_error').text('');
	}
}