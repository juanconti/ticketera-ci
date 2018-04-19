<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends Extended_Controller {

	public function __construct(){
		Parent::__construct();
		$this->validaUsuario(['ADMIN', 'USUARIOS_ABM']);
	}


	public function index()
	{
		//Se cargan los modelos
		$this->load->model('usuarios_model');
		$this->load->model('sectores_model');

		$datos['usuarios'] = $this->usuarios_model->getUsuarios();
		$datos['sectores'] = $this->sectores_model->getSectores();

		$this->getDefaultView('Usuarios/usuarios_index', $datos);
	}


	public function perfil($id)
	{
		$this->load->model('usuarios_model');
		$datos = [];
		$datos['usuario'] = $this->usuarios_model->getUsuario($id);

		$this->getDefaultView('Usuarios/perfil_publico', $datos);
	}


	public function alta()
	{
		$this->load->model('sectores_model');

		$datos['sectores']      = $this->sectores_model->getSectoresActivos();
		$datos['permisos']      = $this->sectores_model->getPermisos();
		$datos['validacion']    = $this->session->flashdata('validacion_usuarios_alta');
		$datos['oldValues']     = $this->session->flashdata('oldValues');

		$this->getDefaultView('Usuarios/alta', $datos);
	}


	public function alta_post()
	{
		$this->form_validation->set_message('is_unique', 'Ya existe ese %s, pruebe con otro');
		$this->form_validation->set_message('matches[password]', 'Las contraseñas otorgadas no coinciden');
		$this->form_validation->set_message('matches[password]', 'Las contraseñas otorgadas no coinciden');
		$this->form_validation->set_message('in_list', 'El campo %s es incorrecto');

		if ($this->form_validation->run('usuarios_alta') == false){
			$this->session->set_flashdata('validacion_usuarios_alta', validation_errors('<div class="error">', '</div>'));
			/* Se pasan los valores autorizados anteriores*/
			$oldValues = [];
			$oldValues['username']  = strtolower($this->input->post('username'));
			$oldValues['sector']    = $this->input->post('sector');
			$oldValues['email']     = $this->input->post('email');
			$oldValues['nombre']    = $this->input->post('nombre');
			$oldValues['apellido']  = $this->input->post('apellido');

			$this->session->set_flashdata('oldValues', $oldValues);

			redirect(base_url('usuarios/alta'));
		}
		else{
			$username	=	strtolower($this->input->post('username'));
			$sector 	=	$this->input->post('sector');
			$clave		=	$this->input->post('password');
			$email		=	$this->input->post('email');
			$estado		=	$this->input->post('estado') === '1' ? true : false;
			$nombre		=	$this->input->post('nombre');
			$apellido	=	$this->input->post('apellido');

			$this->load->model('usuarios_model');

			$response = $this->usuarios_model->setUsuario($username, $sector, $clave, $email, $estado, $nombre, $apellido);

			if(isset($response['error']))   $this->session->flashdata('error', $response['error']);
			if(isset($response['insert_id'])){
				$msg = "El usuario con id ".$response['insert_id'] . ", se ha creado con exito.";
				$this->session->flashdata('feedback', $msg);
			}

			redirect(base_url('usuarios'));
		}
	}

	public function baja()
	{
		if($this->input->post('id') == null){
			header('Content-Type: application/json');
			print json_encode(['error' => 'No se indico el id correctamente.']);
		}
		else{
			$this->load->model('usuarios_model');
			$idUsuario 	= $this->input->post('id');
			$sqlResponse = $this->usuarios_model->bajaUsuario($idUsuario);

			$response = [];

			if($sqlResponse['affected_rows'] < 1)
				$response['status'] = false;
			else
				$response['status'] = true;

			header('Content-Type: application/json');
			print json_encode($response);
			exit;
		}
	}

	public function reactiva()
	{
		if($this->input->post('id') == null){
			header('Content-Type: application/json');
			print json_encode(['error' => 'No se indico el id correctamente.']);
		}
		else{
			$idUsuario = $this->input->post('id');
			$this->load->model('usuarios_model');
			$sqlResponse = $this->usuarios_model->activaUsuario($idUsuario);

			$response = [];

			if($sqlResponse['affected_rows'] < 1)
				$response['status'] = false;
			else
				$response['status'] = true;

			header('Content-Type: application/json');
			print json_encode($response);
			exit;
		}
	}
}
