<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->library('form_validation');
    }

    public function index() {

        switch ($this->session->userdata('rol')) {

            case '':

                $data['titulo'] = "LOGIN";
                $data['token'] = $this->token();
                $this->load->view('template/header');
                $this->load->view('login_view', $data);
                $this->load->view('template/footer');

            break;

            case 'administrador':
                redirect('administrador');
                break;
            case 'auditor':
                redirect('auditor');
                break;
            case 'colaborador':
                redirect('colaborador');
                break;
            default:
                /* si quieren insertar un valor en select que no se encuentra en el swtich redirige 
                 * a logout donde destruye la sesión y manda a login.
                 */
                redirect('login/logout');
            break;
        }
    }

    function token() {
        $token = md5(uniqid(rand(), true));
        $this->session->set_userdata('token', $token);
        return $token;
    }

    public function autenticacion() {

        if (isset($_POST['usr_nombre']) && isset($_POST['usr_password']) && $_POST['usr_rol']) {
           
            $checkuser = $this->login_model->login_user($_POST['usr_nombre'], $_POST['usr_password'], $_POST['usr_rol']);

            if ($checkuser == TRUE) {
                $data = array(
                    'is_logued_in' => TRUE,
                    'id_usuario' => $checkuser->id_usuario,
                    'rol' => $checkuser->rol_nombre,
                    'username' => $checkuser->usr_nombre_usuario
                );
                $this->session->set_userdata($data);
                redirect('/login');
            } else {

                redirect('/login');
            }
        } else {
            redirect('/login');
        }
    }

    public function logout() {

        $this->session->sess_destroy();
        redirect('/login');
    }

    public function cambiarpassword() {


        if ($this->session->userdata('id_usuario') == FALSE) {
            redirect('/login');
        } else {
            if (empty($_POST)) {
                $this->load->view('template/header');
                switch ($this->session->userdata('rol')) {
                    case 'administrador':
                        $this->load->view('template/menuAdministrador');
                        break;
                    case 'auditor':
                        $this->load->view('template/menuAuditor');

                        break;
                    case 'colaborador':
                        $this->load->view('template/menuColaborador');

                        break;
                    default :
                        echo "HOLA";
                        break;
                }
                $this->load->view('cambiarpassword_view');
                $this->load->view('template/footer');
            } else {
                $this->form_validation->set_rules('password_actual', 'Contraseña', 'required');
                $this->form_validation->set_rules('nuevo1', 'Nueva contraseña ', 'required | min_length[6]| matches[nuevo2]');
                $this->form_validation->set_rules('nuevo2', 'Confrimación de nueva contraseña ', 'required|min_length[6]');
                if ($this->form_validation->run() == FALSE) {

                    $this->load->view('template/header');
                    switch ($this->session->userdata('rol')) {
                        case 'administrador':
                            $this->load->view('template/menuAdministrador');
                            break;
                        case 'auditor':
                            $this->load->view('template/menuAuditor');
                            break;
                        case 'colaborador':
                            $this->load->view('template/menuColaborador');
                            break;
                        default :
                            echo "HOLA";
                            break;
                    }
                    $this->load->view('cambiarpassword_view');
                    $this->load->view('template/footer');
                } else {
                    $comprobarContraseña = $this->login_model->verificarpass($this->session->userdata('id_usuario'), $_POST['password_actual']);
                    if ($comprobarContraseña == true) {
                        if (($_POST['nuevo1'] <> $_POST['nuevo2'])) {
                            $data['error'] = 'Las contraseñas no coincide';
                            $this->load->view('template/header');
                            switch ($this->session->userdata('rol')) {
                                case 'administrador':
                                    $this->load->view('template/menuAdministrador');
                                    break;
                                case 'auditor':
                                    $this->load->view('template/menuAuditor');

                                    break;
                                case 'colaborador':
                                    $this->load->view('template/menuColaborador');

                                    break;
                                default :
                                    echo "HOLA";
                                    break;
                            }
                            $this->load->view('cambiarpassword_view', $data);
                            $this->load->view('template/footer');
                        } else {

                            $checkcambio = $this->login_model->cambiar($this->session->userdata('id_usuario'), $_POST['nuevo2']);
                            if ($checkcambio == true) {
                                $data['error'] = "La contraseña ha sido actualizada Correctamente";

                                $this->load->view('template/header');
                                switch ($this->session->userdata('rol')) {
                                    case 'administrador':
                                        $this->load->view('template/menuAdministrador');
                                        break;
                                    case 'auditor':
                                        $this->load->view('template/menuAuditor');

                                        break;
                                    case 'colaborador':
                                        $this->load->view('template/menuColaborador');

                                        break;
                                    default :
                                        echo "HOLA";
                                        break;
                                }
                                $this->load->view('cambiarpassword_view', $data);
                                $this->load->view('template/footer');
                            }
                        }
                    } else {
                        $data['error'] = 'Las contraseñas es incorrecta';
                        $this->load->view('template/header');
                        switch ($this->session->userdata('rol')) {
                            case 'administrador':
                                $this->load->view('template/menuAdministrador');
                                break;
                            case 'auditor':
                                $this->load->view('template/menuAuditor');

                                break;
                            case 'colaborador':
                                $this->load->view('template/menuColaborador');

                                break;
                            default :
                                echo "HOLA";
                                break;
                        }
                        $this->load->view('cambiarpassword_view', $data);
                        $this->load->view('template/footer');
                    }
                }
            }
        }
    }

    public function recuperarpassword() {

        if (empty($_POST)) {
            $this->load->view('template/header');
            $this->load->view('recuperarpassword_view');
            $this->load->view('template/footer');
        } else {

            $checkemail = $this->login_model->verificaremail($_POST['txt_emailrecupear']);

            if ($checkemail == TRUE) {

                $mensaje = "Saludos:<br/>" . strtoupper($checkemail->usr_nombre) . " " . strtoupper($checkemail->usr_ap_paterno) . " " . strtoupper($checkemail->usr_ap_materno) . "<br/><b>Su nombre de usuario es: </b>" . $checkemail->usr_nombre_usuario . "<br/><b>Su contraseña actual es</b>: " . $checkemail->usr_password;


                $this->load->library('email_class');
                $email_data = array(
                    'from' => array('name' => 'Admin'),
                    'to' => array('email' => $_POST['txt_emailrecupear'], 'name' => 'Usuario '),
                    'subject' => 'Recupar Contraseña',
                    'message' => $mensaje
                );
                if ($this->email_class->send_email($email_data)) {
                    $data['mensaje'] = 'Su contraseña ha sido enviada a su correo satisfactoriamente.';
                    $this->load->view('template/header');
                    $this->load->view('recuperarpassword_view', $data);
                    $this->load->view('template/footer');
                } else {
                    $data['mensaje'] = "Error al enviar correo.";
                    $this->load->view('template/header');
                    $this->load->view('recuperarpassword_view', $data);
                    $this->load->view('template/footer');
                }
            } else {
                $data['mensaje'] = "No se encontró correo electrónico";
                $this->load->view('template/header');
                $this->load->view('recuperarpassword_view', $data);
                $this->load->view('template/footer');
            }
        }
    }

}
