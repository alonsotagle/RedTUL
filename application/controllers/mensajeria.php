<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class mensajeria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mensajeria_model');
    }

    public function index() {
    	$this->load->view('template/header');
        $this->load->view('template/menu');
        //$this->load->view('mensajeria');
        $this->load->view('template/footer');
    }

}