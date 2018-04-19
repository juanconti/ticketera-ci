<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends Extended_Controller {

    public function __construct(){
        Parent::__construct();
        $this->validaUsuario();
    }


    public function index($id=null)
    {
        $this->load->model('tickets_model');
        
        if($id !== null)
            redirect(base_url('tickets/ver/'.$id));
        $idUsuario  = $this->session->usuario['id'];
        $idSector   = $this->session->usuario['sector']['id'];

        if(isset($_SESSION['error']))
            $datos['error']     = $this->session->error;
        if(isset($_SESSION['feedback']))
            $datos['feedback']  = $this->session->feedback;

        $datos['tkPendSector']  = $this->tickets_model->getTksPendientesFromSector($idSector, 3);
        $datos['tkPendUsuario'] = $this->tickets_model->getTksPendientesByUsuario($idUsuario, 3);
        
        $this->getDefaultView('Tickets/tickets_index', $datos);
    }

    public function ver($id=null)
    {
        $this->load->model('tickets_model');
        $this->load->model('abonados_model');

        $ticket = $this->tickets_model->getTicket($id);

        //Se verifica si hay errores
        if($id == null)
            $error = 'Hubo un error al intentar editar este ticket';
        if($ticket == null)
            $error = 'El ticket con id ' . $id . ' no existe';
        if($ticket['sectores_id'] !==   $_SESSION['usuario']['sector']['id'] && !$this->esAdmin())
            $error = 'Este ticket no pertenece a su sector.';
        if(isset($error))
            $this->triggerError($error);

        //Revisa si tiene tickets posteriores asignados
        if($ticket['estado'] == 2)
            $ticketPosterior = $this->tickets_model->getTkRelacionado($ticket['id']);


        if(isset($ticketPosterior))
            $datos['ticketPosterior']    = $ticketPosterior;
        $datos['ticket']    = $ticket;        
        $datos['abonado']   = $this->abonados_model->getAbonado($datos['ticket']['abonados_id']);

        $this->getDefaultView('Tickets/ver', $datos);
    }

    public function buscar()
    {
        $this->load->model('usuarios_model');
        $this->load->model('tickets_model');

        $datos['usuariosDeSector'] = $this->usuarios_model->getUsuariosBySector($_SESSION['usuario']['sector']['id']);
        $datos['tkEstados'] = $this->tickets_model->getTkEstados();

        $this->getDefaultView('tickets/buscar', $datos);
    }

    public function alta()
    {
        $datos['validacion']    = $this->session->flashdata('validacion_tickets_alta');
        $datos['ticketPrevio']  = null;
        $this->getDefaultView('tickets/alta', $datos);
    }

    public function continuar($idTicket=null)
    {
        $this->load->model('tickets_model');
        
        $idSector = $_SESSION['usuario']['sector']['id'];

        if($idTicket == null)
            $this->triggerError('No se pudo tomar correctamente el ticket a continuarse.');

        //Se trae el ticket previo. Si el usuario es admin trae cualquier ticket, sino fuerza a que el tk sea del sector
        if($this->esAdmin())
            $ticketPrevio = $this->tickets_model->getTicket($idTicket);
        else
            $ticketPrevio = $this->tickets_model->getTkFromSector($idTicket, $idSector);

        //Se compureba que el ticket previo exista o el usuario tenga permiso para acceder a el
        if($ticketPrevio == null || !isset($ticketPrevio[0]))
            $this->triggerError('El ticket con id '. $ticketPrevio['id'] .' no existe o no pertenece su secto, '.$_SESSION['usuario']['sector']['descripcion']);

        $ticketPrevio = $ticketPrevio[0];
        
        //Se comprueba que el ticket no esté ya continuado
        if($ticketPrevio['estado'] == 2){
            $tkRelacionado = $this->tickets_model->getTkRelacionado($ticketPrevio['id']);
            $this->triggerError('Este Ticket ya está continuado en el ticket <a href="' . base_url('tickets/ver/'.$tkRelacionado['id']) . '">id '.$tkRelacionado['id'].'</a>.');
        }

        $datos['validacion']    = $this->session->flashdata('validacion_tickets_alta');
        $datos['ticketPrevio']  = $ticketPrevio;

        
        $this->getDefaultView('tickets/continuar', $datos);
    }

    public function alta_post()
    {
        $this->load->model('tickets_model');
        
        if($this->form_validation->run('tickets_alta') == false){
            $this->session->set_flashdata('validacion_tickets_alta', validation_errors());
            redirect(base_url('tickets/alta'));
        }
        else{
            $titulo         =   $this->input->post('titulo');
            $cuerpo         =   $this->input->post('cuerpo');
            $prioridad      =   $this->input->post('prioridad');
            $abonados_id    =   $this->input->post('abonado_id');
            $estado         =   $this->input->post('estado');
            $usuarios_id    =   $this->session->usuario['id'];

            if($this->input->post('ticketPrevio_id') !== '' || $this->input->post('ticketPrevio_id') != null){
                $relacion = $this->input->post('ticketPrevio_id');
                $tkPrevio = $this->tickets_model->updateTkEstado($relacion , 2);
                if($tkPrevio['affected_rows'] == 0)
                    $this->triggerError('No existe el ticket n'.$relacion.' que intenta editar.');
            }
            else
                $relacion = 0;

            $sqlResponse = $this->tickets_model->setTicket($titulo,$cuerpo,$prioridad,$abonados_id,$usuarios_id,$estado,$relacion);

            if(isset($sqlResponse['error']))
                $this->tiggerError($error);
            else{
                $response['link'] = $this->config->base_url('tickets/ver/'.$sqlResponse['insert_id']);
                $feedback = 'El ticket con id <a href="'.$response['link'].'" class="alert-link">n° '.$sqlResponse['insert_id'].'</a> ha sido creado con exito.';
                $this->session->set_flashdata('feedback', $feedback);
                redirect(base_url('tickets'));
            }
        };        
    }

    public function cadena($idTicket=null)
    {
        if($idTicket===null)
            $this->triggerError('No ha indicado el ticket del que obtener la cadena');
	
        $this->load->model('tickets_model');
        $idSectorFromUsuario = $_SESSION['usuario']['sector']['id'];
        $currentTk = $this->tickets_model->getTkFromSector($idTicket, $idSectorFromUsuario);
        
        if($currentTk === null)
            $this->triggerError('El ticket que indico para obtener su cadena no existe o no pertenece a su sector');
        elseif($currentTk['estado'] !== 2 && $currentTk['relacion'] === 0)
	    $this->triggerError('El ticket '.$idTicket.' no está continuado ni tiene tickets previos.');

        $cadenaTk = $this->tickets_model->getCadenaTk($idTicket);
	var_dump($cadenaTk);
    }

    public function editar($id=null)
    {
        $this->load->model('tickets_model');
        $this->load->model('abonados_model');
        
        $ticket = $this->tickets_model->getTicket($id);
        //Se verifica si hay errores
        if($id == null)
            $error = 'Hubo un error al intentar editar este ticket';
        if($ticket == null)
            $error = 'El ticket con id ' . $id . ' no existe';
        if($ticket['usuarios_id'] !== $_SESSION['usuario']['id'] && !$this->esAdmin())
            $error = 'El ticket con id ' . $id . ' no pertenece a su usuario.';

        if(isset($error))
            $this->triggerError($error);        

        $datos['ticket']        = $ticket;
        $datos['abonado']       = $this->abonados_model->getAbonado($datos['ticket']['abonados_id']);
        $datos['validacion']    = $datos['validacion'] = $this->session->flashdata('validacion_tickets_alta');

        $this->getDefaultView('tickets/editar', $datos);
    }


    public function editar_post()
    {
        $this->load->model('Tickets_model');
        
        $idTicket = $this->input->post('tickets_id');
        
        if($this->form_validation->run('tickets_alta') == false){
            $this->session->set_flashdata('validacion_tickets_alta', validation_errors());
            redirect(base_url('tickets/editar/'.$idTicket));
        }
        else{
            $titulo     = $this->input->post('titulo');
            $cuerpo     = $this->input->post('cuerpo');
            $prioridad  = $this->input->post('prioridad');
            $estado     = $this->input->post('estado');
            $sqlResponse = $this->tickets_model->updateTicket($idTicket,$titulo,$cuerpo,$prioridad,$estado);

            if(isset($sqlResponse['error']))
                $this->tiggerError($error);
            else{
                $feedback = 'El ticket con id <strong>n ' . $idTicket . '</strong> ha sido editado con exito.';
                $this->session->set_flashdata('feedback', $feedback);
                redirect(base_url('tickets'));
            }
        }
    }
}
