<?php

class MSSoapClient extends SoapClient {
    private $namespace;
    private $label;
    public $serviceURL = '';
    
    /**
     * 
     * @param type $sNamespace
     */
    function setNamespace($sNamespace)
    {
        $this->namespace=$sNamespace;
    }
    
    /**
     * 
     * @param type $sLabel
     */
    function setLabel($sLabel)
    {
       $this->label=$sLabel;
    }
    
    /**
     * 
     * @param type $url
     */
    function setURL($url=null){
        if($url != null){
            $this->serviceURL = $url; 
        }
    }
    
    /**
     * 
     * @param type $idu
     * @return type
     */
    function datosEmpleado($idu){
            $wsdl= $this->serviceURL . "idUnamWS/WSVerificacionEmpleadoDGP?wsdl";
            $namespace = "http://verificacion.idUnamWs/";
            $sLabel = "id";
            $client=new MSSoapClient($wsdl);
            $client->setNamespace($namespace);
            $client->setLabel($sLabel);
            $idu = $idu;
            $vigente = array ($sLabel => $idu);
            $respuesta = $client->getEmpleado($vigente);
            return $respuesta;
    }

    /**
     * 
     * @param type $num
     * @param type $nac
     * @param type $fed
     * @param type $sist
     * @return type
     */
    function veriAlumno($num,$nac,$fed,$sist){
            $wsdl = $this->serviceURL . "/idUnamWS/WSVerificacion?wsdl";
            $namespace = "http://verificacion.idUnamWs/";
            $client=new MSSoapClient($wsdl);
            $client->setNamespace($namespace);
            $sLabel = array("numCuenta","fecNacimiento","entFederativa","cveSistema");
            $client->setLabel($sLabel);
            $vigente = array ("numCuenta" => $num, "fecNacimiento" => $nac, "entFederativa"=>$fed , "cveSistema"=>$sist);
            $respuesta = $client->verificarAlumno($vigente);
            return $respuesta;
    }

    /**
     * 
     * @param type $rfc
     * @param type $curp
     * @param type $sist
     * @return type
     */
    function veriEmpleado($rfc,$curp,$sist){
            $wsdl=$this->serviceURL . "idUnamWS/WSVerificacion?wsdl";
            $namespace = "http://verificacion.idUnamWs/";
            $client=new MSSoapClient($wsdl);
            $client->setNamespace($namespace);
            $sLabel = array("rfc","curpNumEmpleado","cveSistema");
            $client->setLabel($sLabel);
            $vigente = array ("rfc" => $num, "curpNumEmpleado" => $curp,  "cveSistema"=>$sist);
            $respuesta = $client->verificarEmpleado($vigente);
            return $respuesta;
    }
    
    /**
     * 
     * @param type $numInv
     * @param type $fecNac
     * @param type $entd
     * @param type $identificador
     * @param type $cvesist
     * @return type
     */
    function veriInvitado($numInv,$fecNac,$entd,$identificador,$cvesist){
            $wsdl= $this->serviceURL . "idUnamWS/WSVerificacion?wsdl";
            $namespace = "http://verificacion.idUnamWs/";
            $client=new MSSoapClient($wsdl);
            $client->setNamespace($namespace);
            $sLabel = array("numInvitado","fecNacimiento","entFederativa","identificador","cveSistema");
            $client->setLabel($sLabel);
            $vigente = array ("numInvitado" => $numInv, "fecNacimiento" => $fecNac,  "entFederativa"=>$entd, "identificador"=>$identificador, "cveSistema"=>$cvesist) ;
            $respuesta = $client->verificarInvitado($vigente);
            return $respuesta;
    }
}
?>
