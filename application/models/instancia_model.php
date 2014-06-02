<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class instancia_model extends CI_Model{
    
    
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function consulta_instancias()
    {
    	$this->db->select('id_instancia,
    						instancia_nombre');

		$this->db->from('instancia');
		
		$query = $this->db->get();

		if ($query -> num_rows() > 0)
		{
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function busqueda_instancias($parametros)
    {
        $this->db->select('id_instancia,
                            instancia_nombre');
        $this->db->from('instancia');

        $this->db->like('instancia_nombre', $parametros['instancia_nombre']);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }



}