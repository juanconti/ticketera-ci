<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class tickets_model extends ci_model{

	public function __construct(){
		parent::__construct();
	}

	public function setTicket($titulo,$cuerpo,$prioridad,$abonados_id,$usuarios_id,$estado,$relacion = 0)
	{
		$ticket = [
			'titulo'        => $titulo,
			'cuerpo'        => $cuerpo,
			'prioridad'     => $prioridad,
			'abonados_id'   => $abonados_id,
			'usuarios_id'   => $usuarios_id,
			'estado'        => $estado,
			'relacion'      => $relacion
		];
		$this->db->insert('tickets', $ticket);
		//Se devuelven errores en caso de que halla y se devuelve el id del item
		$error = $this->db->error();
		if ($error['code'] !== 0)
			$response['error'] = $error;
		else
			$response['insert_id'] = $this->db->insert_id();
		return $response;
	}

	public function updateTicket($id, $titulo, $cuerpo, $prioridad, $estado = null)
	{
		$ticket = [
			'titulo'    => $titulo,
			'cuerpo'    => $cuerpo,
			'prioridad' => $prioridad
		];
		if($estado !== null)    $ticket['estado'] = $estado;
		$this->db->where('id', $id);
		$this->db->update('tickets', $ticket);

		//Se devuelven errores en caso de que halla y se devuelve el id del item
		$error = $this->db->error();
		if ($error['code'] !== 0) $response['error'] = $error;
		else $response['affected_rows']  = $this->db->affected_rows();
		return $response;
	}

	public function updateTkEstado($id ,$estado)
	{
		$this->db->set('estado', $estado);
		$this->db->where('id', $id);
		$this->db->update('tickets');
		$error = $this->db->error();
		if ($error['code'] !== 0)
			$response['error'] = $error;
		else
			$response['affected_rows']  =  $this->db->affected_rows();
		return $response;
	}

	public function getTicket($idTicket)
	{
		$this->db->select('t.*, u.username as usuarios_username, a.descripcion as abonados_descripcion, u.sectores_id as sectores_id');
		$this->db->from('tickets as t');
			$this->db->join('usuarios as u', 't.usuarios_id = u.id');
			$this->db->join('abonados as a', 't.abonados_id = a.id');  
		$this->db->where('t.id', $idTicket);
		$this->db->limit(1);
		$ticket = $this->db->get()->result_array();
		if(empty($ticket))
			return null;
		else
			return $ticket;
	}

	public function getTkFromSector($idTk, $idSector)
	{
		$this->db->select('t.*, u.username as usuarios_username, a.descripcion as abonados_descripcion');
		$this->db->from('tickets as t');
			$this->db->join('usuarios as u', 't.usuarios_id = u.id');
			$this->db->join('abonados as a', 't.abonados_id = a.id');
		$this->db->where('t.id', $idTk);
		$this->db->where('u.sectores_id', $idSector);
		$this->db->limit(1);
		$query = $this->db->get();
		$ticket = $query->result_array();
		if(empty($ticket))
		    return null;
		else
		    return $ticket;
	}

	public function getTksByUsuario($idUsuario, $cantidadLimite=null)
	{
		$this->db->select('*');
		$this->db->from('tickets');
		$this->db->where('usuarios_id', $idUsuario);
		if($cantidadLimite !== null)
			$this->db->limit($cantidadLimite);
		$this->db->order_by('fcreado', 'DESC');
		$query   = $this->db->get();
		$tickets = $query->result_array();
		return $tickets;
	}

	public function getTksByAbonado($idAbonado)
	{
		$this->db->select('*');
		$this->db->from('tickets');
		$this->db->where('abonados_id', $idAbonado);
		$query   = $this->db->get();
		$tickets = $query->result_array();
		return $tickets;
	}

	public function getTksPendientesFromSector($idSector, $cantidadLimite=null)
	{
		$this->db->select('t.*');
		$this->db->from('tickets as t');
		$this->db->join('usuarios as u', 't.usuarios_id = u.id');
		$this->db->where('u.sectores_id', $idSector);
		$this->db->where('t.estado', 1);
		if($cantidadLimite !== null)
			$this->db->limit($cantidadLimite);
		$this->db->order_by('fmodificado', 'DESC');
		$query   = $this->db->get();
		$tickets = $query->result_array();
		return $tickets;
	}

	public function getTksPendientesByUsuario($idUsuario, $cantidadLimite=null)
	{
		$this->db->select('*');
		$this->db->from('tickets');
		$this->db->where('usuarios_id', $idUsuario);
		$this->db->where('estado', 1);
		if($cantidadLimite !== null)
			$this->db->limit($cantidadLimite);
		$this->db->order_by('fmodificado', 'DESC');
		$query   = $this->db->get();
		$tickets = $query->result_array();
		return $tickets;
	}

	public function buscarTk($idAbonado, $idUsuario, $idTkEstado, $idSectorDelUsuario=null)
	{
		$this->db->select('t.*, a.descripcion as abonados_descripcion, u.username as usuarios_username, u.sectores_id as sectores_id');
		$this->db->from('tickets as t');
		$this->db->join('usuarios as u','t.usuarios_id = u.id');
		$this->db->join('abonados as a','t.abonados_id = a.id');
		if($idSectorDelUsuario !== null && !tienePermisos('Admin'))
			$this->db->where('u.sectores_id', $idSectorDelUsuario);
		if($idAbonado !== null)
			$this->db->where('t.abonados_id', $idAbonado);
		if($idUsuario !== null)
			$this->db->where('t.usuarios_id', $idUsuario);
		if($idTkEstado !== null)
			$this->db->where('t.estado', $idTkEstado);
		$this->db->order_by('prioridad', 'DESC');

		$tickets = $this->db->get()->result_array();

		if(!empty($tickets))
			return $tickets;
		else
			return ['error' => 'No se encontraron tickets.'];
	}

	//Metodos Para tickets/busqueda
	// public function getTksByUsuarioRestringido($idUsuario, $idSectorDelUsuario){
	//     $this->db->select('t.*');
	//     $this->db->from('tickets as t');
	//     $this->db->join('usuarios as u','t.usuarios_id = u.id');
	//     $this->db->where('t.usuarios_id', $idUsuario);
	//     $this->db->where('u.sectores_id', $idSectorDelUsuario);
	//     $this->db->order_by('fcreado', 'DESC');
	//     $tickets = $this->db->get()->result_array();
	//     if(!empty($tickets))  return $tickets;
	//     else                  return null;
	// }


	// public function getTksByAbonadoRestringido($idAbonado, $idSectorDelUsuario)
	// {
	//     $this->db->select('t.*');
	//     $this->db->from('tickets as t');
	//     $this->db->join('usuarios as u','t.usuarios_id=u.id');
	//     $this->db->where('abonados_id', $idAbonado);
	//     if($idSectorDelUsuario !== null)
	//         $this->db->where('u.sectores_id',$idSectorDelUsuario);
	//     $tickets = $this->db->get()->result_array();
	//     if(!empty($tickets))  return $tickets;
	//     else                  return null;
	// }

	// public function getTksByAbonadoAndUsuario($idAbonado, $idUsuario, $idSectorDelUsuario=null){
	//   $this->db->select('t.*');
	//   $this->db->from('tickets as t');
	//   $this->db->join('usuarios as u', 'u.id = t.usuarios_id');
	//   $this->db->where('t.abonados_id', $idAbonado);
	//   $this->db->where('t.usuarios_id',$idUsuario);
	//   if($idSectorDelUsuario !== null)
	//       $this->db->where('u.sectores_id', $idSectorDelUsuario);
	//   $tickets = $this->db->get()->result_array();
	//   if(!empty($tickets))  return $tickets;
	//   else                  return null;
	// }

	public function getTkRelacionado($id)
	{
		$this->db->select('*');
		$this->db->from('tickets');
		$this->db->where('relacion', $id);
		$this->db->limit(1);
		$ticket = $this->db->get()->result_array();
		if(empty($ticket)) $ticket = null;
		else $ticket = $ticket[0];
		return $ticket;
	}
	
	private function getFirstTkFromCadena($idTicket)
	{
	$this->db->select('*');
	$this->db->from('tickets');
	$this->db->where('id', $idTicket);
	$currentTk = $this->db->get()->row_array();
	$tksCache = [];
	
	while($currentTk['relacion'] != 0){
		$this->db->select('*');
		$this->db->from('tickets');
		$this->db->where('id', $currentTk['relacion']);
		$currentTk = $this->db->get()->row_array();
		$tksCache[$currentTk['id']] = $currentTk;
	}
	
	$response['firstTk'] = $currentTk;
	$response['tksCache'] = $tksCache;
	
	return $response;
	}
	
	public function getCadenaTk($idTicket)
	{
	$cadenaTks = [];

	$response = $this->getFirstTkFromCadena($idTicket);
	$cacheTksPorTkPrevio = [];
	
	foreach($response['tksCache'] as $ticket){
		if($ticket['relacion'] != 0)
		$cacheTksPorRelacion[$ticket['relacion']] = $ticket;
	}
	
	$i = 0;
	
	$cadenaTks[$i] = $response['firstTk'];
	
	while($cadenaTks[$i]['estado'] == 2){
		$currentTkId = $cadenaTks[$i]['id'];
		$i++;

		if(isset($cacheTksPorRelacion[$currentTkId])){
		$ticketContinuacion = $cacheTksPorRelacion[$currentTkId];
		}
		else{
		$this->db->select('*');
		$this->db->from('tickets');
		$this->db->where('relacion', $currentTkId);
		$ticketContinuacion = $this->db->get()->row_array();
		}
		$cadenaTks[$i] = $ticketContinuacion;
	}
	
	return $cadenaTks;
	}

	public function getBitacoraTk($idTicket)
	{
		$this->db->select('tb.*, u.username as usuario_username, u.sectores_id as sector_id, s.descripcion as sector_descripcion, te.descripcion as estado_descripcion');
		$this->db->from('tickets_bitacora as tb');
			$this->db->join('usuarios as u', 'tb.usuarios_id = u.id', 'left');
			$this->db->join('sectores as s', 'u.sectores_id = s.id', 'left');
			$this->db->join('tickets_estados as te', 'tb.estado = te.id', 'left');
		$this->db->where('tb.tickets_id', $idTicket);
		$this->db->order_by('fecha', 'ASC');
		$query = $this->db->get();
		$bitacorasTk = $query->result_array();
		return $bitacorasTk;
	}

	public function getBitacora($idBitacora)
	{
		$this->db->select('tb.*, u.username as usuario_username, u.sectores_id as sector_id, s.descripcion as sector_descripcion, a.descripcion as abonados_descripcion, te.descripcion as estado_descripcion');
		$this->db->from('tickets_bitacora as tb');
			$this->db->join('usuarios as u', 'tb.usuarios_id = u.id', 'left');
			$this->db->join('sectores as s', 'u.sectores_id = s.id', 'left');
			$this->db->join('abonados as a', 'tb.abonados_id = a.id', 'left');
			$this->db->join('tickets_estados as te', 'tb.estado = te.id', 'left');
		$this->db->where('tb.id', $idBitacora);
		$this->db->order_by('fecha', 'ASC');
		$query = $this->db->get();
		$bitacora = $query->result_array();
		if(empty($bitacora))    return NULL;
		else                    return $bitacora[0];
	}

	public function getTkEstados()
	{
		$this->db->select('*');
		$this->db->from('tickets_estados');
		$this->db->order_by('id', 'ASC');
		$estados = $this->db->get()->result_array();
		return $estados;
	}

}
