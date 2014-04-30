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
}