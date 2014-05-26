<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Class_email{

    private $email;
    private $password;

    function __construct(){ 
        $this->email = 's.g.c.dgtic@gmail.com';
        $this->password = 'sgc123456';
    }
    
    function send_email($data){
        $CI =& get_instance();
        $CI->load->library('phpmailer');
        extract($data); 
    
        //SMTP needs accurate times, and the PHP time zone MUST be set
        //This should be done in your php.ini, but this is how to do it if you don't have access to that
        date_default_timezone_set('America/Mexico_City');

        //Create a new PHPMailer instance
        //$mail = new PHPMailer();
        //Tell PHPMailer to use SMTP
        $CI->phpmailer->IsSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $CI->phpmailer->SMTPDebug  = 0;
        //Ask for HTML-friendly debug output
        $CI->phpmailer->Debugoutput = 'html';
        //Set the hostname of the mail server
        $CI->phpmailer->Host       = 'smtp.gmail.com';
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $CI->phpmailer->Port       = 587;
        //Set the encryption system to use - ssl (deprecated) or tls
        $CI->phpmailer->SMTPSecure = 'tls';
        //Whether to use SMTP authentication
        $CI->phpmailer->SMTPAuth   = true;
        $CI->phpmailer->CharSet  = 'UTF-8';
        //Username to use for SMTP authentication - use full email address for gmail
        $CI->phpmailer->Username   = $this->email;
        //Password to use for SMTP authentication
        $CI->phpmailer->Password   = $this->password;

        $CI->phpmailer->From   = 'alonso.tagle@unam.mx';
        $CI->phpmailer->FromName = 'Red Toda La UNAM en L&iacute;nea';
        $CI->phpmailer->Subject = $asunto;

        if (false) {
            $CI->phpmailer->isHTML($html);
        }

        $CI->phpmailer->msgHTML($contenido." <b>bold</b>");
        $CI->phpmailer->AltBody = 'This is a plain-text message body';
        $CI->phpmailer->AddAttachment($archivo);

        $CI->phpmailer->AddAddress($to['email'], $to['name']);

        if(!$CI->phpmailer->Send()) {
          echo "Mailer Error: " . $CI->phpmailer->ErrorInfo;
        } else {
          return true;
        }       

    }

}