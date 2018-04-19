document.addEventListener('DOMContentLoaded', function(){
	/**** Sumitea el form de alta de ticket ****/
	$("[type='submit']").click(function(e) {
		e.preventDefault();
		$('#input_estado').val($(this).attr('value'));
		var cuerpo 		= $('#textarea_cuerpo').val();
		var abonado_id 	= $('#input_abonado_id').val();

		var validacion = validaAlta(cuerpo, abonado_id);

		if(!validacion.status)		cargaErrorValidacion(validacion.msjs);
		else $('.errores-validacion').slideUp();

		if(validacion.status) $('#form_ticket_alta').submit();
		else console.log('Trompeta');
	});

	//Permite modifcar el estado de un ticket en tickets/editar
	$('#select_estado').change(function(){
		if($('#select_estado').val() == 3){
			$('#submit_edit').removeClass('btn-danger');
			$('#submit_edit').addClass('btn-warning');
		}
		else{
			$('#submit_edit').removeClass('btn-warning');
			$('#submit_edit').addClass('btn-danger');
		}
	});

	$('#btn_detalle_tkPrevio').click(function(){
		var idTkPrev = $('#id_ticket_previo').val();
		$.get(base_url+'ajax/ticket/'+idTkPrev, function(data){
			$('#ticket_prev_cuerpo').html(data.cuerpo);
			$('#ticket_prev_titulo').html(data.titulo);
			$('#modal_detalleTkPrevio').modal('show');
		});
	});	
});


function cargaErrorValidacion(errors){
	$('.errores-validacion').slideUp(400,function(){
		$('.errores-validacion').html('');
		for (i=0; i < errors.length; i++)		$('.errores-validacion').append(errors[i] + "<br>");
		$('.errores-validacion').slideDown();
	});	
}

function validaAlta(cuerpo, abonado_id){
	var response = {
		'status': true,
		'msjs': []
	}

	if(cuerpo.length < 10){
		response.status = false;
		response.msjs.push('El cuerpo del ticket debe contener al menos 10 caracteres.');
	}

	if(isNaN(abonado_id) || abonado_id == ""){
		response.status = false;
		response.msjs.push('Coloque el abonado receptor del ticket.');
	}

	return response;
}
