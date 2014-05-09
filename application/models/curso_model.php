<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class curso_model extends CI_Model{
    
    
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function registrar_curso($nuevo_curso)
    {
		$this->db->insert('curso', $nuevo_curso);
    }

    public function consulta_cursos()
    {
    	$this->db->select('curso.id_curso,
    						curso.curso_titulo,
    						curso.curso_tipo,
    						estatus_curso.estatus_curso_descripcion,
    						curso.curso_fecha_inicio,
    						curso.curso_fecha_fin,
    						curso.curso_hora_inicio,
    						curso.curso_hora_fin,
    						curso.curso_cupo');

		$this->db->from('curso');
		$this->db->join('estatus_curso', 'curso.curso_estatus = estatus_curso.id_estatus_curso');

		$query = $this->db->get();

		if ($query -> num_rows() > 0)
		{
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function eliminar($id_curso)
    {
        $this->db->delete('curso', array('id_curso' => $id_curso));
    }

    public function buscar($parametros_busqueda)
    {
        $this->db->select('curso.id_curso,
    						curso.curso_titulo,
    						curso.curso_tipo,
    						estatus_curso.estatus_curso_descripcion,
    						curso.curso_fecha_inicio,
    						curso.curso_fecha_fin,
    						curso.curso_hora_inicio,
    						curso.curso_hora_fin,
    						curso.curso_cupo');
		$this->db->from('curso');
		$this->db->join('estatus_curso', 'curso.curso_estatus = estatus_curso.id_estatus_curso');

        $parametros = array();

        if ($parametros_busqueda['nombre_curso'] != "") {
            $parametros['curso.curso_titulo'] = $parametros_busqueda['nombre_curso'];
        }

        if (isset($parametros_busqueda['tipo_curso'])) {
            $this->db->where('curso.curso_tipo', $parametros_busqueda['tipo_curso']);
        }

        if (isset($parametros_busqueda['estatus_curso'])) {
            $this->db->where('curso.curso_estatus', $parametros_busqueda['estatus_curso']);
        }

        if ($parametros_busqueda['inicio_curso'] != "") {
            $parametros['curso.curso_fecha_inicio'] = $parametros_busqueda['inicio_curso'];
        }

        if ($parametros_busqueda['fin_curso'] != "") {
            $parametros['curso.curso_fecha_fin'] = $parametros_busqueda['fin_curso'];
        }

        $this->db->like($parametros);
        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function consulta_curso($id_curso)
    {
        $this->db->where('curso.id_curso', $id_curso);
        $this->db->from('curso');
		$this->db->join('estatus_curso', 'curso.curso_estatus = estatus_curso.id_estatus_curso');

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function editar_curso($curso)
    {
        $this->db->where('id_curso', $curso['id_curso']);
        unset($curso['id_curso']);

        $this->db->update('curso', $curso);
    }

    public function consulta_instructores()
    {
    	$this->db->select('id_contacto,
    						contacto_nombre,
    						contacto_ap_paterno,
    						contacto_ap_materno');
    	$this->db->where('contacto_instructor', 1);

		$query = $this->db->get('contacto');

		if ($query -> num_rows() > 0)
		{
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function recuperar_id()
    {
        $this->db->select_max("id_curso");
        $query=$this->db->get("curso");
        return $query->row_array();
    }


}