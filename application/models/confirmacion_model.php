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
                            instancia.instancia_nombre,
                            instancia.id_instancia');

        $this->db->where('contacto.contacto_correo_inst', $contacto_correo);
        $this->db->or_where('contacto.contacto_correo_per', $contacto_correo); 
        $this->db->from('contacto');
        $this->db->join('instancia', 'contacto.contacto_instancia = instancia.id_instancia');

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->row_array();
        } else {
            return null;
        }
    }

    public function confirmar_inscripcion($confirmar_inscripcion)
    {
        $this->db->delete('contacto_estado_curso', $confirmar_inscripcion);

        $confirmar_inscripcion["estado_id"] = 2;

        $this->db->insert('contacto_estado_curso', $confirmar_inscripcion);
    }

    public function consulta_instancias()
    {
        $query = $this->db->get('instancia');

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function estatus_contacto($id_contacto, $id_curso)
    {
        $this->db->select('estado_contacto_curso.estado_descripcion');

        $this->db->from('contacto_estado_curso');

        $this->db->where('contacto_estado_curso.contacto_id', $id_contacto);
        $this->db->where('contacto_estado_curso.curso_id', $id_curso);
        
        $this->db->join('estado_contacto_curso', 'contacto_estado_curso.estado_id = estado_contacto_curso.id_estado_contacto_curso');

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->row_array();
        } else {
            return null;
        }
    }

    public function actualizar_contacto($contacto)
    {
        $this->db->where('id_contacto', $contacto['id_contacto']);
        unset($contacto['id_contacto']);

        $this->db->update('contacto', $contacto);
    }

    public function cancelar_inscripcion($cancelar_inscripcion)
    {
        $motivos = $cancelar_inscripcion['motivos'];
        unset($cancelar_inscripcion['motivos']);

        $this->db->delete('contacto_estado_curso', $cancelar_inscripcion);

        $cancelar_inscripcion['estado_id'] = 4;
        $this->db->insert('contacto_estado_curso', $cancelar_inscripcion);

        $contacto_cancela = array('contacto_estado_curso_id' => $this->db->insert_id(),
                            'contacto_motivos', $motivos);

        $this->db->insert('contacto_cancela', $contacto_cancela);
    }

    public function invitado_curso($id_contacto, $id_curso)
    {
        $this->db->from('contacto_estado_curso');

        $this->db->where('contacto_id', $id_contacto);
        $this->db->where('curso_id', $id_curso);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return TRUE;
        } else {
            $this->db->flush_cache();

            $this->db->select('contacto_tipo');
            $this->db->from('contacto');
            $this->db->where('id_contacto', $id_contacto);

            $query = $this->db->get();

            $resultado = $query->row_array();

            $tipo_contacto = $resultado['contacto_tipo'];

            $this->db->flush_cache();

            $this->db->where('tipo_contacto_id', $tipo_contacto);
            $this->db->where('curso_id', $id_curso);

            $this->db->from('curso_invitado_tipo');

            $query = $this->db->get();

            if ($query -> num_rows() > 0)
            {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

}