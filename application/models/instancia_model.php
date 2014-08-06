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
    	$this->db->select('id_instancia, instancia_nombre');

		$this->db->from('instancia');

        $this->db->order_by('instancia_nombre', 'asc');
		
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
        $this->db->select('id_instancia, instancia_nombre');
        $this->db->from('instancia');

        $this->db->like('instancia_nombre', $parametros['instancia_nombre']);

        $this->db->order_by('instancia_nombre', 'asc');

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function eliminar($id_instancia)
    {
        $this->db->delete('instancia', array('id_instancia' => $id_instancia));
    }

    public function editar_instancia($instancia)
    {
        $this->db->where('id_instancia', $instancia['id_instancia']);
        unset($instancia['id_instancia']);

        $this->db->update('instancia', $instancia);
    }

    public function registrar($nueva_instancia)
    {
        $this->db->insert('instancia', $nueva_instancia);
    }

}