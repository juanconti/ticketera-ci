document.addEventListener('DOMContentLoaded', function(){
	$('#btn_busqueda').click(function(){
		let formElements = {};
		formElements.usuarios_id	= $('#query_usuario');
		formElements.abonados_id	= $('#input_abonado_id');
		formElements.tkEstado_id	= $('#query_estado');
		formElements.ticket_id		= $('#query_ticket_id');
		formElements.order_by		= $('#query_order_by');
		
		let buscadorTickets = new BuscadorTickets();
		
		//Se resetea la tabla de resultados de tickets.
		buscadorTickets.tablaTickets.setLoadingMsj('Cargando...');
		buscadorTickets.tablaTickets.resetResultados();
		
		buscadorTickets.disableForm(true);
		
		let esValido = buscadorTickets.validaFiltros(formElements);
		
		if(esValido === true)
			buscadorTickets.getResultados();
		else{
			buscadorTickets.tablaTickets.setLoadingMsj('Indique los parámetros de la busqueda');
			buscadorTickets.disableForm(false);
		}
		
		
	});
	
	document.querySelector('#query_ticket_id').addEventListener('keyup', eventSoloTicketId);
	document.querySelector('#query_ticket_id').addEventListener('blur', eventSoloTicketId);

});

let BuscadorTickets = function(){
	this.tablaTickets	= new TablaTickets();
	this.filtros		= {};
		
	this.validaFiltros = function(formElements){
		let esValido = true;		
		
		this.resetValidaErrors(formElements);
		
		if(formElements.ticket_id.val() !== '' && isNaN(formElements.ticket_id.val())){
			formElements.ticket_id.siblings('.invalid-feedback').html('Debe indicar un número de id del ticket.')
			formElements.ticket_id.addClass('is-invalid');
			esValido =  false;
		}
		else if(formElements.ticket_id.val() !== '' && !isNaN(formElements.ticket_id.val())){
			this.filtros['tickets_id'] = formElements.ticket_id.val();
		}
		else{			
			if(formElements.usuarios_id.val() !== '' && !isNaN(formElements.usuarios_id.val()))
				this.filtros.usuarios_id	= parseInt(formElements.usuarios_id.val());
			
			if(formElements.abonados_id.val() !== '' && !isNaN(formElements.abonados_id.val()))
				this.filtros.abonados_id	= parseInt(formElements.abonados_id.val());
			
			if(formElements.tkEstado_id.val() !== '' && !isNaN(formElements.tkEstado_id.val()))
				this.filtros.tkEstado_id	= parseInt(formElements.tkEstado_id.val());
			
			if(formElements.order_by.val() !== '')
				this.filtros.order_by		= formElements.order_by.val();
		}
		
		return esValido;
	};
	
	this.resetValidaErrors = function(formElements){
		formElements.ticket_id.removeClass('is-invalid');
		formElements.ticket_id.siblings('.invalid-feedback').html('');
		
		formElements.usuarios_id.removeClass('is-invalid');
		formElements.usuarios_id.siblings('.invalid-feedback').html('');

		formElements.abonados_id.removeClass('is-invalid');
		formElements.abonados_id.siblings('.invalid-feedback').html('');

		formElements.tkEstado_id.removeClass('is-invalid');
		formElements.tkEstado_id.siblings('.invalid-feedback').html('');

	}
	
	this.getResultados = function(){
		$.get(base_url+'ajax/tickets/buscar',
		this.filtros,
		(data) => {
			if(data.error !== undefined){
				alert(data.error);
				this.tablaTickets.setLoadingMsj('Indique los parámetros de busqueda');
			}
			else
				this.tablaTickets.cargaResultados(data);
			this.disableForm(false);
		});
	}
	
	this.disableForm = function(boolean){
		let ticket_id = document.querySelector('#query_ticket_id').value;
		if(ticket_id === ''){
			$('#form_busqueda_tk button').attr('disabled', boolean);
			$('#form_busqueda_tk input').attr('disabled', boolean);
			$('#form_busqueda_tk select').attr('disabled', boolean);
		}
	}
}

let TablaTickets = function(){
	this.cargaResultados = function(tickets){
		let tableBody = document.querySelector('.resultados-tickets table tbody');
		let resultFragment = document.createDocumentFragment();

		tableBody.innerHTML = '';

		/*Carga la tabla con los tickets*/
		for(var i = 0; i < tickets.length; i++){
		var ticket = tickets[i];
		var fila = document.createElement('tr');
			fila.classList.add('tabla-ticket-item');
			if(ticket.prioridad !== null)
				fila.classList.add('prioridad-'+ticket.prioridad);
			fila.id = ticket.id;

			var id = document.createElement('td');
				id.classList.add('tabla-ticket-celda', 'id');
				id.innerText = ticket.id;
			fila.appendChild(id);

			var titulo = document.createElement('td');
				titulo.classList.add('tabla-ticket-celda', 'titulo');
				if(tickets[i].titulo.length > 30)
					titulo.innerText = ticket.titulo.substring(0, 30)+'...';
				else
					titulo.innerText = ticket.titulo;
			fila.appendChild(titulo);

			var cuerpo = document.createElement('td');
				cuerpo.classList.add('tabla-ticket-celda', 'cuerpo');
				if(ticket.cuerpo.substring(0, 50))
					cuerpo.innerText = ticket.cuerpo.substring(0, 50)+'...';
				else
					cuerpo.innerText = ticket.cuerpo.titulo;
			fila.appendChild(cuerpo);

			var abonado = document.createElement('td');
				abonado.classList.add('tabla-ticket-celda', 'abonado');
				abonado.innerText = ticket.abonados_descripcion;
			fila.appendChild(abonado);

			var usuario = document.createElement('td');
				usuario.classList.add('tabla-ticket-celda', 'usuario');
				usuario.innerText = ticket.usuarios_username;
			fila.appendChild(usuario);

			var detalles = document.createElement('td');
				detalles.classList.add('tabla-ticket-celda', 'detalles');
				var btnDetalles = document.createElement('button');
					btnDetalles.classList.add('btn', 'btn-outline-info', 'btn-sm', 'tk-detalles');
					btnDetalles.innerHTML = '<i class="fas fa-info-circle"></i>';
					btnDetalles.id = ticket.id;
					btnDetalles.setAttribute('data-toggle', 'tooltip');
					btnDetalles.setAttribute('data-placement', 'bottom');
					btnDetalles.setAttribute('title', 'Ver detalles del Ticket');
				detalles.appendChild(btnDetalles);
				var btnEditar = document.createElement('a');
					btnEditar.setAttribute('role', 'button');
					btnEditar.classList.add('btn', 'btn-outline-warning', 'btn-sm');
					btnEditar.innerHTML = '<i class="fas fa-edit"></i>';
					btnEditar.id = ticket.id;
					btnEditar.href = base_url+'tickets/editar/'+ticket.id;
					btnEditar.setAttribute('data-toggle', 'tooltip');
					btnEditar.setAttribute('data-placement', 'bottom');
					btnEditar.setAttribute('title', 'Editar Ticket');
				detalles.appendChild(btnEditar);
				var btnContinuar = document.createElement('a');
					btnContinuar.setAttribute('role', 'button');
					btnContinuar.classList.add('btn', 'btn-outline-success', 'btn-sm', 'tk-continuar');
					btnContinuar.id = ticket.id;
					btnContinuar.href = base_url+'tickets/continuar/'+ticket.id;
					btnContinuar.innerHTML = '<i class="fas fa-plus"></i>';
					btnContinuar.setAttribute('data-toggle', 'tooltip');
					btnContinuar.setAttribute('data-placement', 'bottom');
					btnContinuar.setAttribute('title', 'Continuar Ticket');
				detalles.appendChild(btnContinuar);
			fila.appendChild(detalles);

		resultFragment.appendChild(fila);
		}

		tableBody.append(resultFragment);

		/*Muestra la tabla al usuario*/
		$('.loading-screen').addClass('escondido');
		$('.resultados-tickets').removeClass('escondido');
	};

	this.resetResultados = function(){
		$('.resultados-tickets').addClass('escondido');
		$('.loading-screen').removeClass('escondido');
	}
	
	this.setLoadingMsj = function(msj){
		let txtLoadingScreen = document.querySelector('.loading-screen p');
		txtLoadingScreen.innerText = msj;
	}
}

let eventSoloTicketId = function(e){
	if(this.value !== ''){
		document.querySelector('#query_usuario').disabled = true;
		document.querySelector('#input_buscaAbonado').disabled = true;
		document.querySelector('#btn_buscaAbonado').disabled = true;
		document.querySelector('#query_estado').disabled = true;
		document.querySelector('#query_order_by').disabled = true;
	}
	else{
		document.querySelector('#query_usuario').disabled = false;
		document.querySelector('#input_buscaAbonado').disabled = false;
		document.querySelector('#btn_buscaAbonado').disabled = false;
		document.querySelector('#query_estado').disabled = false;
		document.querySelector('#query_order_by').disabled = false;
	}
}

