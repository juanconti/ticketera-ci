<?php
class abonados_model extends ci_model{

	public function setAbonado($descripcion, $cuit, $razonSocial, $telefono, $email, $activo){
		$abonado = [
			'descripcion' => $descripcion,
			'CUIT' => $cuit,
			'razonSocial' => $razonSocial,
			'telefono' => $telefono,
			'email' => $email,
			'activo' => $activo
		];

		$this->db->insert('abonados',$abonado);

		//Se devuelven errores en caso de que halla y se devuelve el id del item
		$error = $this->db->error();
		if ($error['code'] !== 0) $response['error'] = $error;
		$response['insert_id'] = $this->db->insert_id();

		return $response;
	}

	public function getAbonado($id, $activo=null)
	{
		$this->db->select('*');
		$this->db->from('abonados');
		$this->db->where('id',$id);
		if($activo !==null && $activo == 1)
			$this->db->where('activo',1);
		$query = $this->db->get();
		$abonado = $query->result_array();
		if(isset($abonado[0]))
			return $abonado[0];
		else return null;
	}

	public function updateAbonado($id, $descripcion, $cuit, $razonSocial, $telefono, $email, $activo)
	{
		$this->db->set('descripcion', $descripcion);
		$this->db->set('cuit', $cuit);
		$this->db->set('razonsocial', $razonSocial);
		$this->db->set('telefono', $telefono);
		$this->db->set('email', $email);
		$this->db->set('activo', $activo);
		$this->db->where('id',$id);
		$this->db->update('abonados');

		$response['affected_rows']  = $this->db->affected_rows();
		
		$error = $this->db->error();
		if($error['code'] !== 0)
			$response['error'] = $error;

		return $response;
	}

	public function getAbonados()
	{
		$this->db->select('*');
		$this->db->from('abonados');
		$query = $this->db->get();
		$abonados = $query->result_array();
		return $abonados;
	}

	public function getAbonadoByCuit($cuit, $activo)
	{
		$this->db->select('*');
		$this->db->from('abonados');
		$this->db->where('cuit', $cuit);
		if($activo)
			$this->db->where('activo',1);
		$query = $this->db->get();
		$abonado = $query->result_array();
		return $abonado;
	}

	public function getActivos()
	{
		$this->db->select('*');
		$this->db->from('abonados');
		$this->db->where('activo', 1);
		$query = $this->db->get();
		$abonadosActivos = $query->result_array();
		return $abonadosActivos;
	}

	public function busca($dato, $activos, $criterio='descripcion')
	{
		$this->db->select('*');
		$this->db->from('abonados');
		if($activos)
			$this->db->where('activo', 1);
		if($criterio === 'cuit')
			$this->db->like('cuit', $dato);
		else{
			$this->db->group_start();
				$this->db->like('descripcion', $dato);
				if(is_numeric(trim($dato)))
					$this->db->or_like('id', $dato);
			$this->db->group_end();
		}

		$abonados = $this->db->get()->result_array();
		if(empty($abonados))
			$abonados = null;
		return $abonados;
	}
}

?>