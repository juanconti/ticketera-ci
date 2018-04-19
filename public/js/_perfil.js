document.addEventListener('DOMContentLoaded', function(){
	$('#muestra-modifica-contraseña').click(function(e){
		e.preventDefault();
		$('#modal_cambiaContraseña').modal('show');
	});

	$('#btn_cambiaContraseña').click(function(e){
		e.preventDefault();
		var oldClave			= $('#input_oldClave').val();
		var newClave 			= $('#input_newClave').val();
		var newClaveConfirma	= $('#input_newClaveConfirma').val();

		$('#error-validacion').fadeOut();

		var validacion = validaClaves(oldClave, newClave, newClaveConfirma);


		if(!validacion.estado) 		triggerErrorConstaseña(validacion.msj);
		else						$('#form_cambiaContraseña').submit();
	});
});

function validaClaves(oldClave, newClave, newClaveConfirma){
	var regexClave = /^[a-zA-ZñÑ0-9]{5,25}$/i;
	var validacion = {};
	validacion.estado 	= true;
	validacion.msj 		= [];

	if(oldClave == '' || newClave == '' || newClaveConfirma == ''){
		validacion.estado = false;
		validacion.msj.push(' Indique los tres campos requeridos.');
		return validacion;
	}

	if(newClave !== newClaveConfirma){
		validacion.estado = false;
		validacion.msj.push('Las contraseñas nuevas no coinciden.');
	}

	if(oldClave == newClave && oldClave !== ''){
		validacion.estado = false;
		validacion.msj.push('La contraseña actual y la contraseña nueva no pueden ser iguales.');
	}

	if(!regexClave.test(newClave) || !regexClave.test(oldClave)){
		validacion.estado = false;
		validacion.msj.push('La contraseña solo debe tener numero y letras y debe tener entre 5 y 25 caracteres.');
	}

	return validacion;
}

function triggerErrorConstaseña(error){
	$('#error-validacion').fadeOut(400, function(){
		$('#error-validacion-msj').html('');
		for(var i=0; i < error.length; i++){
			$('#error-validacion-msj').append(error[i]);
			if(i !== error.length-1)	$('#error-validacion-msj').append('<br>');
		};
		$('#error-validacion').fadeIn();
	});
}