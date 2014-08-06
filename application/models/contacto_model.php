<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class contacto_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function registrar_contacto($nuevo_contacto)
    {
		$this->db->insert('contacto', $nuevo_contacto);
    }

    public function consulta_contactos()
    {
    	$this->db->select('contacto.id_contacto,
    						contacto.contacto_nombre,
    						contacto.contacto_ap_paterno,
    						contacto.contacto_ap_materno,
    						tipo_contacto.tipo_contacto_descripcion,
    						contacto.contacto_estatus,
    						instancia.instancia_nombre,
    						contacto.contacto_correo_inst,
    						contacto.contacto_correo_per');
        
		$this->db->from('contacto');
		$this->db->join('tipo_contacto', 'contacto.contacto_tipo = tipo_contacto.id_tipo_contacto');
		$this->db->join('instancia', 'contacto.contacto_instancia = instancia.id_instancia');
        $this->db->order_by("contacto.id_contacto", "asc"); 

		$query = $this->db->get();

		if ($query -> num_rows() > 0)
		{
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function consulta_instancias()
    {
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

    public function eliminar($id_contacto)
    {
        $this->db->delete('contacto', array('id_contacto' => $id_contacto));
    }

    public function consulta_contacto($id_contacto)
    {
        $this->db->where('contacto.id_contacto', $id_contacto);
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

    public function editar_contacto($contacto)
    {
        $this->db->where('id_contacto', $contacto['id_contacto']);
        unset($contacto['id_contacto']);

        $this->db->update('contacto', $contacto);
    }

    public function buscar($parametros_busqueda)
    {
        $this->db->select('contacto.id_contacto,
                            contacto.contacto_nombre,
                            contacto.contacto_ap_paterno,
                            contacto.contacto_ap_materno,
                            tipo_contacto.tipo_contacto_descripcion,
                            contacto.contacto_estatus,
                            instancia.instancia_nombre,
                            contacto.contacto_correo_inst,
                            contacto.contacto_correo_per');
        $this->db->from('contacto');
        $this->db->join('tipo_contacto', 'contacto.contacto_tipo = tipo_contacto.id_tipo_contacto');
        $this->db->join('instancia', 'contacto.contacto_instancia = instancia.id_instancia');

        if ($parametros_busqueda['nombre_contacto'] != "") {
            $this->db->like('contacto.contacto_nombre', $parametros_busqueda['nombre_contacto']);
        }

        if ($parametros_busqueda['paterno_contacto'] != "") {
            $this->db->like('contacto.contacto_ap_paterno', $parametros_busqueda['paterno_contacto']);
        }

        if ($parametros_busqueda['materno_contacto'] != "") {
            $this->db->like('contacto.contacto_ap_materno', $parametros_busqueda['materno_contacto']);
        }

        if ($parametros_busqueda['correo_contacto'] != "") {
            $correo = $parametros_busqueda['correo_contacto'];
            $this->db->where("(contacto.contacto_correo_inst LIKE '%$correo%' || contacto.contacto_correo_per LIKE '%$correo%')");
        }

        if ($parametros_busqueda['tipo_contacto'] != "") {
            $this->db->where('contacto.contacto_tipo', $parametros_busqueda['tipo_contacto']);
        }

        if ($parametros_busqueda['instancia_contacto'] != "") {
            $this->db->like('instancia.instancia_nombre', $parametros_busqueda['instancia_contacto']);
        }

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function consulta_detalle_contacto($id_contacto)
    {
        $this->db->from('contacto');
        $this->db->join('instancia', 'contacto.contacto_instancia = instancia.id_instancia');
        $this->db->join('tipo_contacto', 'contacto.contacto_tipo = tipo_contacto.id_tipo_contacto');
        $this->db->where('contacto.id_contacto', $id_contacto);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->row_array();
        } else {
            return null;
        }
    }

}