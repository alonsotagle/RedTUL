<?php
class Cron extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('cron_model');
        date_default_timezone_set('America/Mexico_City');
    }

	public function index()
	{
		if ($this->input->is_cli_request()) {
			$this->consulta_estatus_cursos();
			$this->correos_pendientes();
		}
	}

	function consulta_estatus_cursos()
	{
		$hoy = new DateTime("now");

		$cursos_pendientes = $this->cron_model->consulta_estatus_cursos_pendiente();
		$cursos_vigentes = $this->cron_model->consulta_estatus_cursos_vigente();

		if (!is_null($cursos_pendientes)) {
			foreach ($cursos_pendientes as $key => $value) {
				$fecha_inicio = date_create($value['curso_fecha_inicio']);

				if ($fecha_inicio <= $hoy) {
					$this->cron_model->update_curso_vigente($value['id_curso']);
				}
			}
		}

		if (!is_null($cursos_vigentes)) {
			foreach ($cursos_vigentes as $key => $value) {
				$fecha_fin = date_create($value['curso_fecha_fin']);

				if ($fecha_fin < $hoy) {
					$this->cron_model->update_curso_finalizado($value['id_curso']);
				}
			}
		}
	}

	function correos_pendientes()
	{
		$hoy = new DateTime("now");

		$correos_pendientes = $this->cron_model->correos_pendientes();

		if (!is_null($correos_pendientes)) {
			foreach ($correos_pendientes as $key => $value) {
				$fecha_envio = date_create($value['correo_fecha_envio']);
				$hora_envio = explode(":", $value['correo_hora_envio']);
				$fecha_envio->setTime($hora_envio[0], $hora_envio[1]);

				if ($fecha_envio <= $hoy) {
					$destinatarios = $this->cron_model->consulta_id_destinatario($id_correo);
					if (!is_null($destinatarios)) {
						$this->mandar_correo($value['id_correo'], $destinatarios);
					}
				}
			}
		}
	}

	function mandar_correo($id_correo, $destinatarios)
    {
        $this->load->library('class_email');
        $correo = $this->cron_model->consulta_correo($id_correo);
        
        extract($correo);

        $id_destinatarios = array();

        foreach ($destinatarios as $key => $value) {
        	array_push($id_destinatarios,$value['contacto_id']);
        }

        $email_data = array(
            'id_destinatarios'  => $id_destinatarios,
            'asunto'            => $correo_asunto,
            'contenido'         => $correo_contenido,
            'html'              => TRUE,
            'archivo_adjunto'   => $correo_archivo_adjunto
        );

        $enviado = $this->class_email->send_email($email_data);

        if ($enviado) {
        	$this->cron_model->update_correo_enviado($id_correo);
        }
    }
}