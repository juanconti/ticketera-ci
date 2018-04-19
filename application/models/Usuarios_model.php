<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class usuarios_model extends ci_model{

	public function __construct(){
		parent::__construct();
	}


	public function setUsuario($username, $sectores_id, $clave, $email, $activo, $nombre=NULL, $apellido=NULL)
	{
		$usuario = [
			'username' => $username,
			'nombre' => $nombre,
			'apellido' => $apellido,
			'clave' => md5($clave),
			'email' => $email,
			'sectores_id' => $sectores_id,
			'activo' => $activo
		];
		$this->db->insert('usuarios', $usuario);

		//Se devuelven errores en caso de que halla y se devuelve el id del item
		$error = $this->db->error();
		if ($error['code'] !== 0) $response['error'] = $error;
		$response['insert_id'] = $this->db->insert_id();

		return $response;
	}

	public function getUsuario($id)
	{
		$this->db->select('u.id, u.username, u.nombre, u.apellido, u.email, u.sectores_id, s.descripcion as sectores_descripcion, u.created_at, u.updated_at, u.activo');
		$this->db->from('usuarios as u');
		$this->db->where('u.id', $id);
		$this->db->join('sectores as s', 'u.sectores_id = s.id');
		$this->db->limit(1);
		$query = $this->db->get();
		$usuario = $query->result_array();
		if(isset($usuario[0]))
			return $usuario[0];
		else
			return null;
	}

	public function bajaUsuario($id)
	{
		$this->db->set('activo', 0);
		$this->db->where('id <> 1');
		$this->db->where('id', $id);
		$this->db->update('usuarios');

		//Se devuelven errores en caso de que halla y se devuelve el id del item
		$error = $this->db->error();
		if ($error['code'] !== 0)
			$response['error'] = $error;
		else
			$response['affected_rows']  = $this->db->affected_rows();
		
		return $response;
	}

	public function activaUsuario($id)
	{
		$this->db->set('activo', 1);
		$this->db->where('id', $id);
		$this->db->update('usuarios');

		//Se devuelven errores en caso de que halla y se devuelve el id del item
		$error = $this->db->error();
		if ($error['code'] !== 0) $response['error'] = $error;
		else $response['affected_rows']  = $this->db->affected_rows();
		return $response;
	}

	public function getUsuarioFull($id)
	{
		$this->db->select('u.*, s.descripcion as sectores_descripcion');
		$this->db->from('usuarios as u');
		$this->db->where('u.id', $id);
		$this->db->join('sectores as s', 'u.sectores_id = s.id', 'left');
		$this->db->limit(1);
		$query = $this->db->get();
		$usuario = $query->result_array();
		// $query = $this->db->last_query();
		// return $query;
		// exit;
		if(isset($usuario[0])) return $usuario[0];
		else return null;
	}

	public function getUsuarios()
	{
		$this->db->select('u.id, u.username, u.nombre, u.apellido, u.email, u.sectores_id as sector_id, s.descripcion as sector_descripcion, u.created_at, u.updated_at, u.activo');
		$this->db->from('usuarios as u');
		$this->db->join('sectores as s', 'u.sectores_id = s.id');
		$this->db->where('u.id <> 1');
		$query = $this->db->get();
		$usuarios = $query->result_array();
		return $usuarios;
	}

	public function buscarUsuarios($queryUsuario, $idSector=null)
	{
		$this->db->select('u.id, u.username, s.descripcion as sector, u.activo');
		$this->db->from('usuarios as u');
		$this->db->join('sectores as s', 'u.sectores_id = s.id');
		$this->db->or_group_start();
			$this->db->like('u.username', $queryUsuario);
			$this->db->or_like('u.nombre', $queryUsuario);
			$this->db->or_like('u.apellido', $queryUsuario);
		$this->db->group_end();
		if($idSector !== null && $idSector !== '')
			$this->db->where('u.sectores_id', $idSector);
		$usuarios = $this->db->get()->result_array(); 
		return $usuarios;
	}

	public function getUsuariosPorFiltros($activos, $sectores_id=null)
	{
		$this->db->select('u.id, u.username, s.descripcion as sectores_descripcion, u.activo');
		$this->db->from('usuarios as u');
		$this->db->join('sectores as s', 'u.sectores_id = s.id');
		$this->db->where('u.id <> 1');
		if($activos == true)
			$this->db->where('u.activo', true);
		if($sectores_id != null)
			$this->db->where('u.sectores_id', $sectores_id);
		$usuarios = $this->db->get()->result_array();
		return $usuarios;
	}

	public function getUsuariosBySector($idSector, $incluyeInactivos=false)
	{
		$this->db->select('u.id, u.username, u.nombre, u.apellido, u.email, u.sectores_id as sector_id, s.descripcion as sector_descripcion, u.created_at, u.updated_at, u.activo');
		$this->db->from('usuarios as u');
		$this->db->join('sectores as s', 'u.sectores_id = s.id');
		$this->db->where('u.sectores_id', $idSector);
		if($incluyeInactivos !== false)
			$this->db->where('u.activo', true);
		$usuarios = $this->db->get()->result_array();
		return $usuarios;
	}

//	public function getUsuariosActivos()
//	{
//		$this->db->select('u.id, u.username, u.nombre, u.apellido, u.email, u.sectores_id as sector_id, s.descripcion as sector_descripcion, u.created_at, u.updated_at, u.activo');
//		$this->db->from('usuarios as u');
//		$this->db->where('u.activo', 1);
//		$this->db->where('s.activo', 1);
//		$this->db->where('u.id <> 1');
//		$this->db->join('sectores as s', 'u.sectores_id = s.id');
//		$query = $this->db->get();
//		$usuariosActivos = $query->result_array();
//		return $usuariosActivos;
//	}

	public function login($username, $clave)
	{
		$this->db->select('u.id');
		$this->db->from('usuarios as u');
		$this->db->join('sectores as s', 'u.sectores_id = s.id');
		$this->db->where('u.username', $username);
		$this->db->where('u.clave', md5($clave));
			$this->db->where('u.activo', 1);
			$this->db->where('s.activo', 1);
		$query = $this->db->get();
		$usuario = $query->result_array();
		return $usuario[0];
	}

	public function updatePerfilUsuario($email, $nombre, $apellido)
	{
		$this->db->set('email', $email);
		$this->db->set('nombre', $nombre);
		$this->db->set('apellido', $apellido);
		$this->db->where('id', $_SESSION['usuario']['id']);
		$this->db->update('usuarios');
		
		$response['affected_rows']  = $this->db->affected_rows();
		
		$error = $this->db->error();
		if ($error['code'] !== 0) $response['error'] = $error;

		return $response;
	}

	public function validaUsuarioClave($clave)
	{
		$this->db->select('count(*) as r');
		$this->db->from('usuarios');
		$this->db->where('id', $_SESSION['usuario']['id']);
		$this->db->where('clave', md5(trim($clave)));
		$this->db->where('activo', 1);
		$query = $this->db->get();
		$response = $query->result_array();
		if(empty($response))
			return null;
		else
			return $response[0]['r'];
	}

	public function updateClave($clave, $usuarios_id=null)
	{
		$this->db->set('clave', md5($clave));
		if($usuarios_id !== null)
			$this->db->where('id', $usuarios_id);
		else
			$this->db->where('id', $_SESSION['usuario']['id']);
		$this->db->update('usuarios');

		$response['affected_rows']  = $this->db->affected_rows();

		$error = $this->db->error();
		if ($error['code'] !== 0) $response['error'] = $error;

		return $response;
	}
}
?>
