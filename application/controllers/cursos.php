<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class cursos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('curso_model');
    }

    public function index() {
    	$this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('cursos');
        $this->load->view('template/footer');
    }

    public function nuevo() {
        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('nuevo_curso');
        $this->load->view('template/footer');
    }

    function registrar_curso() {
        if (!empty($_POST)) {

            $respuesta_temario = $this->subir_temario();

            if ($_FILES['curso_flyer']['size'] == 0) {
                $respuesta_flyer = "";
            }else{
                $respuesta_flyer = $this->subir_flyer();
            }

            if ($respuesta_temario != "error_subida" && $respuesta_flyer != "error_subida") {
                $nuevo_curso = array(
                    'curso_titulo' => $this->input->post('curso_titulo'),
                    'curso_flyer' => $respuesta_flyer,
                    'curso_tipo' => $this->input->post('curso_tipo'),
                    'curso_descripcion' => $this->input->post('curso_descripcion'),
                    'curso_objetivos' => $this->input->post('curso_objetivos'),
                    'curso_temario' => $respuesta_temario,
                    'curso_fecha_inicio' => $this->input->post('curso_fecha_inicio'),
                    'curso_fecha_fin' => $this->input->post('curso_fecha_fin'),
                    'curso_hora_inicio' => $this->input->post('curso_hora_inicio'),
                    'curso_hora_fin' => $this->input->post('curso_hora_fin'),
                    'curso_cupo' => $this->input->post('curso_cupo'),
                    'curso_ubicacion' => $this->input->post('curso_ubicacion'),
                    'curso_mapa_url' => $this->input->post('curso_url_ubicacion'),
                    'curso_telefono' => $this->input->post('curso_telefono'),
                    'curso_telefono_extension' => $this->input->post('curso_telefono_extension'),
                    'curso_estatus' => 2
                );

                if ($nuevo_curso['curso_cupo'] == "") {
                    $nuevo_curso['curso_cupo'] = 0;
                }

                $id_curso_creado = $this->curso_model->registrar_curso($nuevo_curso);

                foreach ($this->input->post('curso_instructor') as $key => $value) {
                    $this->curso_model->registrar_instructor_curso($id_curso_creado, $value);
                }

                $_POST = array();

                $this->editar($id_curso_creado);
            }
        }
    }

    function subir_temario()
    {
        $config['upload_path'] = './assets/temarios_cursos/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = '5120';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload("curso_temario"))
        {
            echo $this->upload->display_errors();
            return "error_subida";
        }else{
            $datos = $this->upload->data();
            return $datos["file_name"];
        }
    }

    function subir_flyer()
    {
        $config['upload_path'] = './assets/flyers_cursos/';
        $config['allowed_types'] = 'gif|jpg';
        $config['max_size'] = '2048';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        $this->upload->initialize($config);

        if (!$this->upload->do_upload("curso_flyer"))
        {
            echo $this->upload->display_errors();
            return "error_subida";
        }else{
            $datos = $this->upload->data();
            return $datos["file_name"];
        }
    }

    function consulta_cursos()
    {
        $cursos = $this->curso_model->consulta_cursos();

        foreach($cursos as $llave => &$curso)
        {
            if ($curso['curso_tipo'] == '0')
            {
                $curso['curso_tipo'] = 'Presencial';
            }else{
                $curso['curso_tipo'] = 'En línea';
            }

            if ($curso['curso_cupo'] == '0') {
                $curso['curso_cupo'] = "No se registró cupo";
                $curso['curso_cupo_disponible'] = "No se registró cupo";
            }else{
                $curso_inscritos = $this->curso_model->contar_inscritos($curso['id_curso']);
                $curso['curso_cupo_disponible'] = $curso['curso_cupo'] - $curso_inscritos;
            }

            $curso['curso_instructor'] = $this->curso_model->consulta_instructores_nombre_curso($curso['id_curso']);
        }

        print_r(json_encode($cursos));
    }

    function eliminar($id_curso)
    {
        $this->curso_model->eliminar($id_curso);

        redirect('cursos');
    }

    function buscar()
    {
        if (!empty($_POST)) {

            $parametros_busqueda = array(
                'nombre_curso'  => $this->input->post('nombre_curso'),
                'tipo_curso'    => $this->input->post('tipo_curso'),
                'estatus_curso' => $this->input->post('estatus_curso'),
                'inicio_curso'  => $this->input->post('inicio_curso'),
                'fin_curso'     => $this->input->post('fin_curso')
            );

            $nombre_completo = $this->input->post('instructor_curso');
            if ($nombre_completo != "") {
                $arreglo_nombre = explode(" ", $nombre_completo);
                $tamano_arreglo = count($arreglo_nombre);

                switch ($tamano_arreglo) {
                    case 1:
                        $parametros_busqueda['nombre_instructor'] = $arreglo_nombre[0];
                        $parametros_busqueda['paterno_instructor'] = "";
                        $parametros_busqueda['materno_instructor'] = "";
                        break;

                    case 2:
                        $parametros_busqueda['nombre_instructor'] = $arreglo_nombre[0];
                        $parametros_busqueda['paterno_instructor'] = $arreglo_nombre[1];
                        $parametros_busqueda['materno_instructor'] = "";
                        break;

                    case 3:
                        $parametros_busqueda['nombre_instructor'] = $arreglo_nombre[0];
                        $parametros_busqueda['paterno_instructor'] = $arreglo_nombre[1];
                        $parametros_busqueda['materno_instructor'] = $arreglo_nombre[2];
                        break;

                    case 4:
                        $parametros_busqueda['nombre_instructor'] = $arreglo_nombre[0]." ".$arreglo_nombre[1];
                        $parametros_busqueda['paterno_instructor'] = $arreglo_nombre[2];
                        $parametros_busqueda['materno_instructor'] = $arreglo_nombre[3];
                        break;
                    
                    default:
                        $parametros_busqueda['nombre_instructor'] = "";
                        $parametros_busqueda['paterno_instructor'] = "";
                        $parametros_busqueda['materno_instructor'] = "";
                        break;
                }
            } else {
                $parametros_busqueda['nombre_instructor'] = "";
                $parametros_busqueda['paterno_instructor'] = "";
                $parametros_busqueda['materno_instructor'] = "";
            }

            $resultado_busqueda['resultado'] = $this->curso_model->buscar($parametros_busqueda);

            if (!is_null($resultado_busqueda['resultado'])) {
                foreach($resultado_busqueda['resultado'] as $llave => &$curso)
                {
                    if ($curso['curso_tipo'] == '0')
                    {
                        $curso['curso_tipo'] = 'Presencial';
                    }else{
                        $curso['curso_tipo'] = 'En línea';
                    }
                    $curso['curso_instructor'] = $this->curso_model->consulta_instructores_nombre_curso($curso['id_curso']);
                }
            }

            $this->load->view('template/header');
            $this->load->view('template/menu');
            $this->load->view('buscar_curso',$resultado_busqueda);
            $this->load->view('template/footer');

        }
    }

    function editar($id_curso)
    {
        if (empty($_POST)) {

            if (is_array($id_curso)) {
                $var_id = $id_curso;
                $var_id["nuevo"] = 1;
            }else{
                $var_id = array('id_curso' => $id_curso,
                                'nuevo' => 0
                );
            }

            $this->load->view('template/header');
            $this->load->view('template/menu');
            $this->load->view('editar_curso', $var_id);
            $this->load->view('template/footer');
        }else{

            if ($_FILES['curso_temario']['size'] == 0) {
                $respuesta_temario = $this->input->post('temario_anterior');
            }else{
                $respuesta_temario = $this->subir_temario();
            }

            if ($_FILES['curso_flyer']['size'] == 0) {
                $respuesta_flyer = $this->input->post('flyer_anterior');
            }else{
                $respuesta_flyer = $this->subir_flyer();
            }

            $editar_curso = array(
                'curso_titulo' => $this->input->post('curso_titulo'),
                'curso_flyer' => $respuesta_flyer,
                'curso_tipo' => $this->input->post('curso_tipo'),
                'curso_descripcion' => $this->input->post('curso_descripcion'),
                'curso_objetivos' => $this->input->post('curso_objetivos'),
                'curso_temario' => $respuesta_temario,
                'curso_fecha_inicio' => $this->input->post('curso_fecha_inicio'),
                'curso_fecha_fin' => $this->input->post('curso_fecha_fin'),
                'curso_hora_inicio' => $this->input->post('curso_hora_inicio'),
                'curso_hora_fin' => $this->input->post('curso_hora_fin'),
                'curso_cupo' => $this->input->post('curso_cupo'),
                'curso_ubicacion' => $this->input->post('curso_ubicacion'),
                'curso_mapa_url' => $this->input->post('curso_url_ubicacion'),
                'curso_telefono' => $this->input->post('curso_telefono'),
                'curso_telefono_extension' => $this->input->post('curso_telefono_extension'),
                'curso_estatus' => 2
            );

            $editar_curso['id_curso'] = $id_curso;

            $this->curso_model->editar_curso($editar_curso);

            $this->curso_model->borrar_instructor_curso($id_curso);
            foreach ($this->input->post('curso_instructor') as $key => $value) {
                $this->curso_model->registrar_instructor_curso($id_curso, $value);
            }

            $_POST = array();

            $enviar = array('id_curso' => $id_curso);

            $this->editar($enviar);
        }
    }

    function consulta_curso($id_curso)
    {
        $curso = $this->curso_model->consulta_curso($id_curso);

        print_r(json_encode($curso));
    }

    function consulta_instructores()
    {
        $instructores = $this->curso_model->consulta_instructores();

        print_r(json_encode($instructores));
    }

    function consulta_contactos()
    {
        $parametros = array(
            'correo'    => $this->input->post('correo'),
            'instancia' => $this->input->post('instancia'),
            'id_curso'  => $this->input->post('id_curso')
        );

        $nombre_completo = $this->input->post('nombre');

        if ($nombre_completo != "") {
            $arreglo_nombre = explode(" ", $nombre_completo);
            $tamano_arreglo = count($arreglo_nombre);

            switch ($tamano_arreglo) {
                case 1:
                    $parametros['nombre_contacto'] = $arreglo_nombre[0];
                    $parametros['paterno_contacto'] = "";
                    $parametros['materno_contacto'] = "";
                    break;

                case 2:
                    $parametros['nombre_contacto'] = $arreglo_nombre[0];
                    $parametros['paterno_contacto'] = $arreglo_nombre[1];
                    $parametros['materno_contacto'] = "";
                    break;

                case 3:
                    $parametros['nombre_contacto'] = $arreglo_nombre[0];
                    $parametros['paterno_contacto'] = $arreglo_nombre[1];
                    $parametros['materno_contacto'] = $arreglo_nombre[2];
                    break;

                case 4:
                    $parametros['nombre_contacto'] = $arreglo_nombre[0]." ".$arreglo_nombre[1];
                    $parametros['paterno_contacto'] = $arreglo_nombre[2];
                    $parametros['materno_contacto'] = $arreglo_nombre[3];
                    break;
                
                default:
                    $parametros['nombre_contacto'] = "";
                    $parametros['paterno_contacto'] = "";
                    $parametros['materno_contacto'] = "";
                    break;
            }
        } else {
            $parametros['nombre_contacto'] = "";
            $parametros['paterno_contacto'] = "";
            $parametros['materno_contacto'] = "";
        }

        $resultado_total = $this->curso_model->consulta_contactos($parametros);

        $invitados = $this->curso_model->consulta_invitado_curso($parametros['id_curso']);

        if (!is_null($invitados) && !is_null($resultado_total)) {
            foreach ($invitados as $key_invitados => $id_invitado) {
                foreach ($resultado_total as $key => &$contacto) {
                    if ($id_invitado['invitado_id'] == $contacto['id_contacto']) {
                        unset($resultado_total[$key]);
                    }
                }
            }
        }

        print_r(json_encode($resultado_total));
    }

    function agrega_invitados()
    {
        $this->curso_model->borrar_invitado_tipo($this->input->post('id_curso'));

        if ($this->input->post('webmaster')) {
            $this->curso_model->registrar_invitado_tipo($this->input->post('id_curso'), 1);
        }

        if ($this->input->post('comunicacion')) {
            $this->curso_model->registrar_invitado_tipo($this->input->post('id_curso'), 2);
        }

        if ($this->input->post('tecnico')) {
            $this->curso_model->registrar_invitado_tipo($this->input->post('id_curso'), 3);
        }

        if ($this->input->post('otros')) {
            $this->curso_model->registrar_invitado_tipo($this->input->post('id_curso'), 4);
        }

        if ($this->input->post('invitados')) {
            foreach ($this->input->post('invitados') as $key => $value) {
                $this->curso_model->registrar_invitado_contacto($this->input->post('id_curso'), $value);
            }
        }
    }

    function consulta_invitado_tipo($id_curso)
    {
        $resultado = $this->curso_model->consulta_invitado_tipo($id_curso);

        print_r(json_encode($resultado));
    }

    function consulta_invitado_contacto($id_curso)
    {
        $resultado = $this->curso_model->consulta_invitado_contacto($id_curso);

        print_r(json_encode($resultado));
    }

    function consulta_instructores_curso($id_curso)
    {
        $instructores = $this->curso_model->consulta_instructores_curso($id_curso);

        print_r(json_encode($instructores));
    }

    function borrar_invitado_contacto(){
        $id_curso = $this->input->post('curso');
        $id_contacto = $this->input->post('contacto');

        $this->curso_model->borrar_invitado_contacto($id_curso, $id_contacto);
    }

    function detalle_curso($id_curso)
    {
        $curso = $this->curso_model->consulta_detalle_curso($id_curso);

        if (($curso['curso_flyer']) != "") {
            $tag_img = "<img src=".base_url('assets/flyers_cursos/')."/".$curso['curso_flyer']." width='200px' height='200px'>";
            $curso['curso_flyer'] = $tag_img;
        }

        if ($curso['curso_tipo'] == 0) {
            $curso['curso_tipo'] = "Presencial";
        }else{
            $curso['curso_tipo'] = "En línea";
        }

        $tag_a = "<a href=".base_url('assets/temarios_cursos/')."/".$curso['curso_temario']." target='_blank'>Ver temario</a>";
        $curso['curso_temario'] = $tag_a;

        if (($curso['curso_mapa_url']) != "") {
            $tag_url = "<a href=".$curso['curso_mapa_url']." class='conf_contacto_valores' target='_blank'>Ver en Google Maps</a>";
            $curso['curso_mapa_url'] = $tag_url;
        }

        $fecha_inicio_bd = explode("-", $curso['curso_fecha_inicio']);
        $curso['curso_fecha_inicio'] = $fecha_inicio_bd[2]."/".$fecha_inicio_bd[1]."/".$fecha_inicio_bd[0];

        $fecha_fin_bd = explode("-", $curso['curso_fecha_fin']);
        $curso['curso_fecha_fin'] = $fecha_fin_bd[2]."/".$fecha_fin_bd[1]."/".$fecha_fin_bd[0];

        $curso['profesor'] = $this->curso_model->consulta_instructores_nombre_curso($curso['id_curso']);

        $curso['invitados_contacto'] = $this->curso_model->consulta_invitado_contacto($curso['id_curso']);

        $curso['invitados_tipo'] = $this->curso_model->consulta_invitado_tipo_detalle($curso['id_curso']);

        $curso['inscritos'] = $this->curso_model->consulta_inscritos_detalle($curso['id_curso']);

        $curso['cancelados'] = $this->curso_model->consulta_cancelados_detalle($curso['id_curso']);


        //Falta desplegar info de Configuración del registro en línea

        foreach ($curso as $campo => $valor) {
            if ($curso[$campo] == "") {
                $curso[$campo] = "-";
            }
        }

        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('detalle_curso', $curso);
        $this->load->view('template/footer');
    }

    function consulta_instancias()
    {
        $instancias = $this->curso_model->consulta_instancias();

        print_r(json_encode($instancias));
    }

}