<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class contactos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contacto_model');
    }

    public function index() {
    	$this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('contactos');
        $this->load->view('template/footer');
    }

    public function nuevo() {
        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('nuevo_contacto');
        $this->load->view('template/footer');
    }

    function registrar_contacto(){
        if (!empty($_POST)) {
            $nuevo_contacto = array(
                'contacto_estatus' => $this->input->post('estatus_contacto'),
                'contacto_tipo' => $this->input->post('tipo_contacto'),
                'contacto_instructor' => $this->input->post('instructor_candidato'),
                'contacto_nombre' => $this->input->post('contacto_nombre'),
                'contacto_ap_paterno' => $this->input->post('contacto_apaterno'),
                'contacto_ap_materno' => $this->input->post('contacto_amaterno'),
                'contacto_instancia' => $this->input->post('contacto_instancia'),
                'contacto_adscripcion' => $this->input->post('contacto_adscripcion'),
                'contacto_funciones' => $this->input->post('contacto_funciones'),
                'contacto_telefono' => $this->input->post('contacto_telefono'),
                'contacto_extension' => $this->input->post('contacto_extension'),
                'contacto_correo_inst' => $this->input->post('contacto_correoinst'),
                'contacto_correo_per' => $this->input->post('contacto_correopers'),
                'contacto_avatar' => "/",
                'contacto_comunicacion' => $this->input->post('comunicacion_contacto'),
            );
            $this->contacto_model->registrar_contacto($nuevo_contacto);

        }
    }

    function consulta_contactos()
    {
        $contactos = $this->contacto_model->consulta_contactos();

        foreach($contactos as $llave => &$contacto)
        {
            if ($contacto['contacto_estatus'] == '1')
            {
                $contacto['contacto_estatus'] = 'Activo';
            }else{
                $contacto['contacto_estatus'] = 'Inactivo';
            }
        }

        print_r(json_encode($contactos));
    }

    function consulta_instancias()
    {
        $instancias = $this->contacto_model->consulta_instancias();

        print_r(json_encode($instancias));
    }
}