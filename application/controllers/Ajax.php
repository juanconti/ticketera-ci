<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends Extended_Controller {

	public function __construct(){
		Parent::__construct();
		$this->validaClienteAjax();
	}


	public function index()
	{
		print json_encode(apache_request_headers());
	}
	
	public function abonado($id)
	{
		$this->load->model('abonados_model');
		$abonado = $this->abonados_model->getAbonado($id);

		if(empty($abonado))
			print json_encode(['error' => 'No existe el abonado.']);
		else
			print json_encode($abonado);
	}
	
	public function buscarAbonados()
	{
		$this->load->model('abonados_model');

		$busqueda   = $this->input->post('query');
		$activos    = $this->input->post('activos');
		$criterio   = $this->input->post('criterio');

		if(!is_bool($activos) && !is_numeric($activos))
			$activos = $activos == 'true' ? true : false;

		if (preg_match("/[A-Z  | a-z | 0-9]+/", $busqueda) && !isset($datos))
			$resultados = $this->abonados_model->busca(trim($busqueda), $activos, $criterio);

		$datos['resultados'] = $resultados;

		if(tienePermisos(['ABONADOS_ABM']))
			$datos['puedeEditar'] = true;
	

		if(isset($datos['resultados']) && !empty($datos['resultados']))
			print json_encode($datos);
		else
			print json_encode(['resultados'=>['error' => 'No se encontraron resultados']]);
	}

	public function usuario($id)
	{
		$error = null;
		
		if($id === 1){
		    print json_encode ('No se puede realziar esta consulta');
		    exit;
		}

		if(tienePermisos(['USUARIOS_ABM'])){
			$this->load->model('usuarios_model');
			$usuario = $this->usuarios_model->getUsuario($id);

			if(empty($usuario))
				$error = 'No existe el usuario.';
		}
		else
			$error = 'No tiene los permisos nescesarios';

		if($error !== null)
			print json_encode(['error' => $error]);
		else
			print json_encode($usuario);
	}
	
	public function buscarUsuarios()
	{
		$this->load->model('usuarios_model');

		$queryUsuario 	= $this->input->post('queryUsuario');
		$idSector 		= $this->input->post('sectores_id');

		$response = $this->usuarios_model->buscarUsuarios($queryUsuario, $idSector);

		print json_encode($response);
		exit;
	}
	
	public function usuariosPorFiltros()
	{
		$this->validaUsuario('USUARIOS_ABM');

		$sectores_id 	= $this->input->get('sectores_id')?:null;
		$activos 	= $this->input->get('activos')==='true'?true:false;

		$this->load->model('usuarios_model');

		$response = $this->usuarios_model->getUsuariosPorFiltros($activos, $sectores_id);

		if(empty($response))
			print json_encode(['error' => 'No se han encontrado resultados.']);
		else
			print json_encode($response);
		exit;
	}
	
	public function sector($id)
	{
		$response = [];

		if(!$this->esAdmin()){
			$response['error'] = 'No tiene los permisos para realizar esta acción.';
			print json_encode($response);
		}
		else{
			$this->load->model('sectores_model');
			$response = $this->sectores_model->getSector($id);
			$response['permisos'] = $this->sectores_model->getPermisosBySector($id);
			print json_encode($response);
		}
	}

	public function ticket($id)
	{
		$this->load->model('tickets_model');
		$idSectorDelUsuario = $_SESSION['usuario']['sector']['id'];

		if($this->esAdmin()){
			$ticket = $this->tickets_model->getTicket($id);
			if(empty($ticket))
				$error = "El ticket no existe";
		}
		else{
			$response = $this->tickets_model->getTkFromSector($id, $idSectorDelUsuario);
			if(empty($response))
				$error = "El ticket no existe o no corresponde a su sector.";
			else
				$ticket = $response;
		}

		if(!isset($error))
			print json_encode($ticket);
		else
			print json_encode(['error' => $error]);
	}
	
	public function buscarTickets()
	{
		$idTicket   = $this->input->get('tickets_id') === '' ? null : $this->input->get('tickets_id');
		$idUsuario  = $this->input->get('usuarios_id') === '' ? null : $this->input->get('usuarios_id');
		$idAbonado  = $this->input->get('abonados_id') === '' ? null : $this->input->get('abonados_id');
		$idTkEstado = $this->input->get('tkEstado_id') === '' ? null : $this->input->get('tkEstado_id');	

		$idSectorDelUsuario = $this->session->usuario['sector']['id'];

		$this->load->model('tickets_model');
		
		
		if($idTicket === null && $idUsuario === null && $idAbonado === null && $idTkEstado === null)
		    $response = ['error'=>'No se han colocado parametros.'];
		elseif($idTicket !== null && !$this->esAdmin())
		    $response = $this->tickets_model->getTkFromSector($idTicket, $idSectorDelUsuario);
		elseif($idTicket !== null && $this->esAdmin())
		    $response = $this->tickets_model->getTicket($idTicket);
		else
		    $response = $this->tickets_model->buscarTk($idAbonado, $idUsuario, $idTkEstado, $idSectorDelUsuario);		

		if($response !== null){
		    print json_encode($response);
		    exit;
		}
		else{
			print json_encode(['error'=>'No se ha encontrado resultados.']);
			exit;
		}
	}

	public function bitacora($idBitacora)
	{
		$this->load->model('tickets_model');

		// Se busca la bitacora y se realizan las comprobaciones de permisos
		if($this->esAdmin())
			$bitacora = $this->tickets_model->getBitacora($idBitacora);
		else{
			print json_encode([error => 'El usuario no tiene los permisos nescesarios']);
			exit;
		}

		// Se revisan los errores relacionados a la busqueda de bitacoras
		if($bitacora === null)
			$error = 'La bitacora no existe.';
		if(isset($bitacora['error']))
			$error = $bitacora['error'];

		if(isset($error))
			print json_encode(['error' => $error]);
		else
			print json_encode($bitacora);
	}
}
