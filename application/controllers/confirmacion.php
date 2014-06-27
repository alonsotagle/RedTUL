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

        if (is_null($datos_curso)) {
            show_404();
        } else {
            $this->load->view('template/header');
            $this->load->view('confirmacion', $datos_curso);
            $this->load->view('template/footer');
        }
    }

    public function verifica_contacto()
    {
        $contacto_correo = $this->input->post('correo');

        $datos_contacto = $this->confirmacion_model->verifica_contacto($contacto_correo);

        if (!is_null($datos_contacto)) {
            $datos_contacto["invitado"] = $this->confirmacion_model->invitado_curso($datos_contacto["id_contacto"], $this->input->post('id_curso'));
            $datos_contacto["contacto_estatus"] = $this->confirmacion_model->estatus_contacto($datos_contacto["id_contacto"], $this->input->post('id_curso'));
        }

        print_r(json_encode($datos_contacto));
    }

    public function confirmar_inscripcion()
    {
        $this->confirmacion_model->confirmar_inscripcion($_POST);

        $this->load->view('template/header');
        $this->load->view('confirmacion_inscripcion');
        $this->load->view('template/footer');
    }

    public function consulta_instancias()
    {
        $instancias = $this->confirmacion_model->consulta_instancias();

        print_r(json_encode($instancias));
    }

    public function actualizar_contacto()
    {
        $this->confirmacion_model->actualizar_contacto($_POST);
    }

    public function cancelar_inscripcion()
    {
        $this->confirmacion_model->cancelar_inscripcion($_POST);

        $this->load->view('template/header');
        $this->load->view('cancelar_inscripcion');
        $this->load->view('template/footer');
    }
}
