<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class cron_model extends CI_Model{
    
    
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function consulta_estatus_cursos_pendiente()
    {
        $this->db->select('id_curso,
                            curso_fecha_inicio,
                            curso_estatus');
        $this->db->from('curso');
        $this->db->where('curso_estatus', 2);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function consulta_estatus_cursos_vigente()
    {
        $this->db->select('id_curso,
                            curso_fecha_fin,
                            curso_estatus');
        $this->db->from('curso');
        $this->db->where('curso_estatus', 1);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function update_curso_vigente($curso_id)
    {
        $this->db->where('id_curso', $curso_id);

        $this->db->update('curso', array('curso_estatus' => 1));
    }

    public function update_curso_finalizado($curso_id)
    {
        $this->db->where('id_curso', $curso_id);

        $this->db->update('curso', array('curso_estatus' => 3));
    }

    public function correos_pendientes()
    {
        $this->db->select('id_correo,
                            correo_fecha_envio');
        $this->db->from('correo');
        $this->db->where('correo_estatus', 1);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function consulta_correo($id_correo)
    {
        $query = $this->db->get_where('correo', array('id_correo' => $id_correo));

        if ($query -> num_rows() > 0)
        {
            return $query->row_array();
        } else {
            return null;
        }
    }

    public function update_correo_enviado($correo_id)
    {
        $this->db->where('id_correo', $correo_id);

        $this->db->update('correo', array('correo_estatus' => 3));
    }

    public function consulta_id_destinatario($id_correo)
    {
        $this->db->select('contacto_id');
        $this->db->from('destinatario_correo');
        $this->db->where('correo_id', $id_correo);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

}