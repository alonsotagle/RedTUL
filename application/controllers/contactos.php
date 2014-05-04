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
            $this->confirmacion_contacto();
        }
    }

    function confirmacion_contacto(){
            $contacto = array(
                'nombre' => $this->input->post('contacto_nombre'),
                'paterno' => $this->input->post('contacto_apaterno'),
                'materno' => $this->input->post('contacto_amaterno'),
                'instancia' => $this->input->post('contacto_instancia_nombre'),
                'adscripcion' => $this->input->post('contacto_adscripcion'),
                'funciones' => $this->input->post('contacto_funciones'),
                'telefono' => $this->input->post('contacto_telefono'),
                'correoinst' => $this->input->post('contacto_correoinst'),
                'correopers' => $this->input->post('contacto_correopers')
                );

            if ($this->input->post('estatus_contacto') == 0) {
                $contacto['estatus'] = "Inactivo";
            }else{
                $contacto['estatus'] = "Activo";
            }

            switch ($this->input->post('tipo_contacto')) {
                case 1:
                    $contacto['tipo'] = "Webmaster";
                    break;
                case 2:
                    $contacto['tipo'] = "Responsable de comunicación";
                    break;
                case 3:
                    $contacto['tipo'] = "Responsable de técnico";
                    break;
                case 4:
                    $contacto['tipo'] = "Otros";
                    break;
                
                default:
                    break;
            }

            if (!is_null($this->input->post('comunicacion_contacto'))) {
                if ($this->input->post('comunicacion_contacto') == 0) {
                    $contacto['comunicacion'] = "Vía telefónica";
                }else{
                    $contacto['comunicacion'] = "Vía e-mail";
                }
            }
            

            $this->load->view('template/header');
            $this->load->view('template/menu');
            $this->load->view('confirmacion_contacto', $contacto);
            $this->load->view('template/footer');
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

    function eliminar($id_contacto)
    {
        $this->contacto_model->eliminar($id_contacto);

        redirect('contactos');
    }

    function editar($id_contacto)
    {
        if (empty($_POST)) {

            $variables = array('id_contacto' => $id_contacto);

            $this->load->view('template/header');
            $this->load->view('template/menu');
            $this->load->view('editar_contacto', $variables);
            $this->load->view('template/footer');
        }else{
            $contacto = array(
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
            $contacto['id_contacto'] = $id_contacto;
            $this->contacto_model->editar_contacto($contacto);
            $this->confirmacion_contacto();
        }
    }

    function consulta_contacto($id_contacto)
    {
        $contacto = $this->contacto_model->consulta_contacto($id_contacto);

        print_r(json_encode($contacto));
    }
}