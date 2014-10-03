<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class login_model extends CI_Model{
    
    
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    /*Funcion para autenticación del usuario
     * donde:
     * usr_estado -> comprueba que el usuario este activo, si no esta activo no 
     * permitirá entrar
     */
    public function login_user($usuario,$password){
        $this->db->from('login');
        $this->db->where('login_usuario', $usuario);
        $this->db->where('login_password', $password);

        $query = $this->db->get();

        if($query->num_rows()==1){
            return $query->row();
        }else{
            $this->session->set_flashdata('usuario_incorrecto','Los datos de acceso son incorrectos.');
            redirect('login','refresh');
        }
    }
}
