<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class inicio_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('America/Mexico_City');
    }

    public function consulta_cursos()
    {
        $this->db->select('id_curso,
                            curso_titulo,
                            curso_tipo,
                            curso_fecha_inicio,
                            curso_hora_inicio,
                            curso_hora_fin,
                            curso_cupo');

        $this->db->from('curso');

        $this->db->where('curso_fecha_inicio >=', date("Y-m-d")); 

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function contar_inscritos($id_curso)
    {
        $this->db->from('contacto_estado_curso');
        
        $this->db->where('curso_id', $id_curso);
        $this->db->where('estado_id', 3);

        $query = $this->db->count_all_results();

        return $query;
    }

    public function consulta_contactos()
    {
        $this->db->select('contacto.id_contacto,
                            contacto.contacto_nombre,
                            contacto.contacto_ap_paterno,
                            contacto.contacto_ap_materno,
                            contacto.contacto_correo_inst,
                            contacto.contacto_correo_per,
                            instancia.instancia_nombre');

        $this->db->from('contacto');
        $this->db->join('instancia', 'contacto.contacto_instancia = instancia.id_instancia');

        $this->db->order_by("contacto.id_contacto", "desc");

        $this->db->limit(5);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }
}