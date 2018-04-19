<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends Extended_Controller {

    public function __construct(){
        Parent::__construct();
        $this->validaUsuario();
    }

    public function index()
    {
        $this->load->model('usuarios_model');
        $this->load->model('sectores_model');

        $idUsuario = $this->session->usuario['id'];

        $datos['usuario']       = $this->usuarios_model->getUsuario($idUsuario);
        $datos['validacion']    = $this->session->flashdata('validacion_perfil_index');
        $datos['feedback']      = $this->session->flashdata('feedback');

        $this->getDefaultView('Perfil/perfil_index', $datos);
    }

    public function editar_post()
    {
        if ($this->form_validation->run('perfil_editar') == false){
            $this->session->set_flashdata('validacion_perfil_index', validation_errors('<div class="error">- ', '</div>'));
            redirect(base_url('perfil'));
        }
        $email      = $this->input->post('email');
        $nombre     = $this->input->post('nombre');
        $apellido   = $this->input->post('apellido');

        $this->load->model('usuarios_model');

        $sqlResponse = $this->usuarios_model->updatePerfilUsuario($email , $nombre, $apellido);

        if($sqlResponse['affected_rows'] > 0){
            $this->session->usuario['email']    = $email;
            $this->session->usuario['nombre']   = $nombre;
            $this->session->usuario['apellido'] = $apellido;
            $this->session->set_flashdata('feedback', 'Se modificó el perfil correctamente.');
            redirect(base_url('perfil'));
        }
        else{
            $this->triggerError('Error con edicion de perfil.');
        }
    }

    public function cambiaClave_post()
    {
        if ($this->form_validation->run('perfil_contraseña') == false){
            $this->session->set_flashdata('validacion_perfil_index', validation_errors('<div class="error">- ', '</div>'));
            redirect(base_url('perfil'));
        }
        $this->load->model('usuarios_model');
        $oldClave = $this->input->post('oldClave');
        $newClave = $this->input->post('newClave');

        $validaOldClave = $this->usuarios_model->validaUsuarioClave($oldClave);

        if($validaOldClave === '1')
            $sqlResponse = $this->usuarios_model->updateClave($newClave);
        else{
            $this->session->set_flashdata('validacion_perfil_index', 'La contraseña actual no es correcta.');
            redirect(base_url('perfil'));
        }

        if(isset($sqlResponse) && $sqlResponse['affected_rows'] !== 1){
            $this->session->set_flashdata('validacion_perfil_index', "Hubo un error, no se modificó la contraseña.");
            redirect(base_url('perfil'));
        }

        $this->session->set_flashdata('feedback', 'La contraseña se modificó correctamente');
        redirect(base_url('perfil'));
    }

}
