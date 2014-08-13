<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class mensajeria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mensajeria_model');
        date_default_timezone_set('America/Mexico_City');
    }

    public function index() {

        $parametros = array("tab" => 0);

    	$this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('mensajeria', $parametros);
        $this->load->view('template/footer');
    }

    function consulta_contactos()
    {
        $parametros = array(
            'tipo' => $this->input->post('tipo'),
            'correo' => $this->input->post('correo'),
            'instancia' => $this->input->post('instancia')
        );

        $nombre_completo = $this->input->post('nombre');
        if ($nombre_completo != "") {
            $arreglo_nombre = explode(" ", $nombre_completo);
            $tamano_arreglo = count($arreglo_nombre);

            switch ($tamano_arreglo) {
                case 1:
                    $parametros['nombre'] = $arreglo_nombre[0];
                    $parametros['paterno'] = "";
                    $parametros['materno'] = "";
                    break;

                case 2:
                    $parametros['nombre'] = $arreglo_nombre[0];
                    $parametros['paterno'] = $arreglo_nombre[1];
                    $parametros['materno'] = "";
                    break;

                case 3:
                    $parametros['nombre'] = $arreglo_nombre[0];
                    $parametros['paterno'] = $arreglo_nombre[1];
                    $parametros['materno'] = $arreglo_nombre[2];
                    break;

                case 4:
                    $parametros['nombre'] = $arreglo_nombre[0]." ".$arreglo_nombre[1];
                    $parametros['paterno'] = $arreglo_nombre[2];
                    $parametros['materno'] = $arreglo_nombre[3];
                    break;
                
                default:
                    $parametros['nombre'] = "";
                    $parametros['paterno'] = "";
                    $parametros['materno'] = "";
                    break;
            }
        } else {
            $parametros['nombre'] = "";
            $parametros['paterno'] = "";
            $parametros['materno'] = "";
        }

        $resultado = $this->mensajeria_model->consulta_contactos($parametros);

        print_r(json_encode($resultado));
    }

    function registrar_plantilla()
    {
        $parametros = array(
            'plantilla_asunto' => $this->input->post('plantilla_asunto')
        );

        if ($this->input->post('plantilla_contenido_plano') != "") {
            $parametros['plantilla_contenido'] = $this->input->post('plantilla_contenido_plano');
            $parametros['plantilla_tipo_contenido'] = 0;
        }else{
            $parametros['plantilla_contenido'] = $this->input->post('plantilla_contenido_html');
            $parametros['plantilla_tipo_contenido'] = 1;
        }

        $this->mensajeria_model->registrar_plantilla($parametros);

        $parametros = array("tab" => 2,
                            "mensaje_plantilla" => "Plantilla agregada satisfactoriamente.");

        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('mensajeria', $parametros);
        $this->load->view('template/footer');
    }

    function consulta_plantillas()
    {
        $resultado = $this->mensajeria_model->consulta_plantillas();

        print_r(json_encode($resultado));
    }

    function plantilla_eliminar($id_plantilla)
    {
        $this->mensajeria_model->plantilla_eliminar($id_plantilla);

        $parametros = array("tab" => 2);

        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('mensajeria', $parametros);
        $this->load->view('template/footer');
    }

    function consulta_plantilla($id_plantilla)
    {
        $resultado = $this->mensajeria_model->consulta_plantilla($id_plantilla);

        print_r(json_encode($resultado));
    }

    function editar_plantilla()
    {

        $parametros = array(
            'plantilla_asunto' => $this->input->post('plantilla_asunto'),
            'id_plantilla_correo' => $this->input->post('plantilla_id')
        );

        if ($this->input->post('plantilla_contenido_plano') != "") {
            $parametros['plantilla_contenido'] = $this->input->post('plantilla_contenido_plano');
            $parametros['plantilla_tipo_contenido'] = 0;
        }else{
            $parametros['plantilla_contenido'] = $this->input->post('plantilla_contenido_html');
            $parametros['plantilla_tipo_contenido'] = 1;
        }

        $this->mensajeria_model->editar_plantilla($parametros);

        $parametros_vista = array("tab" => 2,
                            "mensaje_plantilla" => "Plantilla editada satisfactoriamente.");

        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('mensajeria', $parametros_vista);
        $this->load->view('template/footer');
    }

    function consulta_cursos()
    {
        $resultado = $this->mensajeria_model->consulta_cursos();

        print_r(json_encode($resultado));
    }

    function consulta_correos()
    {
        $resultado = $this->mensajeria_model->consulta_correos();

        if (!is_null($resultado)) {
            foreach ($resultado as $key => $value) {
                $resultado[$key]['destinatarios'] = $this->consulta_destinatarios_correos($value['id_correo']);
            }
        }

        print_r(json_encode($resultado));
    }

    function busqueda_correos()
    {
        $parametros = array(
            'correo_asunto'         => $this->input->post('correo_asunto'),
            'correo_fecha_envio'    => $this->input->post('correo_fecha_envio'),
            'correo_estatus'        => $this->input->post('correo_estatus')
        );

        $resultado = $this->mensajeria_model->busqueda_correos($parametros);

        if (!is_null($resultado)) {
            foreach ($resultado as $key => $value) {
                $resultado[$key]['destinatarios'] = $this->consulta_destinatarios_correos($value['id_correo']);
            }
        }

        print_r(json_encode($resultado));
    }

    function mandar_correo()
    {
        $this->load->library('class_email');

        $destinatarios = $this->input->post('id_destinatarios');
        $id_destinatarios = explode(",", $destinatarios);

        if ($_FILES['userfile']['size'] == 0) {
            $respuesta_archivo_adjunto = "";
        } else {
            $respuesta_archivo_adjunto = $this->adjuntar_archivo();
        }

        if ($this->input->post('contenido_plano') != "") {
            $mensaje = $this->input->post('contenido_plano');
            $html = false;
        } else {
            $mensaje = $this->input->post('contenido_html');
            $html = true;
        }

        $email_data = array(
            'id_destinatarios'  => $id_destinatarios,
            'asunto'            => $this->input->post('asunto'),
            'contenido'         => $mensaje,
            'html'              => $html,
            'archivo_adjunto'   => $respuesta_archivo_adjunto
        );

        if ($this->input->post('envio') == 0) {
            $email_data['correo_fecha_envio'] = date("Y-m-d");
            $email_data['correo_hora_envio'] = date("H:i");
            $email_data['estatus'] = 3;
            $this->class_email->send_email($email_data);
        } else {
            $email_data['correo_fecha_envio'] = $this->input->post('fecha_envio');
            $email_data['correo_hora_envio'] = $this->input->post('hora_envio');
            $email_data['estatus'] = 1;
        }

        $id_nuevo_correo = $this->registrar_correo($email_data);


        foreach ($id_destinatarios as $key => $value) {
            $this->mensajeria_model->registrar_destinatario_correo($id_nuevo_correo, $value);
        }

        $parametros_vista = array("tab" => 1,
                            "mensaje_plantilla" => "Correo enviado satisfactoriamente.");

        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('mensajeria', $parametros_vista);
        $this->load->view('template/footer');
    }

    function adjuntar_archivo()
    {

        $config['upload_path'] = './assets/email_archivos_adjuntos/';
        $config['max_size'] = '10240';
        $config['encrypt_name'] = TRUE;
        $config['allowed_types'] = '*';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload())
        {
            echo $this->upload->display_errors();
            return "error_subida";
        }else{
            $datos = $this->upload->data();
            return $datos["full_path"];
        }
    }

    function consulta_contactos_correos()
    {
        $resultado = $this->mensajeria_model->consulta_contactos_correos($this->input->post('ids_contacto_correo'));

        print_r(json_encode($resultado));
    }

    function registrar_correo($correo)
    {
        $nuevo_correo = array("correo_asunto"       => $correo['asunto'],
                            "correo_contenido"      => $correo['contenido'],
                            "correo_fecha_envio"    => $correo['correo_fecha_envio'],
                            "correo_estatus"        => $correo['estatus'],
                            "correo_fecha_creacion" => date("Y-m-d"),
                            "correo_hora_envio"     => $correo['correo_hora_envio'],
                            "correo_archivo_adjunto"=> $correo['archivo_adjunto']);

        $id_nuevo_correo = $this->mensajeria_model->registrar_correo($nuevo_correo);

        return $id_nuevo_correo;
    }

    function consulta_invitados_curso()
    {
        $id_invitados_curso = array();

        $resultado_tipo = $this->mensajeria_model->consulta_invitados_curso_tipo($this->input->post('curso_id'));

        foreach ($resultado_tipo as $key => $value) {
            array_push($id_invitados_curso, $value['id_contacto']);
        }

        $resultado_contacto =$this->mensajeria_model->consulta_invitados_curso_contacto($this->input->post('curso_id'));
        foreach ($resultado_contacto as $key => $value) {
            array_push($id_invitados_curso, $value['id_contacto']);
        }

        $id_invitados_curso = array_unique($id_invitados_curso);

        print_r(json_encode($id_invitados_curso));
    }

    function consulta_destinatarios_correos($id_correo)
    {
        $resultado = $this->mensajeria_model->consulta_destinatarios_correos($id_correo);

        return $resultado;
    }

    function editar_correo($id_correo)
    {
        $correo = $this->mensajeria_model->consulta_correo($id_correo);

        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('editar_correo', $correo);
        $this->load->view('template/footer');
    }

    function cancelar_correo($id_correo)
    {
        $this->mensajeria_model->cancelar_correo($id_correo);

        $this->index();
    }

    function guardar_correo()
    {

        $this->load->library('class_email');

        $destinatarios = $this->input->post('id_destinatarios');
        $id_destinatarios = explode(",", $destinatarios);

        $id_correo = $this->input->post('id_correo');

        if ($_FILES['userfile']['size'] == 0) {
            $respuesta_archivo_adjunto = "";
        } else {
            $respuesta_archivo_adjunto = $this->adjuntar_archivo();
        }

        if ($this->input->post('contenido_plano') != "") {
            $mensaje = $this->input->post('contenido_plano');
            $html = false;
        } else {
            $mensaje = $this->input->post('contenido_html');
            $html = true;
        }

        $email_data = array(
            'id_destinatarios'  => $id_destinatarios,
            'asunto'            => $this->input->post('asunto'),
            'contenido'         => $mensaje,
            'html'              => $html,
            'archivo_adjunto'   => $respuesta_archivo_adjunto,
            'id_correo'         => $id_correo
        );

        if ($this->input->post('envio') == 0) {
            $email_data['correo_fecha_envio'] = date("Y-m-d");
            $email_data['correo_hora_envio'] = date("H:i");
            $email_data['estatus'] = 3;
            $this->class_email->send_email($email_data);
        } else {
            $email_data['correo_fecha_envio'] = $this->input->post('fecha_envio');
            $email_data['correo_hora_envio'] = $this->input->post('hora_envio');
            $email_data['estatus'] = 1;
        }

        $this->actualizar_correo($email_data);
        $this->mensajeria_model->borrar_destinatarios_correo($id_correo);

        foreach ($id_destinatarios as $key => $value) {
            $this->mensajeria_model->registrar_destinatario_correo($id_correo, $value);
        }

        $parametros_vista = array("tab" => 1,
                            "mensaje_plantilla" => "Correo actualizado satisfactoriamente.");

        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('mensajeria', $parametros_vista);
        $this->load->view('template/footer');
    }

    function actualizar_correo($correo)
    {
        $correo = array("id_correo"             => $correo['id_correo'],
                        "correo_asunto"         => $correo['asunto'],
                        "correo_contenido"      => $correo['contenido'],
                        "correo_fecha_envio"    => $correo['correo_fecha_envio'],
                        "correo_estatus"        => $correo['estatus'],
                        "correo_hora_envio"     => $correo['correo_hora_envio'],
                        "correo_archivo_adjunto"=> $correo['archivo_adjunto']);

        $this->mensajeria_model->actualizar_correo($correo);
    }

    function consulta_destinatarios_correos_editar($id_correo)
    {
        $resultado = $this->mensajeria_model->consulta_destinatarios_correos($id_correo);

        print_r(json_encode($resultado));
    }

    function detalle_correo($id_correo)
    {
        $correo = $this->mensajeria_model->consulta_detalle_correo($id_correo);

        if ($correo['correo_archivo_adjunto'] != "") {
            $arreglo_url = explode("/", $correo['correo_archivo_adjunto']);
            $nombre_archivo = $arreglo_url[count($arreglo_url)-1];
            $correo['correo_archivo_adjunto'] = base_url('assets/email_archivos_adjuntos')."/".$nombre_archivo;
        }

        $correo['destinatarios'] = $this->consulta_destinatarios_correos($correo['id_correo']);

        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('detalle_correo', $correo);
        $this->load->view('template/footer');
    }
}