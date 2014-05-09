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

    function registrar_curso(){
        if (!empty($_POST)) {

            $nuevo_curso = array(
                'curso_titulo' => $this->input->post('curso_titulo'),
                'curso_flyer' => '/',
                'curso_tipo' => $this->input->post('curso_tipo'),
                'curso_descripcion' => $this->input->post('curso_descripcion'),
                'curso_objetivos' => $this->input->post('curso_objetivos'),
                'curso_temario' => '/',
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

            $_POST = array();

            $resultado = $this->curso_model->recuperar_id();

            $this->editar($resultado);
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

            $curso['curso_instructor'] = "";
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

                    $curso['curso_instructor'] = "";
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
                                'nuevo' => 0);
            }

            $this->load->view('template/header');
            $this->load->view('template/menu');
            $this->load->view('editar_curso', $var_id);
            $this->load->view('template/footer');
        }else{

            $editar_curso = array(
                'curso_titulo' => $this->input->post('curso_titulo'),
                'curso_flyer' => '/',
                'curso_tipo' => $this->input->post('curso_tipo'),
                'curso_descripcion' => $this->input->post('curso_descripcion'),
                'curso_objetivos' => $this->input->post('curso_objetivos'),
                'curso_temario' => '/',
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

            $this->confirmacion_curso($editar_curso);
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

}