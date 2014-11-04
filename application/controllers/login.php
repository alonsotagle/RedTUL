<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->library('Idu');
    }

    public function index() {
        if ($this->session->userdata('logged')) {
            redirect('inicio');
        }else{
            $this->load->view('template/header');
            $this->load->view('login_view');
            $this->load->view('template/footer');
        }
    }

    public function idaut() {

        $identificador = null;
        $datosUsuario = null;

        $this->Idu = new Idu();
        $ticket = $this->input->get('ticket');
        $app_validate_url = site_url('login/idaut');

        try{
            $id_idu = $this->Idu->getIdentificadorIDU($ticket, $app_validate_url);
            $datosUsuario = $this->Idu->consultaPorIdu($id_idu);
            
            $identificador = $id_idu;
            $datosUsuario = $datosUsuario;

            $data = array(
                'id'        => $identificador,
                'logged'    => TRUE
            );

            $this->session->set_userdata($data);
            //$this->verificarDatos($identificador, $datosUsuario);
            $this->verificarDatos($identificador);
        }catch(IduException $exception){
            //Redirect al login
            redirect($this->Idu->getIduLoginURL($app_validate_url));
        }
    }

    public function logout() {
        $this->session->sess_destroy();

        $this->Idu = new Idu();
        $app_login_url = site_url('login');

        $iduLogoutURL = $this->Idu->getIduLogoutURL($app_login_url);
        redirect($iduLogoutURL);
    }

    public function verificarDatos($identificador){
        $contacto = $this->login_model->consulta_identificador($identificador);

        if (is_null($contacto)) {
            $this->session->sess_destroy();
            $this->load->view('template/header');
            $this->load->view('micrositio');
            $this->load->view('template/footer');
        }else{
            redirect('inicio');
        }
    }
}