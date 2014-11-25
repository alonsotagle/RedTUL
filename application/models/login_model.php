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

    public function consulta_identificador($identificador){
        $this->db->from('contacto');
        $this->db->where('contacto_IDU', $identificador);
        $this->db->where('contacto_rol', 0);

        $query = $this->db->get();

        if($query->num_rows() == 1){
            return $query->row();
        }else{
            return null;
        }
    }
}
