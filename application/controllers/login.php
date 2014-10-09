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
        $this->load->library('form_validation');
    }

    public function index() {
        if ($this->session->userdata('logged')) {
            redirect('inicio');
        }else{
            $data['token'] = $this->token();
            $this->load->view('template/header');
            $this->load->view('login_view', $data);
            $this->load->view('template/footer');
        }
    }

    public function token() {
        $token = md5(uniqid(rand(), true));
        $this->session->set_userdata('token', $token);
        return $token;
    }

    public function autenticacion() {

        if (isset($_POST['usr_nombre']) && isset($_POST['usr_password'])) {

            $check_user = $this->login_model->login_user(md5($_POST['usr_nombre']), md5($_POST['usr_password']));

            if ($check_user) {
                $data = array(
                    'id'        => $check_user->id_login,
                    'logged'    => TRUE
                    );
                $this->session->set_userdata($data);
            }
            redirect('/login');
        }else{
            redirect('/login');
        }
    }

    public function logout() {

        $this->session->sess_destroy();
        redirect('/login');
    }
}
