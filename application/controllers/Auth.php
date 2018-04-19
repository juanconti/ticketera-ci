<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Extended_Controller {

	public function __construct(){
	  Parent::__construct();
	}

	public function index(){
		redirect(base_url('auth/login'));
	}


	public function login()
	{
		$errores['error'] = $this->session->flashdata('error_login');

		if (isset($this->session->usuario))
			redirect(base_url('tickets'));

		$this->load->view('auth/login', $errores);
	}


	public function login_post()
	{
		if ($this->session->usuario)
			redirect(base_url('tickets'));

		$username = htmlspecialchars($this->input->post('username'));
		$clave    = htmlspecialchars($this->input->post('password'));

		if($username === null || $clave === null) {
			$this->session->set_flashdata('error_login', 'No ingresó algun dato correctamente.');
			redirect(base_url('auth/login'));
		}

		$this->load->model('usuarios_model');
		$loginResponse = $this->usuarios_model->login($username, $clave);
		if(empty($loginResponse)){
			$this->session->set_flashdata('error_login', 'No se encontro el usuario o la contraseña no es correcta.');
			redirect(base_url('auth/login'));
		}

		$usuarioData = $this->usuarios_model->getUsuario($loginResponse['id']);

		$usuarioSession = array('usuario' => [
				'id'        =>  $usuarioData['id'],
				'username'  =>  $usuarioData['username'],
				'email'     =>  $usuarioData['email'],
				'nombre'    =>  $usuarioData['nombre'],
				'apellido'	=>  $usuarioData['apellido'],
				'sector'    =>  [
					'id' => $usuarioData['sectores_id'],
					'descripcion' => $usuarioData['sectores_descripcion']
				],
				'permisos' => null
			]
		);

		$this->session->set_userdata($usuarioSession);
		$this->getUsuarioPermisos();
		redirect(base_url('tickets'));
	}
	

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('auth/login'));
	}
}
