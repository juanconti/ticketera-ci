<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Abonados extends Extended_Controller {

	public function __construct(){
		Parent::__construct();
		$this->getUsuarioPermisos();
		$this->validaUsuario();
		$this->load->model('abonados_model');
	}


	public function index()
	{
		$datos['feedback'] = $this->session->flashdata('feedback');
		$datos['query']		= $this->input->get('query');
		$datos['activos']	= $this->input->get('activos');

		$this->getDefaultView('Abonados/abonados_index', $datos);
	}

	public function alta()
	{
		$this->validaUsuario(['ABONADOS_ABM']);

		$datos['validacion'] = $this->session->flashdata('validacion_abonados_alta');

		$this->getDefaultView('Abonados/alta', $datos);
	}

	public function alta_post()
	{
		$this->validaUsuario(['ABONADOS_ABM']);
		
		$this->form_validation->set_message('is_unique', 'Ya existe ese %s, pruebe con otro');
		$this->form_validation->set_message('in_list', 'El campo %s es incorrecto');

		if($this->form_validation->run('abonados_alta') == false){
			$this->session->set_flashdata('validacion_abonados_alta', validation_errors('<div class="error"> ', '</div>'));
			redirect(base_url('abonados/alta'));
		}
		else{
			$descripcion = $this->input->post('descripcion');
			$cuitRaw	 = $this->input->post('cuit');
			$razonSocial = $this->input->post('razonSocial');
			$telefono	 = $this->input->post('telefono');
			$email		 = $this->input->post('email');
			$activo		 = $this->input->post('estado');

			//Se fuerza a numerico el cuit
			$cuit = str_replace('-', '',$cuitRaw);

			$response = $this->abonados_model->setAbonado($descripcion, $cuit, $razonSocial, $telefono, $email, $activo);
			redirect(base_url('abonados'));
		}
	}

	public function edita($abonados_id)
	{
		$this->validaUsuario(['ABONADOS_ABM']);

		$this->load->model('abonados_model');

		$datos = [];
		$datos['abonado'] = $this->abonados_model->getAbonado($abonados_id);
		$datos['validacion'] = $this->session->flashdata('validacion_abonados_edita');

		$this->getDefaultView('abonados/edita', $datos);
	}

	public function edita_post()
	{
		$this->load->model('abonados_model');

		$this->form_validation->set_message('in_list', 'El campo %s es incorrecto');

		if($this->form_validation->run('abonados_edita') == false){
			$this->session->set_flashdata('validacion_abonados_edita', validation_errors('<div class="error"> ', '</div>'));
			redirect(base_url('abonados/edita/'.$this->input->post('abonados_id')));
		}
		else{
			$id 			= $this->input->post('abonados_id');
			$descripcion 	= $this->input->post('descripcion');
			$cuit 			= $this->input->post('cuit');
			$razonSocial 	= $this->input->post('razonSocial');
			$telefono 		= $this->input->post('telefono');
			$email 			= $this->input->post('email');
			$activo 		= $this->input->post('estado') === '1' ? true : false;

			// var_dump($id, $descripcion, $cuit, $razonSocial, $telefono, $email, $activo);
			$response = $this->abonados_model->updateAbonado($id, $descripcion, $cuit, $razonSocial, $telefono, $email, $activo);
			if(isset($response['error'])){
				$this->session->set_flashdata('validacion_abonados_edita', validation_errors('<div class="error"> ', '</div>'));
				redirect(base_url('abonados/edita/'.$this->input->post('abonados_id')));
			}
			else{
				$this->session->set_flashdata('feedback', 'Se ha editado el abonado id '.$id.' exitosamente.');
				redirect(base_url('abonados?query='.$id));
			}
		}
	}
}
