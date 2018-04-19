document.addEventListener('DOMContentLoaded', function () {
    //Asigna el evento de busqueda de usuario y setea el select en el modal de busqueda de abonados
    $('#btn_buscaAbonado').click(function(){
	let query = $('#input_buscaAbonado').val();

	//Se instancia el obj Buscador de abonados
	let buscaAbonados = new BuscaAbonados();

	//Deshabilita el buscador
	formBusquedaAbonados.deshabilitarBuscador(true);
	formBusquedaAbonados.unsetError();

	buscaAbonados.setParametros(query);
	let validacion = buscaAbonados.validaParametros();
	console.log(validacion);

	if(validacion['estado']){
	    buscaAbonados.getResultados(function(response){
		if(response.error)
		    formBusquedaAbonados.setError(response.error);
		else
		    formBusquedaAbonados.cargaSelectAbonados(response);
		
		formBusquedaAbonados.deshabilitarBuscador(false);
	    });
	}
	else{
	    formBusquedaAbonados.setError(validacion.msj);
	    formBusquedaAbonados.deshabilitarBuscador(false);
	}
    });

    $('#input_buscaAbonado').keypress(function(e){
	if (e.which === 13) {
	    e.preventDefault();
	    $('#btn_buscaAbonado').trigger('click');
	}
    });

    //Muestra el modal con la informacion del abonado.
    $('#btn_detalle_abonado, #btn_detalle_abonado_prev').click(function(e){
	let abonado_id = $('#input_abonado_id').val() || $('#select_abonado_id').val();

	if(abonado_id === null)
	    formBusquedaAbonados.throwNoSelectedAbonadoError();
	else
	    showModalAbonado(abonado_id);
    });
    
    //Resetea el modal de resultado de abonados cuando el mismo es cerrado
    $('#modal_detalleAbonado').on('hidden.bs.modal', function(){
	$('#detalle_abonado_id').html('');
	$('#detalle_abonado_descripcion').html('');
	$('#detalle_abonado_telefono').html('');
	$('#detalle_abonado_email').html('');
	$('#detalle_abonado_cuit').html('');
	$('#detalle_abonado_razonsocial').html('');
    });

    //Carga el abonado seleccionado como resultado de la busqueda
    $('.btn_selecciona_abonado').click(function(){
	let abonado_id = $('#select_abonado_id').val();

	//Avisa si no hay un abonado seleccionado en el select.
	if(abonado_id === null){
	    formBusquedaAbonados.throwNoSelectedAbonadoError();
	}
	else
	    formBusquedaAbonados.seleccionaAbonado(abonado_id);
    });

    //Resetea la seleccion de abonado y permite la busqueda nuevamente
    $('#btn_abonado_reset_select, #btn_abonado_reset_seleccionado').click(function(){
	$('#input_abonado_id').val('');
	formBusquedaAbonados.deshabilitarBuscador(false);
	$('#buscador_abonado').removeClass('escondido');
	$('#abonado_seleccionado').addClass('escondido');
	$('#select_abonado_wrapper').addClass('escondido');
    });
});

const FormBusquedaAbonados = function(){
    //setErrorAbonado
    this.setError = function(errorMsj){
	let invalidFeedback = $('#input_buscaAbonado').siblings('.invalid-feedback');
	invalidFeedback.html(errorMsj);
	$('#input_buscaAbonado').addClass('is-invalid');
	$('#btn_buscaAbonado').removeClass('btn-outline-secondary');
	$('#btn_buscaAbonado').addClass('btn-outline-danger');
    }

    //unsetErrorAbonado
    this.unsetError = function(){
	let invalidFeedback = $('#input_buscaAbonado').siblings('.invalid-feedback');
	invalidFeedback.html('');
	$('#input_buscaAbonado').removeClass('is-invalid');
	$('#btn_buscaAbonado').removeClass('btn-outline-danger');
	$('#btn_buscaAbonado').addClass('btn-outline-secondary');
    }
    
    this.throwNoSelectedAbonadoError = function(){
	$('#select_abonado_id').addClass('is-invalid').focus();
	window.setTimeout(function(){
	    $('#select_abonado_id').removeClass('is-invalid');
	}, 400);
    }

    //seleccionaAbonado
    this.seleccionaAbonado = function(abonado_id){
	if(abonado_id != null){
	    $.get(base_url + 'ajax/abonado/' + abonado_id, function (datos) {
		$('#abonado_seleccionado_descripcion').val(datos.descripcion);
		$('#input_abonado_id').val(datos.id);
		$('#input_buscaAbonado').val('');
		$('.modal-footer .btn_selecciona_abonado').hide();

		$('#modal_detalleAbonado').modal('hide');
		$('#select_abonado_wrapper').addClass('escondido');
		$('#buscador_abonado').addClass('escondido');
		$('#abonado_seleccionado').removeClass('escondido');
	    });
	}
    }

    //cargaSelectAbonados
    this.cargaSelectAbonados = function(abonados){
	if (abonados.length === 1)
	    this.seleccionaAbonado(abonados[0].id);
	else {
	    $('#select_abonado_id').html('');
	    $('#select_abonado_id').append("<option value='' disabled selected>Seleccione una opcion</option>");
	    for (var i = 0; i < abonados.length; i++) {
		$('#select_abonado_id').append("<option value='" + abonados[i].id + "'> " + abonados[i].descripcion + "</option>");
	    }
	    $('.modal-footer .btn_selecciona_abonado').show();
	    $('#buscador_abonado').addClass('escondido');
	    setTimeout(function(){
		$('#select_abonado_wrapper').removeClass('escondido');
		$('#select_abonado_id')[0].focus();
	    }, 400);
	}
    }

    //deshabilitaBuscador
    this.deshabilitarBuscador = function(booleano){
	$('#btn_buscaAbonado').attr('disabled', booleano);
	$('#input_buscaAbonado').attr('disabled', booleano);
    }
}

function showModalAbonado(abonado_id){
    if(abonado_id != null){
	$.get(base_url + 'ajax/abonado/' + abonado_id,
	    function(datos) {
		let abonado = datos;
		$('#detalle_abonado_id').html(abonado.id);
		$('#detalle_abonado_descripcion').html(abonado.descripcion);
		$('#detalle_abonado_telefono').html(abonado.telefono);
		$('#detalle_abonado_email').html(abonado.email);
		$('#detalle_abonado_cuit').html(abonado.cuit);
		$('#detalle_abonado_razonsocial').html(abonado.razonsocial);

		$('#modal_detalleAbonado').modal('show');
	});
    }
}

//Objeto de busqueda
const BuscaAbonados = function(){
    this.parametros = {};
    this.parametros.query = null;
    this.parametros.criterio = null;
    this.parametros.activos = true;

    this.setParametros = function(query, activos = true, criterio = 'descripcion'){
	this.parametros.query = query;
	this.parametros.activos = activos;
	this.parametros.criterio = criterio.toLowerCase();
    }

    this.validaParametros = function(){
	var query = this.parametros.query;
	var criterio = this.parametros.criterio;
	var validacion = {'estado': true, 'msj': null};

	if(criterio !== 'descripcion' && criterio !== 'cuit'){
	    validacion.estado = false;
	    validacion.msj = 'Formato de criterio incorrecto.';
	}

	if(criterio === 'cuit'){
	    query = query.replace(/-/g, '');
	    if (isNaN(query)) {
		validacion.estado = false;
		validacion.msj = 'El cuit debe contener solo numeros y guiones';
	    } else
		this.parametros.query = query;
	}
	
	if(query.length < 3 && (isNaN(query) || query.length < 1)){
	    validacion.estado = false;
	    validacion.msj = 'La busqueda debe ser de al menos 3 caracteres.';
	}

	return validacion;
    }

    this.getResultados = function (callback) {
	$.ajax({
	    url: base_url + 'ajax/buscarAbonados',
	    type: 'POST',
	    dataType: 'json',
	    data: this.parametros,
	    success: function (datos) {
		callback(datos['resultados'], datos['puedeEditar']);
	    }
	});
    }
}
