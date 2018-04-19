<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Extended_Controller extends CI_Controller{

	public function __construct()
	{
		Parent::__construct();
	}

	public function validaUsuario($permisos = null)
	{
		if (!isset($this->session->usuario)){
			if(uri_string() !== '')
				$this->session->set_flashdata('error_login', 'Debe loguearse antes de ingresar a esa seccion.');
			redirect(base_url('auth/login'));
		}

		if($permisos !== null){
			$tienePermiso = false;

			if(!is_array($permisos) && $permisos != null)
				$permisos = [$permisos];

			//Se agrega la excepcion para el permiso ADMIN
			array_push($permisos, 'ADMIN');

			if(count($permisos) == 1){
				if(in_array($permisos, $_SESSION['usuario']['permisos']))
					$tienePermiso = true;
			}
			else{
					foreach ($permisos as $permiso) {
						if(in_array($permiso, $_SESSION['usuario']['permisos'])){
							$tienePermiso = true;
							break;
						}
					}
			}

			if(!$tienePermiso){
				$this->session->set_flashdata('error', 'No tiene los permisos adecuados para ingresar a esa seccion');
				redirect(base_url('tickets'));
			}
		}
	}

	public function validaClienteAjax()
	{
		$reqHeaders = apache_request_headers();

		if (!isset($reqHeaders['X-Requested-With']) || $reqHeaders['X-Requested-With'] !== "XMLHttpRequest")
			redirect(base_url('auth/login'));
		else
			header('Content-Type: application/json');

		if(!isset($this->session->usuario['id'])){
			print json_encode(['error' => 'El usuario no está logeado']);
			exit;
		}
	}

	protected function getUsuarioPermisos()
	{
		$response = [];
		$this->load->model('usuarios_model');
		$this->load->model('sectores_model');
		$usuario_id = $this->session->usuario['id'];

		$usuario = $this->usuarios_model->getUsuarioFull($usuario_id);

		//Toma los permisos y los permisos extra
		if(!empty($usuario) && $usuario['activo'] == 1){
			if (!empty($usuario['permiso_extra']))	$permiso_extra = $this->sectores_model->getPermiso($usuario['permiso_extra']);
			$sector_id = $usuario['sectores_id'];
			$permisos_sector = $this->sectores_model->getPermisosBySector($sector_id);
		}
		else{
			return ['error' => 'El usuario no existe o está inhabilitado.'];
			exit;
		}

		foreach($permisos_sector as $permiso){
			array_push($response, $permiso['descripcion']);
		}

		if(isset($permiso_extra)){
			array_push($response, $permiso_extra['descripcion']);
		}

		$_SESSION['usuario']['permisos'] = $response;
		return $response;
	}

	protected function esAdmin()
	{
		$this->getUsuarioPermisos();
		if(in_array('ADMIN', $_SESSION['usuario']['permisos']))
			return true;
		else
			return false;
	}

	public function getDefaultView($viewContenido, $datos = null, $scripts = null)
	{
		$view['head'] 		=	$this->load->view('layout/head', [], true);
		$view['nav']		=	$this->load->view('layout/nav', [], true);
		$view['footer'] 	=	$this->load->view('layout/footer', [], true);
		$view['scripts'] 	=	$this->load->view('layout/scripts', ['scripts' => $scripts], true);
		$view['contenido'] 	=	$this->load->view(strtolower($viewContenido), $datos, true);

		$this->load->view('layout/layout', $view);
	}

	public function triggerError($error, $urlDestino='tickets')
	{
		$this->session->set_flashdata('error', $error);
		redirect(base_url($urlDestino));
	}
}
