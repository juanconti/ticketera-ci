<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Extended_Controller {

	public function __construct(){
		Parent::__construct();
		$this->validaUsuario(['ADMIN']);
	}

	public function index()
	{
		$this->load->model('sectores_model');
		$datos['sectoresExistentes']	= $this->sectores_model->getSectores();
		$datos['allPermisos']			= $this->sectores_model->getPermisos();
		$datos['validacion']			= $this->session->flashdata('validacion_admin');
		$datos['feedback']				= $this->session->flashdata('feedback');

		$this->getDefaultView('Admin/admin_index', $datos);
	}

	public function edita_sector()
	{
		if($this->form_validation->run('edita_sector') == false){
			$this->session->set_flashdata('validacion_admin', validation_errors());
			redirect(base_url('admin'));
		}
		if($this->input->post('sector_id') == 1)
			$this->triggerError('No se puede modificar el sector admin.');
		$this->load->model('sectores_model');

		$id 			= $this->input->post('sector_id');
		$descripcion 	= $this->input->post('sector_descripcion');
		$permisos 		= $this->input->post('sector_permisos');
		$activo 		= $this->input->post('sector_activo');

		$sqlResponse = $this->sectores_model->updateSector($id, $descripcion, $permisos, $activo);

		if($sqlResponse['affected_rows'] < 1)	$this->triggerError($sqlResponse['error']);
		else{
			$this->session->set_flashdata('feedback', 'Se ha actualizado el sector correctamente.');
			redirect(base_url('admin'));
		}
	}

	public function alta_sector()
	{
		if($this->form_validation->run('alta_sector') == false){
			$this->session->set_flashdata('validacion_admin', validation_errors());
			redirect(base_url('admin'));
		}
		$this->load->model('sectores_model');
		$descripcion 	= $this->input->post('sector_descripcion');
		$permisos 		= $this->input->post('sector_permisos');
		$activo 		= $this->input->post('sector_activo');

		$this->sectores_model->setSector($descripcion,$permisos,$activo);

		redirect(base_url('admin'));
	}

	public function bitacora($idTicket=null)
	{
		if($idTicket === null)	$this->triggerError('Hubo un error al intentar precesar el id del ticket de bitacora.');
		$this->load->model('tickets_model');

		$bitacoraTk = $this->tickets_model->getBitacoraTk($idTicket);;

		if($bitacoraTk == null)
			$this->triggerError('No se puede revisar la bitacora del ticket id '.$idTicket);

		$datos['bitacoraTk'] = $bitacoraTk;

		$this->getDefaultView('admin/bitacora', $datos);
	}

	public function modificaclave()
	{
		if ($this->form_validation->run('admin_perfil_contraseña') == false){
			$this->session->set_flashdata('validacion_admin', validation_errors('<div class="error">- ', '</div>'));
			redirect(base_url('admin'));
		}

		$this->load->model('usuarios_model');

		$usuarios_id = $this->input->post('usuarios_id');
		$clave = $this->input->post('new-clave');

		$sqlResponse = $this->usuarios_model->updateClave($clave, $usuarios_id);


		if(isset($sqlResponse) && $sqlResponse['affected_rows'] !== 1){
			$this->session->set_flashdata('validacion_admin', 'Hubo un error, no se modificó la contraseña.');
			redirect(base_url('admin'));
		}

		$this->session->set_flashdata('feedback', 'La contraseña del usuario <a href="'.base_url('usuarios/perfil/'.$usuarios_id).'"/>'.$usuarios_id.'</a> se modificó correctamente');
		redirect(base_url('admin'));
	}
	
	public function tickets()
	{
	    $this->load->model('usuarios_model');
	    $this->load->model('tickets_model');

	    $datos['tkEstados'] = $this->tickets_model->getTkEstados();
	    $datos['usuariosDeSector'] = $this->usuarios_model->getUsuarios();
	    
	    $this->getDefaultView('tickets/buscar',$datos);
	}

}