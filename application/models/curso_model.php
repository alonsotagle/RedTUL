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

        return $this->db->insert_id();
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
        $this->db->select('curso_flyer, curso_temario');
        $this->db->from('curso');
        $this->db->where('id_curso', $id_curso);

        $query = $this->db->get();

        $nombre_archivos = $query->row_array();

        $this->db->delete('curso', array('id_curso' => $id_curso));

        return $nombre_archivos;
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
        $this->db->join('curso_instructor', 'curso.id_curso = curso_instructor.curso_id');
        $this->db->join('contacto', 'curso_instructor.instructor_id = contacto.id_contacto');

        if ($parametros_busqueda['nombre_curso'] != "") {
            $this->db->like('curso.curso_titulo', $parametros_busqueda['nombre_curso']);
        }

        if ($parametros_busqueda['tipo_curso'] != "") {
            $this->db->where('curso.curso_tipo', $parametros_busqueda['tipo_curso']);
        }

        if ($parametros_busqueda['nombre_instructor'] != "") {
            $this->db->like('contacto.contacto_nombre', $parametros_busqueda['nombre_instructor']);
        }

        if ($parametros_busqueda['paterno_instructor'] != "") {
            $this->db->like('contacto.contacto_ap_paterno', $parametros_busqueda['paterno_instructor']);
        }

        if ($parametros_busqueda['materno_instructor'] != "") {
            $this->db->like('contacto.contacto_ap_materno', $parametros_busqueda['materno_instructor']);
        }

        if ($parametros_busqueda['estatus_curso'] != "") {
            $this->db->where('curso.curso_estatus', $parametros_busqueda['estatus_curso']);
        }

        if ($parametros_busqueda['inicio_curso'] != "") {
            $this->db->where('curso.curso_fecha_inicio >=', $parametros_busqueda['inicio_curso']);
            $this->db->where('curso.curso_fecha_fin <=', $parametros_busqueda['fin_curso']);
        }

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

        if ($parametros['nombre_contacto'] != "") {
            $this->db->like('contacto.contacto_nombre', $parametros['nombre_contacto']);
        }

        if ($parametros['paterno_contacto'] != "") {
            $this->db->like('contacto.contacto_ap_paterno', $parametros['paterno_contacto']);
        }

        if ($parametros['materno_contacto'] != "") {
            $this->db->like('contacto.contacto_ap_materno', $parametros['materno_contacto']);
        }

        if ($parametros['correo'] != "") {
            $correo = $parametros['correo'];
            $this->db->where("(contacto.contacto_correo_inst LIKE '%$correo%' || contacto.contacto_correo_per LIKE '%$correo%')");
        }

        if ($parametros['instancia'] != "") {
            $this->db->like('instancia.instancia_nombre', $parametros['instancia']);
        }

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function registrar_invitado_tipo($curso_id, $tipo_invitado)
    {
        
        $datos = array(
            'curso_id'          => $curso_id,
            'tipo_contacto_id'  => $tipo_invitado
        );

        $this->db->insert('curso_invitado_tipo', $datos);
    }

    public function registrar_invitado_contacto($curso_id, $invitado_id)
    {
        $datos = array(
            'curso_id'      => $curso_id,
            'invitado_id'   => $invitado_id
        );

        $this->db->delete('curso_invitado_contacto', $datos);
        
        $this->db->insert('curso_invitado_contacto', $datos);
    }

    public function consulta_invitado_tipo($id_curso)
    {
        $this->db->where('curso_id', $id_curso);
        $this->db->from('curso_invitado_tipo');

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function consulta_invitado_contacto($id_curso)
    {
        $this->db->select('contacto.id_contacto,
                            contacto.contacto_nombre,
                            contacto.contacto_ap_paterno,
                            contacto.contacto_ap_materno');
        $this->db->from('contacto');
        $this->db->join('curso_invitado_contacto', 'contacto.id_contacto = curso_invitado_contacto.invitado_id');

        $this->db->where('curso_id', $id_curso);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function registrar_instructor_curso($id_curso, $id_instructor)
    {
        $datos = array(
            'curso_id'      => $id_curso,
            'instructor_id' => $id_instructor
        );

        $this->db->delete('curso_instructor', $datos);
        
        $this->db->insert('curso_instructor', $datos);
    }

    public function consulta_instructores_curso($id_curso)
    {
        $this->db->select('instructor_id');
        $this->db->where('curso_id', $id_curso);

        $query = $this->db->get('curso_instructor');

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function borrar_invitado_tipo($id_curso)
    {
        $datos = array('curso_id' => $id_curso);
        $this->db->delete('curso_invitado_tipo', $datos);
    }

    public function borrar_instructor_curso($id_curso)
    {
        $datos = array('curso_id' => $id_curso);
        $this->db->delete('curso_instructor', $datos);
    }

    public function consulta_instructores_nombre_curso($id_curso)
    {
        $this->db->select('contacto.contacto_nombre,
                            contacto.contacto_ap_paterno,
                            contacto.contacto_ap_materno');
        $this->db->from('contacto');
        $this->db->join('curso_instructor', 'contacto.id_contacto = curso_instructor.instructor_id');

        $this->db->where('curso_instructor.curso_id', $id_curso);

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
        $this->db->from('curso_inscrito');
        $this->db->where('id_curso', $id_curso);

        $query = $this->db->count_all_results();

        return $query;
    }

    public function borrar_invitado_contacto($id_curso, $id_contacto)
    {
        $datos = array('curso_id'       => $id_curso,
                        'invitado_id'   => $id_contacto);

        $this->db->delete('curso_invitado_contacto', $datos);
    }

    public function consulta_detalle_curso($id_curso)
    {
        $this->db->from('curso');
        $this->db->join('estatus_curso', 'curso.curso_estatus = estatus_curso.id_estatus_curso');
        $this->db->where('curso.id_curso', $id_curso);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->row_array();
        } else {
            return null;
        }
    }

    public function consulta_invitado_tipo_detalle($id_curso)
    {
        $this->db->select('tipo_contacto.tipo_contacto_descripcion');
        $this->db->from('curso_invitado_tipo');
        $this->db->join('tipo_contacto', 'curso_invitado_tipo.tipo_contacto_id = tipo_contacto.id_tipo_contacto');
        $this->db->where('curso_id', $id_curso);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function consulta_inscritos_detalle($id_curso)
    {
        $this->db->select('contacto.contacto_nombre,
                            contacto.contacto_ap_paterno,
                            contacto.contacto_ap_materno');
        $this->db->from('curso_inscrito');
        $this->db->join('contacto', 'contacto.id_contacto = curso_inscrito.id_contacto');

        $this->db->where('curso_inscrito.id_curso', $id_curso);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function consulta_cancelados_detalle($id_curso)
    {
        $this->db->select('contacto.contacto_nombre,
                            contacto.contacto_ap_paterno,
                            contacto.contacto_ap_materno');
        $this->db->from('curso_cancelado');
        $this->db->join('contacto', 'contacto.id_contacto = curso_cancelado.id_contacto');

        $this->db->where('curso_cancelado.id_curso', $id_curso);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function consulta_invitado_curso($id_curso)
    {
        $this->db->select('invitado_id');
        $this->db->from('curso_invitado_contacto');
        $this->db->where('curso_id', $id_curso);

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

    public function registrar_configuracion_registro($configuracion_registro)
    {
        $this->db->select('registro_curso_id');
        $this->db->from('registro');
        $this->db->where('registro_curso_id', $configuracion_registro['registro_curso_id']);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            unset($configuracion_registro['registro_curso_id']);
            $this->db->update('registro', $configuracion_registro);
        } else {
            $this->db->insert('registro', $configuracion_registro);
        }
    }

    public function consulta_registro_curso($id_curso)
    {
        $this->db->where('registro_curso_id', $id_curso);
        $this->db->from('registro');

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->row_array();
        } else {
            return null;
        }
    }
}