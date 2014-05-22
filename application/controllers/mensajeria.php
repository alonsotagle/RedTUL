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

        $parametros = array("tab" => 2,
                            "mensaje_plantilla" => "Plantilla editada satisfactoriamente.");

        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('mensajeria', $parametros);
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

    function correo()
    {
        $this->load->library('email');

    $this->email->from('tu_direccion@tu_sitio.com', 'Tu nombre');
    $this->email->to('alonsoauriazul@gmail.com');

    $this->email->subject('Correo de Prueba');
    $this->email->message('Probando la clase email');   

    $this->email->send();

    echo $this->email->print_debugger();
    }

}