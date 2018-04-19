function formatDate(fecha)
{
	let date = new Date(fecha);

	var fechaFromateada = date.getDate() + "/" + date.getMonth()+1 + "/" + date.getFullYear();

	var hora = date.getHours().toString();
	var minutos = date.getMinutes().toString();

	if(hora.length == 1)
		hora = 0 + hora;
	if(minutos.length == 1)
		minutos = 0 + minutos;

	var horasFromateada = hora + ':' + minutos;

	return fechaFromateada + ' ' + horasFromateada;
}