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

    public function confirmar_inscripcion($nueva_inscripcion)
    {
        $this->db->insert('curso_inscrito', $nueva_inscripcion);
        $this->db->delete('curso_cancelado', $nueva_inscripcion);
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

        $this->db->where('id_contacto', $id_contacto);
        $this->db->where('id_curso', $id_curso);

        $this->db->from('curso_inscrito');

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return "Confirmado";
        } else {
            $this->db->flush_cache();

            $this->db->where('id_contacto', $id_contacto);
            $this->db->where('id_curso', $id_curso);

            $this->db->from('curso_cancelado');

            $query = $this->db->get();

            if ($query -> num_rows() > 0)
            {
                return "Cancelado";
            } else {
                return "Invitado";
            }
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
        $this->db->insert('curso_cancelado', $cancelar_inscripcion);
        unset($cancelar_inscripcion['motivos']);
        $this->db->delete('curso_inscrito', $cancelar_inscripcion);
    }

    public function invitado_curso($id_contacto, $id_curso)
    {

        $this->db->where('invitado_id', $id_contacto);
        $this->db->where('curso_id', $id_curso);

        $this->db->from('curso_invitado_contacto');

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