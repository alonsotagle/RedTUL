<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class mensajeria_model extends CI_Model{
    
    
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function consulta_contactos($parametros)
    {
        $this->db->select('contacto.id_contacto,
                            contacto.contacto_nombre,
                            contacto.contacto_ap_paterno,
                            contacto.contacto_ap_materno,
                            contacto.contacto_correo_inst,
                            contacto.contacto_correo_per,
                            contacto.contacto_telefono,
                            tipo_contacto.tipo_contacto_descripcion,
                            instancia.instancia_nombre');
        $this->db->from('contacto');
        $this->db->join('tipo_contacto', 'contacto.contacto_tipo = tipo_contacto.id_tipo_contacto');
        $this->db->join('instancia', 'contacto.contacto_instancia = instancia.id_instancia');

        $parametros_busqueda = array();

        if (isset($parametros['tipo'])) {
            $this->db->where('contacto.contacto_tipo', $parametros['tipo']);
        }

        if ($parametros['nombre'] != "") {
            $this->db->like('contacto.contacto_nombre', $parametros['nombre']);
            $this->db->or_like('contacto.contacto_ap_paterno', $parametros['nombre']);
            $this->db->or_like('contacto.contacto_ap_materno', $parametros['nombre']);
        }

        if ($parametros['correo'] != "") {
            $this->db->like('contacto.contacto_correo_inst', $parametros['correo']);
            $this->db->or_like('contacto.contacto_correo_per', $parametros['correo']);
        }

        if ($parametros['instancia'] != "") {
            $this->db->like('instacia.instancia_nombre', $parametros['instancia']);
        }

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function registrar_plantilla($plantilla_correo)
    {
        $this->db->insert('plantilla_correo', $plantilla_correo);
    }

    public function consulta_plantillas()
    {
        $this->db->from('plantilla_correo');

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function plantilla_eliminar($id_plantilla)
    {
        $this->db->delete('plantilla_correo', array('id_plantilla_correo' => $id_plantilla));
    }

    public function consulta_plantilla($id_plantilla)
    {
        $this->db->from('plantilla_correo');
        $this->db->where('id_plantilla_correo', $id_plantilla);


        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function editar_plantilla($plantilla)
    {
        $this->db->where('id_plantilla_correo', $plantilla['id_plantilla_correo']);
        unset($plantilla['id_plantilla_correo']);

        $this->db->update('plantilla_correo', $plantilla);
    }
}