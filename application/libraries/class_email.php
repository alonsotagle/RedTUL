<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Class_email{

    private $email;
    private $password;

    function __construct(){ 
        $this->email = 'arelivaz@comunidad.unam.mx';
        $this->password = '5631gaviota4731';
    }
    
    function send_email($data){
        $CI =& get_instance();
        $CI->load->model('mensajeria_model');
        $CI->load->library('phpmailer');
        extract($data); 
    
        //SMTP needs accurate times, and the PHP time zone MUST be set
        //This should be done in your php.ini, but this is how to do it if you don't have access to that
        date_default_timezone_set('America/Mexico_City');

        //Create a new PHPMailer instance
        //$mail = new PHPMailer();
        //Tell PHPMailer to use SMTP
        $CI->phpmailer->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $CI->phpmailer->SMTPDebug  = 0;
        //Ask for HTML-friendly debug output
        $CI->phpmailer->Debugoutput = 'html';
        //Set the hostname of the mail server
        $CI->phpmailer->Host       = 'smtp.office365.com';
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $CI->phpmailer->Port       = 587;
        //Set the encryption system to use - ssl (deprecated) or tls
        $CI->phpmailer->SMTPSecure = 'tls';
        //Whether to use SMTP authentication
        $CI->phpmailer->SMTPAuth   = true;
        $CI->phpmailer->CharSet    = 'UTF-8';
        //Username to use for SMTP authentication - use full email address for gmail
        $CI->phpmailer->Username   = $this->email;
        //Password to use for SMTP authentication
        $CI->phpmailer->Password   = $this->password;

        $CI->phpmailer->From   = $this->email;
        $CI->phpmailer->FromName = 'Red Toda La UNAM en Línea';
        $CI->phpmailer->Subject = $asunto;

        if ($html) {
            $CI->phpmailer->isHTML($html);
        }

        $CI->phpmailer->msgHTML($contenido);
        $CI->phpmailer->AltBody = '';
        $CI->phpmailer->AddAttachment($archivo);

        //Destinatarios
        $destinatarios = $CI->mensajeria_model->consulta_contactos_correos($id_destinatarios);

        foreach ($destinatarios as $key => $value) {
            if ($value['contacto_correo_inst'] != "") {
                $CI->phpmailer->AddAddress($value['contacto_correo_inst'], $value['contacto_nombre']." ".$value['contacto_ap_paterno']." ".$value['contacto_ap_materno']);
            } else {
                $CI->phpmailer->AddAddress($value['contacto_correo_per'], $value['contacto_nombre']." ".$value['contacto_ap_paterno']." ".$value['contacto_ap_materno']);
            }
        }

        if(!$CI->phpmailer->Send()) {
          echo "Mailer Error: " . $CI->phpmailer->ErrorInfo;
        } else {
          return true;
        }       

    }

}