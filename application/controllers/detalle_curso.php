<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class detalle_curso extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('confirmacion_model');
    }

    public function index($id_curso = null) {
        if (is_null($id_curso)) {
            show_404();
        }else{
            $datos_curso = $this->confirmacion_model->consulta_curso($id_curso);

            if (is_null($datos_curso)) {
                show_404();
            } else {
                $this->load->view('template/header');
                $this->load->view('detalle_curso_usuario', $datos_curso);
                $this->load->view('template/footer');
            }
        }
    }
}