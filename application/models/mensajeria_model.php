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

        if ($parametros['tipo'] != "") {
            $this->db->where('contacto.contacto_tipo', $parametros['tipo']);
        }

        if ($parametros['nombre'] != "") {
            $this->db->like('contacto.contacto_nombre', $parametros['nombre']);
        }

        if ($parametros['paterno'] != "") {
            $this->db->like('contacto.contacto_ap_paterno', $parametros['paterno']);
        }

        if ($parametros['materno'] != "") {
            $this->db->like('contacto.contacto_ap_materno', $parametros['materno']);
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
            return $query->row();
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

    public function consulta_cursos()
    {
        $this->db->select('id_curso, curso_titulo');

        $this->db->from('curso');

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function consulta_correos()
    {
        $this->db->select('id_correo,
                            correo_asunto,
                            correo_fecha_envio,
                            correo_hora_envio,
                            correo_fecha_creacion,
                            correo_estatus');

        $this->db->from('correo');

        $this->db->order_by('correo_fecha_creacion desc, correo_hora_creacion desc');

        $this->db->limit(10);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function busqueda_correos($parametros)
    {
        $this->db->select('id_correo,
                            correo_asunto,
                            correo_fecha_envio,
                            correo_hora_envio,
                            correo_fecha_creacion,
                            correo_estatus');
        $this->db->from('correo');

        if ($parametros['correo_asunto'] != "") {
            $this->db->like('correo_asunto', $parametros['correo_asunto']);
        }

        if ($parametros['correo_fecha_envio'] != "") {
            switch ($parametros['correo_fecha_envio']) {
                case 1:
                    $this->db->where('correo_fecha_envio >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)');
                    break;

                case 2:
                    $this->db->where('correo_fecha_envio >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)');
                    break;

                case 3:
                    $this->db->where('correo_fecha_envio >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)');
                    break;

                case 4:
                    $this->db->where('correo_fecha_envio >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)');
                    break;
                
                default:
                    break;
            }
        }

        if ($parametros['correo_estatus'] != "") {
            $this->db->where('correo_estatus', $parametros['correo_estatus']);
        }

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function consulta_contactos_correos($ids_contacto_correo)
    {
        $this->db->select('contacto_nombre,
                            contacto_ap_paterno,
                            contacto_ap_materno,
                            contacto_correo_inst,
                            contacto_correo_per');
        $this->db->from('contacto');

        $this->db->where_in('id_contacto', $ids_contacto_correo);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function registrar_correo($correo)
    {

        $this->db->insert('correo', $correo);

        return  $this->db->insert_id();
    }

    public function consulta_invitados_curso_tipo($curso_id)
    {
        $this->db->select('contacto.id_contacto');

        $this->db->from('curso_invitado_tipo');
        $this->db->join('contacto', 'curso_invitado_tipo.tipo_contacto_id = contacto.contacto_tipo');

        $this->db->where('curso_invitado_tipo.curso_id', $curso_id);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function consulta_invitados_curso_contacto($curso_id)
    {
        $this->db->select('contacto.id_contacto');

        $this->db->from('curso_invitado_contacto');
        $this->db->join('contacto', 'curso_invitado_contacto.invitado_id = contacto.id_contacto');

        $this->db->where('curso_invitado_contacto.curso_id', $curso_id);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function registrar_destinatario_correo($correo_id, $contacto_id)
    {
        $this->db->insert('destinatario_correo', array('correo_id' => $correo_id,
                                                        'contacto_id' => $contacto_id));
    }

    public function consulta_destinatarios_correos($id_correo)
    {
        $this->db->select('contacto.id_contacto,
                            contacto.contacto_nombre,
                            contacto.contacto_ap_paterno,
                            contacto.contacto_ap_materno');
        $this->db->from('contacto');
        $this->db->join('destinatario_correo', 'contacto.id_contacto = destinatario_correo.contacto_id');

        $this->db->where('destinatario_correo.correo_id', $id_correo);

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
        $this->db->from('correo');
        $this->db->where('id_correo', $id_correo);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->row_array();
        } else {
            return null;
        }
    }

    public function cancelar_correo($id_correo)
    {
        $this->db->update('correo', array('correo_estatus' => 2), array('id_correo' => $id_correo));
    }

    public function borrar_destinatarios_correo($id_correo)
    {
        $this->db->delete('destinatario_correo', array('correo_id' => $id_correo));
    }

    public function actualizar_correo($correo)
    {
        $this->db->where('id_correo', $correo['id_correo']);
        unset($correo['id_correo']);

        $this->db->update('correo', $correo);
    }

    public function consulta_detalle_correo($id_correo)
    {
        $this->db->from('correo');
        $this->db->join('estatus_correo', 'correo.correo_estatus = estatus_correo.id_estatus_correo');
        $this->db->where('correo.id_correo', $id_correo);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->row_array();
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

    public function consulta_invitados_tipo($tipo_id)
    {
        $this->db->select('id_contacto');

        $this->db->from('contacto');

        $this->db->where('contacto_tipo', $tipo_id);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function consulta_detalles_curso($id_curso)
    {
        $this->db->select('curso_titulo,
                            curso_fecha_inicio,
                            curso_fecha_fin,
                            curso_hora_inicio,
                            curso_hora_fin,
                            curso_ubicacion');
        $this->db->from('curso');

        $this->db->where('id_curso', $id_curso);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->row();
        } else {
            return null;
        }
    }

    public function consulta_invitados_detalles_curso($ids_contacto_correo)
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

        $this->db->where_in('id_contacto', $ids_contacto_correo);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function plantilla_invitacion($id_curso)
    {
        $this->db->select('curso_titulo,
                            curso_fecha_inicio,
                            curso_fecha_fin,
                            curso_hora_inicio,
                            curso_hora_fin,
                            curso_ubicacion,
                            curso_objetivos');
        $this->db->from('curso');

        $this->db->where('id_curso', $id_curso);

        $query = $this->db->get();

        if ($query -> num_rows() > 0)
        {
            return $query->row();
        } else {
            return null;
        }
    }

    public function eliminar_invitados_curso($id_curso)
    {
        $this->db->delete('curso_invitado_contacto', array('curso_id' => $id_curso));
    }

    public function registrar_invitados_correo($curso_id, $contacto_id)
    {
        $this->db->insert('curso_invitado_contacto', array('curso_id' => $curso_id, 'invitado_id' => $contacto_id));
    }

    public function constancia_contacto($contacto_id)
    {
        $this->db->select('contacto_nombre,
                            contacto_ap_paterno,
                            contacto_ap_materno');

        $this->db->from('contacto');

        $this->db->where('id_contacto', $contacto_id);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function constancia_curso($curso_id)
    {
        $this->db->select('curso_titulo,
                            curso_fecha_inicio,
                            curso_fecha_fin,
                            curso_hora_inicio,
                            curso_hora_fin,
                            curso_ubicacion');

        $this->db->from('curso');

        $this->db->where('id_curso', $curso_id);

        $query = $this->db->get();

        return $query->row_array();
    }
}