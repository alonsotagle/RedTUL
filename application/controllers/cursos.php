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

                $this->curso_model->registrar_curso($nuevo_curso);

                $id_curso_creado = $this->curso_model->recuperar_id();

                foreach ($this->input->post('curso_instructor') as $key => $value) {
                    $this->curso_model->registrar_instructor_curso($id_curso_creado['id_curso'], $value);
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

            $resultado_busqueda['resultado'] = $this->curso_model->buscar($_POST);

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

            $respuesta_temario = $this->subir_temario();

            if ($_FILES['curso_flyer']['size'] == 0) {
                $respuesta_flyer = "";
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
            'nombre' => $this->input->post('nombre'),
            'correo' => $this->input->post('correo'),
            'instancia' => $this->input->post('instancia')
        );

        $resultado = $this->curso_model->consulta_contactos($parametros);

        print_r(json_encode($resultado));
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

}