<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class confirmacion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('confirmacion_model');
    }

    public function index($id_curso) {

        $datos_curso = $this->confirmacion_model->consulta_curso($id_curso);

    	$this->load->view('template/header');
        $this->load->view('confirmacion', $datos_curso);
        $this->load->view('template/footer');
    }

    public function verifica_contacto()
    {
        $contacto_correo = $this->input->get('verificar_correo');

        $datos_contacto = $this->confirmacion_model->verifica_contacto($contacto_correo);

        print_r(json_encode($datos_contacto));
    }

    public function confirmar_inscripcion()
    {
        $this->confirmacion_model->confirmar_inscripcion($_POST);

        $this->load->view('template/header');
        $this->load->view('confirmacion_inscripcion');
        $this->load->view('template/footer');
    }

}
