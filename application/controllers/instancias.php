<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class instancias extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('instancia_model');
    }

    public function index() {
    	$this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('instancias');
        $this->load->view('template/footer');
    }

    function consulta_instancias()
    {
        $instancias = $this->instancia_model->consulta_instancias();

        print_r(json_encode($instancias));
    }

    function busqueda_instancias()
    {
        $parametros = array(
            'instancia_nombre' => $this->input->post('instancia_nombre')
        );

        $resultado = $this->instancia_model->busqueda_instancias($parametros);

        print_r(json_encode($resultado));
    }
}