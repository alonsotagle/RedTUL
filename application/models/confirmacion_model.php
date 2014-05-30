<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class confirmacion_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function consulta_curso($id_curso)
    {
        $this->db->where('id_curso', $id_curso);
        $this->db->from('curso');

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->row();
        } else {
            return null;
        }
    }

    public function verifica_contacto($contacto_correo)
    {
        $this->db->select('contacto.id_contacto,
                            contacto.contacto_nombre,
                            contacto.contacto_ap_paterno,
                            contacto.contacto_ap_materno,
                            contacto.contacto_adscripcion,
                            instancia.instancia_nombre');

        $this->db->where('contacto.contacto_correo_inst', $contacto_correo);
        $this->db->or_where('contacto.contacto_correo_per', $contacto_correo); 
        $this->db->from('contacto');
        $this->db->join('instancia', 'contacto.contacto_instancia = instancia.id_instancia');

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->row();
        } else {
            return null;
        }
    }

    public function confirmar_inscripcion($nueva_inscripcion)
    {
        $this->db->insert('curso_inscrito', $nueva_inscripcion);
    }

}