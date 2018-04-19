<?php
class sectores_model extends ci_model{

	public function getSectores()
	{
		$this->db->select('*');
		$this->db->from('sectores');
		$this->db->where('id <> 1');
		$sectores = $this->db->get()->result_array();;
		return $sectores;
	}

	public function getSectoresActivos()
	{
		$this->db->select('*');
		$this->db->from('sectores');
		$this->db->where('activo', '1');
		$query = $this->db->get();
		$sectores = $query->result_array();
		return $sectores;
	}


	public function getSector($id)
	{
		$this->db->select('*');
		$this->db->from('sectores');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$sector = $query->result_array();
		return $sector[0];
	}


	public function setSector($descripcion, Array $permisos, $activo)
	{                
		$sector = [
			'descripcion'	=> $descripcion,
			'permisos'		=> $this->procesaPermisos($permisos),
			'activo'		=> $activo
		];
		$this->db->insert('sectores', $sector);
	}


	public function updateSector($id, $descripcion, Array $permisos, $activo)
	{
		$sector = [
			'descripcion'	=> $descripcion,
			'permisos'		=> $this->procesaPermisos($permisos),
			'activo'		=> $activo
		];
		$this->db->where('id', $id);
		$this->db->update('sectores', $sector);

		//Se devuelven errores en caso de que halla y se devuelve el id del item
		$error = $this->db->error();
		if ($error['code'] !== 0) $response['error'] = $error;
		else $response['affected_rows'] = $this->db->affected_rows();
		return $response;       
	}


	public function getPermisos($todos=false)
	{
		$this->db->select('*');
		$this->db->from('permisos');
		if($todos == false)
			$this->db->where("descripcion <> 'Admin'");
		$query = $this->db->get();
		$permisos = $query->result_array();
		return $permisos;
	}


	public function getPermiso($id)
	{
		$this->db->select('*');
		$this->db->from('permisos');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$permiso = $query->result_array();
		if(empty($permiso))    return null;
		else                   return $permiso[0];
	}


	public function getPermisosbySector($id)
	{
		$this->db->select('permisos');
		$this->db->from('sectores');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$sector = $query->result_array();

		if(!isset($sector[0]))  $permisos = null;
		else                    $permisos_id = explode('|', $sector[0]['permisos']);

		$permisos = [];
		foreach($permisos_id as $id)    array_push($permisos, $this->getPermiso($id));
		
		return $permisos;
	}

	private function procesaPermisos(array $permisos)
	{
		$response = '';
		for ($i=0; $i < count($permisos); $i++){
				if(count($permisos)-1 == $i)
						$response .= trim($permisos[$i]);
				else
						$response .= trim($permisos[$i]) . '|';  
		}
		return $response;
	}


	//CAMBIAR AL CONTROLADOR AUTH
	public function getPermisosbyUsuario($id_usuario)
	{
		$response = [];

		$this->db->select('*');
		$this->db->from('usuarios');
		$this->db->where('id', $id_usuario);
		$query = $this->db->get();
		$usuario = $query->result_array();

		//Manejo de errores
		$error = $this->db->error();
		if ($error['code'] !== 0) {
				return ['error' => $error];
				exit;
		};
		if(isset($usuario[0])) $id_permisos_extra = explode('|', $usuario[0]['permisos_extra']);
		else{
				return ['error' => 'El usuario no existe'];
				exit;
		}
		

		$id_sector = $usuario[0]['sector'];

		$this->db->select('permisos');
		$this->db->from('sectores');
		$this->db->where('id', $id_sector);
		$query = $this->db->get();
		$permisos_sector = $query->result_array();
		$id_permisos_sector = explode('|', $permisos_sector[0]['permisos']);

		//Se devuelven errores en caso de que halla
		$error = $this->db->error();
		if ($error['code'] !== 0) {
				return ['error' => $error];
				exit;
		};

		foreach ($id_permisos_extra as $id) {
				$permiso = $this->getPermiso($id);
				array_push($response, $permiso);
		}

		foreach ($id_permisos_sector as $id) {
				$permiso = $this->getPermiso($id);
				array_push($response, $permiso);
		}
		
		return $response;
	}
}

?>