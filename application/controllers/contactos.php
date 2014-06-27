<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class contactos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contacto_model');
    }

    public function index() {
    	$this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('contactos');
        $this->load->view('template/footer');
    }

    public function nuevo() {
        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('nuevo_contacto');
        $this->load->view('template/footer');
    }

    function registrar_contacto(){
        if (!empty($_POST)) {

            if ($_FILES['contacto_avatar']['size'] == 0) {
                $respuesta_avatar = "";
            }else{
                $respuesta_avatar = $this->subir_avatar();
            }

            if ($respuesta_avatar != "error_imagen") {
                $nuevo_contacto = array(
                    'contacto_estatus' => $this->input->post('estatus_contacto'),
                    'contacto_tipo' => $this->input->post('tipo_contacto'),
                    'contacto_instructor' => $this->input->post('instructor_candidato'),
                    'contacto_nombre' => $this->input->post('contacto_nombre'),
                    'contacto_ap_paterno' => $this->input->post('contacto_apaterno'),
                    'contacto_ap_materno' => $this->input->post('contacto_amaterno'),
                    'contacto_instancia' => $this->input->post('contacto_instancia'),
                    'contacto_adscripcion' => $this->input->post('contacto_adscripcion'),
                    'contacto_funciones' => $this->input->post('contacto_funciones'),
                    'contacto_telefono' => $this->input->post('contacto_telefono'),
                    'contacto_extension' => $this->input->post('contacto_extension'),
                    'contacto_correo_inst' => $this->input->post('contacto_correoinst'),
                    'contacto_correo_per' => $this->input->post('contacto_correopers'),
                    'contacto_avatar' => $respuesta_avatar,
                    'contacto_comunicacion' => $this->input->post('comunicacion_contacto'),
                );
                $this->contacto_model->registrar_contacto($nuevo_contacto);

                $nuevo_contacto['contacto_instancia_nombre'] = $this->input->post('contacto_instancia_nombre');

                $this->confirmacion_contacto($nuevo_contacto);
            }else{
                echo "Error en la imagen subida";
            }
        }
    }

    function confirmacion_contacto($contacto){

            if ($contacto['contacto_estatus'] == 0) {
                $contacto['contacto_estatus'] = "Inactivo";
            }else{
                $contacto['contacto_estatus'] = "Activo";
            }

            switch ($contacto['contacto_tipo']) {
                case 1:
                    $contacto['contacto_tipo'] = "Webmaster";
                    break;
                case 2:
                    $contacto['contacto_tipo'] = "Responsable de comunicación";
                    break;
                case 3:
                    $contacto['contacto_tipo'] = "Responsable de técnico";
                    break;
                case 4:
                    $contacto['contacto_tipo'] = "Otros";
                    break;
                
                default:
                    break;
            }

            if ($contacto['contacto_comunicacion'] == 0) {
                $contacto['contacto_comunicacion'] = "Vía telefónica";
            }else{
                $contacto['contacto_comunicacion'] = "Vía e-mail";
            }

            if (($contacto['contacto_avatar']) != "") {
                $tag_img = "<img src=".base_url('assets/img_avatar/')."/".$contacto['contacto_avatar']." width='200px' height='200px'>";
                $contacto['contacto_avatar'] = $tag_img;
            }else{
                $contacto['contacto_avatar'] = "";
            }

            $this->load->view('template/header');
            $this->load->view('template/menu');
            $this->load->view('confirmacion_contacto', $contacto);
            $this->load->view('template/footer');
    }

    function consulta_contactos()
    {
        $contactos = $this->contacto_model->consulta_contactos();

        foreach($contactos as $llave => &$contacto)
        {
            if ($contacto['contacto_estatus'] == '1')
            {
                $contacto['contacto_estatus'] = 'Activo';
            }else{
                $contacto['contacto_estatus'] = 'Inactivo';
            }
        }

        print_r(json_encode($contactos));
    }

    function consulta_instancias()
    {
        $instancias = $this->contacto_model->consulta_instancias();

        print_r(json_encode($instancias));
    }

    function eliminar($id_contacto)
    {
        $this->contacto_model->eliminar($id_contacto);

        redirect('contactos');
    }

    function editar($id_contacto)
    {
        if (empty($_POST)) {

            $var_id = array('id_contacto' => $id_contacto);

            $this->load->view('template/header');
            $this->load->view('template/menu');
            $this->load->view('editar_contacto', $var_id);
            $this->load->view('template/footer');
        }else{

            if ($_FILES['contacto_avatar']['size'] == 0) {
                $respuesta_avatar = $this->input->post('contacto_avatar_old');;
            }else{
                $respuesta_avatar = $this->subir_avatar();
            }

            if ($respuesta_avatar != "error_imagen") {
                $editar_contacto = array(
                    'contacto_estatus' => $this->input->post('estatus_contacto'),
                    'contacto_tipo' => $this->input->post('tipo_contacto'),
                    'contacto_instructor' => $this->input->post('instructor_candidato'),
                    'contacto_nombre' => $this->input->post('contacto_nombre'),
                    'contacto_ap_paterno' => $this->input->post('contacto_apaterno'),
                    'contacto_ap_materno' => $this->input->post('contacto_amaterno'),
                    'contacto_instancia' => $this->input->post('contacto_instancia'),
                    'contacto_adscripcion' => $this->input->post('contacto_adscripcion'),
                    'contacto_funciones' => $this->input->post('contacto_funciones'),
                    'contacto_telefono' => $this->input->post('contacto_telefono'),
                    'contacto_extension' => $this->input->post('contacto_extension'),
                    'contacto_correo_inst' => $this->input->post('contacto_correoinst'),
                    'contacto_correo_per' => $this->input->post('contacto_correopers'),
                    'contacto_avatar' => $respuesta_avatar,
                    'contacto_comunicacion' => $this->input->post('comunicacion_contacto'),
                );
                $editar_contacto['id_contacto'] = $id_contacto;

                $this->contacto_model->editar_contacto($editar_contacto);

                $editar_contacto['contacto_instancia_nombre'] = $this->input->post('contacto_instancia_nombre');

                $this->confirmacion_contacto($editar_contacto);
            }else{
                echo "Error en la imagen subida";
            }
        }
    }

    function consulta_contacto($id_contacto)
    {
        $contacto = $this->contacto_model->consulta_contacto($id_contacto);

        print_r(json_encode($contacto));
    }

    function subir_avatar()
    {

        $config['upload_path'] = './assets/img_avatar/';
        $config['allowed_types'] = 'gif|jpg|jpeg';
        $config['max_size'] = '2048';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload("contacto_avatar"))
        {
            echo $this->upload->display_errors();
            return "error_imagen";
        }else{
            $datos = $this->upload->data();
            return $datos["file_name"];
        }
    }

    function buscar()
    {
        if (!empty($_POST)) {

            $parametros_busqueda = array(
                'correo_contacto'   => $this->input->post('correo_contacto'),
                'tipo_contacto'     => $this->input->post('tipo_contacto'),
                'instancia_contacto'=> $this->input->post('instancia_contacto')
            );

            $nombre_completo = $this->input->post('nombre_contacto');

            if ($nombre_completo != "") {
                $arreglo_nombre = explode(" ", $nombre_completo);
                $tamano_arreglo = count($arreglo_nombre);

                switch ($tamano_arreglo) {
                    case 1:
                        $parametros_busqueda['nombre_contacto'] = $arreglo_nombre[0];
                        $parametros_busqueda['paterno_contacto'] = "";
                        $parametros_busqueda['materno_contacto'] = "";
                        break;

                    case 2:
                        $parametros_busqueda['nombre_contacto'] = $arreglo_nombre[0];
                        $parametros_busqueda['paterno_contacto'] = $arreglo_nombre[1];
                        $parametros_busqueda['materno_contacto'] = "";
                        break;

                    case 3:
                        $parametros_busqueda['nombre_contacto'] = $arreglo_nombre[0];
                        $parametros_busqueda['paterno_contacto'] = $arreglo_nombre[1];
                        $parametros_busqueda['materno_contacto'] = $arreglo_nombre[2];
                        break;

                    case 4:
                        $parametros_busqueda['nombre_contacto'] = $arreglo_nombre[0]." ".$arreglo_nombre[1];
                        $parametros_busqueda['paterno_contacto'] = $arreglo_nombre[2];
                        $parametros_busqueda['materno_contacto'] = $arreglo_nombre[3];
                        break;
                    
                    default:
                        $parametros_busqueda['nombre_contacto'] = "";
                        $parametros_busqueda['paterno_contacto'] = "";
                        $parametros_busqueda['materno_contacto'] = "";
                        break;
                }
            } else {
                $parametros_busqueda['nombre_contacto'] = "";
                $parametros_busqueda['paterno_contacto'] = "";
                $parametros_busqueda['materno_contacto'] = "";
            }

            $resultado_busqueda['resultado'] = $this->contacto_model->buscar($parametros_busqueda);

            if (!is_null($resultado_busqueda['resultado'])) {
                foreach($resultado_busqueda['resultado'] as $llave => &$contacto)
                {
                    if ($contacto['contacto_estatus'] == '1')
                    {
                        $contacto['contacto_estatus'] = 'Activo';
                    }else{
                        $contacto['contacto_estatus'] = 'Inactivo';
                    }
                }
            }

            $this->load->view('template/header');
            $this->load->view('template/menu');
            $this->load->view('buscar_contacto',$resultado_busqueda);
            $this->load->view('template/footer');

        }
    }

    function detalle_contacto($id_contacto)
    {
        $contacto = $this->contacto_model->consulta_detalle_contacto($id_contacto);

        if ($contacto['contacto_estatus'] == 0) {
            $contacto['contacto_estatus'] = "Inactivo";
        }else{
            $contacto['contacto_estatus'] = "Activo";
        }

        switch ($contacto['contacto_tipo']) {
            case 1:
                $contacto['contacto_tipo'] = "Webmaster";
                break;
            case 2:
                $contacto['contacto_tipo'] = "Responsable de comunicación";
                break;
            case 3:
                $contacto['contacto_tipo'] = "Responsable de técnico";
                break;
            case 4:
                $contacto['contacto_tipo'] = "Otros";
                break;
            
            default:
                break;
        }

        if ($contacto['contacto_comunicacion'] == 0) {
            $contacto['contacto_comunicacion'] = "Vía telefónica";
        }else{
            $contacto['contacto_comunicacion'] = "Vía e-mail";
        }

        if (($contacto['contacto_avatar']) != "") {
            $tag_img = "<img src=".base_url('assets/img_avatar/')."/".$contacto['contacto_avatar']." width='200px' height='200px'>";
            $contacto['contacto_avatar'] = $tag_img;
        }

        if ($contacto['contacto_instructor'] == 0) {
            $contacto['contacto_instructor'] = "No";
        }else{
            $contacto['contacto_instructor'] = "Sí";
        }

        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('detalle_contacto', $contacto);
        $this->load->view('template/footer');
    }

}