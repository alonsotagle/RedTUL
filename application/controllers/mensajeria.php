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
            'nombre' => $this->input->post('nombre'),
            'correo' => $this->input->post('correo'),
            'instancia' => $this->input->post('instancia')
        );

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

        print_r(json_encode($resultado));
    }

    function mandar_correo()
    {
        $this->load->library('class_email');

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

        $id_destinatarios_string = $this->input->post('id_destinatarios');
        $id_destinatarios = explode(",", $id_destinatarios_string);

        $email_data = array(
            'id_destinatarios'  => $id_destinatarios,
            'asunto'            => $this->input->post('asunto'),
            'contenido'         => $mensaje,
            'html'              => $html,
            'archivo'           => $respuesta_archivo_adjunto
        );

        if ($this->input->post('envio') == 0) {
            $email_data['correo_fecha_envio'] = date("Y-m-d");
            $email_data['estatus'] = 3;
            $this->class_email->send_email($email_data);
        } else {
            $email_data['correo_fecha_envio'] = $this->input->post('fecha_envio');
            $email_data['estatus'] = 1;
        }

        $this->registrar_correo($email_data);

        $parametros_vista = array("tab" => 0,
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
                            "correo_fecha_creacion" => date("Y-m-d")
        );

        $this->mensajeria_model->registrar_correo($nuevo_correo);
    }

}