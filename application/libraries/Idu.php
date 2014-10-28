<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script'); 

require('MSSoapClient.php');
require('XmlToArray.php');

class Idu {

    public $name = "Idu";
    public $SOAP;
    public $controller = true;
    public $serviceURL = 'http://132.248.63.219:8082/';
    protected $iduIp = "http://132.248.63.219:8082";
    protected $iduValidateSuffix = "/SIU/validate?service=";
    protected $iduLoginSuffix = '/SIU/login?service=';
    protected $iduLogoutSuffix = '/SIU/logout?url=';

    /*==================================================================
     * CONSTANTES 
     ===================================================================*/
    /*
     * Constantes para las etiquetas que recibe el web service
     */
    const CLAVE_SESION = 'claveSesion';
    const IDENTIFICADOR = 'identificador';

    /*
     * Constantes de para identificar los servicios web.
     */
    const SERVICIO_POR_SESION = 'idUnamWS/consultaDatosGenerales?wsdl';
    const SERVICIO_POR_IDENTIFICADOR = 'idUnamWS/consultaDatosGeneralesPorIdentificador?wsdl';

    /*==================================================================
     * INTERFAZ PUBLICA 
     ===================================================================*/        

    /**
     * Setter del URL de IDU
     * @param type $iduIp
     */
    public function setIduUrl($iduIp){
        $this->iduIp = $iduIp;
    }

    /**
     * Setter del sufijo de IDU para validar un ticket
     * @param type $iduValidateSuffix
     */
    public function setIduValidateSuffix($iduValidateSuffix){
        $this->iduValidateSuffix = $iduValidateSuffix;
    }

    /**
     * Devuelve el URL de Idu que permite realizar un login
     * @param type $app_login_url
     * @return type
     */
    public function getIduLoginURL($app_login_url){
        return $this->iduIp . $this->iduLoginSuffix . $app_login_url;
    }

    /**
     * Devuelve el URL del Idu que permite realizar el logout.
     * @param type $app_logout_url
     */
    public function getIduLogoutURL($app_logout_url){
        return $this->iduIp.$this->iduLogoutSuffix.$app_logout_url;
    }

    /**
     * Establece el URL del web service.
     * @param type $url
     */
    public function setURL($url=null){
        if($url != null){
            $this->serviceURL = $url;
        }            
    }

    /**
     * Consulta la información de un usuario por un id de sesion
     * @param type $sessionId
     */
    public function consultaPorSesion($sessionId){
        $servicio = IduComponent::SERVICIO_POR_SESION;
        $slabel = IduComponent::CLAVE_SESION;
        $id = $sessionId;
        $respuesta = $this->consultarWS($servicio, $slabel, $id);
        return $respuesta;
    }

    /**
     * Consulta la informacion de un usuario por su ID en IDU.
     * @param type $idu
     */
    public function consultaPorIdu($idu){
        $servicio = self::SERVICIO_POR_IDENTIFICADOR;
        $label = self::IDENTIFICADOR;
        $id = $idu;
        $respuesta = $this->consultarWS($servicio, $label, $id);
        return $respuesta;
    }

    /**
     * Obtiene el identificador del usuario apartir del ticket.
     */
    public function getIdentificadorIDU($ticket, $app_service_url){

        if(!$this->recibioTicket($ticket)){
            throw new IduException();
        }

        $TIMEOUT = 30;
        $VALIDATE_URL = $this->iduIp . 
                $this->iduValidateSuffix . 
                $app_service_url."&ticket=$ticket";

        $handler = curl_init();
        curl_setopt($handler , CURLOPT_URL, $VALIDATE_URL);
        curl_setopt($handler , CURLOPT_TIMEOUT, $TIMEOUT);
        curl_setopt($handler , CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handler , CURLOPT_FOLLOWLOCATION, true);
        $resultado = curl_exec($handler);

        $resultado = trim($resultado);
        $limit = strlen($resultado);
        $resp = substr($resultado, 0, 3);
        $resp = strtolower(trim($resp));

        if($resp != 'yes' || $limit <= 2){
            throw new IduException();
        }

        $identificador = substr($resultado, 4, $limit);//obtiene identificador         
        return $identificador;
    }

    private function recibioTicket($ticket=null){
        $recibio = true;
        if($ticket == null || empty($ticket)){
            $recibio = false;
        }
        return $recibio;            
    }

    /**
     * Realiza la consulta al web service de IDU.
     * @param type $servicio
     * @param type $label
     * @param type $id
     * @return type
     * @throws Exception
     */
    private function consultarWS($servicio, $label, $id){
        $respuesta = null;
        $peticion = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:con="http://consultaDatos.idUnamWs/">'
            . '<soapenv:Header/>'
                    .'<soapenv:Body>'
                            .'<con:consultarDatosGenerales>'
                                    .'<!--Optional:-->'
                                    .'<'.$label.'>'.$id.'</'.$label.'>'
                            .'</con:consultarDatosGenerales>'
                    .'</soapenv:Body>'
            .'</soapenv:Envelope>';

        try{
            $wsdl = $this->serviceURL . $servicio;
            $cliente = new MSSoapClient($wsdl, array('trace'=>1));                
            $cliente->setURL($this->serviceURL);
            $namespace = "http://consultaDatos.idUnamWs/";
            $cliente->setNamespace($namespace);
            $cliente->setLabel($label);
            $vigente = array ($label => $id);
            $action=0;
            $version=0;
            $xml = array ($cliente->__doRequest($peticion, $wsdl, $action, $version));
            if($xml){
                $xmlObj = new XmlToArray($xml[0]);
                $respuesta_extendida = $xmlObj->createArray();
                $respuesta = $this->compacta($respuesta_extendida);
            }                
        }catch(Exception $exc){
            throw new Exception("Error al consultar el servicio: " . $exc->getMessage());
        }
        return $respuesta;
    }

    /**
     * Recibe el arreglo que devuelve la consulta al web service y devuelve
     * el fragmento del arreglo que contiene los datos generales.
     * @param type $arrayData
     * @return type
     */
    private function compacta($arrayData){
        $datosGenerales = null;
        if(array_key_exists('ns2:consultarDatosGeneralesResponse', $arrayData['S:Envelope']['S:Body'][0])){
            $datosGenerales = $arrayData['S:Envelope']['S:Body'][0]['ns2:consultarDatosGeneralesResponse'][0]['return'][0];
        }
        return $datosGenerales;
    }
}

class IduException extends Exception {

}

/* End of file Idu.php */