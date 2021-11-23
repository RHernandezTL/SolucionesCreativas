<?php
namespace Classs;

class Satws{

    private $url;
    private $apy_key;
    private $sRFC;
    private $nID;
    private $sResource;
    private $sPassword;
    private $sType;


    public function getnID() {
        return $this->nID;
    }
    public function setnID($value) {
        $this->nID = $value;
    }
  
    public function getsRFC() {
        return $this->sRFC;
    }
    public function setsRFC($value) {
        $this->sRFC = $value;
    }
    
    public function getsPassword() {
        return $this->sPassword;
    }
    public function setsPassword($value) {
        $this->sPassword = $value;
    }
    
    public function getsType() {
        return $this->sType;
    }
    public function setsType($value) {
        $this->sType = $value;
    }
    
    public function getsResource() {
        return $this->sResource;
    }
    public function setsResource($value) {
        $this->sResource = $value;
    }


    public function getOpinionCompliance(){
        $curl = curl_init();
        $headers = array();
        $headers[] = 'Contetn-Type: application/json';
        $headers[] = 'Authorization: '.$GLOBALS["keyApp"];
        curl_setopt($curl, CURLOPT_URL, "https://api.sandbox.satws.com/extractions");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($curl);

        curl_close($curl);
        print_r($res);
        return utf8_encode($res);
    }

    public function getEventOpinionCompliance(){
        $_Get_Params = "itemsPerPage=20"."&source=%2Fextractions%2F".self::getnID();
        $_URL_Events = "https://api.sandbox.satws.com/events?".$_Get_Params;
        $curl = curl_init();        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $_URL_Events,
            CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',            
                CURLOPT_HTTPHEADER => array(
                    'X-API-Key: '. $GLOBALS["keyApp"],
                    'Content-Type: application/json'
                ),
            ));
            
            $responseGral = curl_exec($curl);
            $nCodigoError ="";
            $sMensajeError ="";
            
            if ($responseGral == false) {
                $nCodigoError = curl_errno($curl); 
                $sMensajeError = curl_error($curl);                
            }

            $response = array(
                'nCodigoError' => $nCodigoError,
                'sMensajeError'  => $sMensajeError,
                'sData' => $responseGral
            );
            curl_close($curl);
            
            return $response;
    }

    public function downloadPdfOpinion(){

        $_URL = "https://api.sandbox.satws.com/files/".self::getsResource()."/download";
        // print($_URL);
        $curl = curl_init();        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $_URL,
            CURLOPT_RETURNTRANSFER => true,
                // CURLOPT_ENCODING => '',
                // CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                // CURLOPT_FOLLOWLOCATION => true,
                // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',            
                CURLOPT_HTTPHEADER => array(
                    'X-API-Key: '. $GLOBALS["keyApp"],
                    'Content-Type: application/pdf'
                ),
            ));
            
            $responseGral = curl_exec($curl);
            // print_r($responseGral);
            // exit;

            $nCodigoError ="";
            $sMensajeError ="";
            
            if ($responseGral == false) {
                $nCodigoError = curl_errno($curl); 
                $sMensajeError = curl_error($curl);                
            }
            $srtResponse = (string) str_replace("Redirecting to","",$responseGral);
            $response = array(
                'nCodigoError' => $nCodigoError,
                'sMensajeError'  => $sMensajeError,
                'sData' => $srtResponse
            );
            curl_close($curl);
            // echo "\n";
            // print_r($srtResponse);
            return $response;
    }

    public function createCredencial(){
        $type = self::getsType();
        $Password = self::getsPassword();
        $RFC = self::getsRFC();
        $_URL = "https://api.sandbox.satws.com/credentials";
        $curl = curl_init();        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $_URL,
            CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST', 
                CURLOPT_POSTFIELDS => '{
                    "type": "'.$type.'",
                    "rfc": "'.$RFC.'",
                    "password": "'.$Password.'"
                }',           
                CURLOPT_HTTPHEADER => array(
                    'X-API-Key: '. $GLOBALS["keyApp"],
                    'Content-Type: application/json'
                ),
            ));
            
            $responseGral = curl_exec($curl);
            $nCodigoError ="";
            $sMensajeError ="";
            
            if ($responseGral == false) {
                $nCodigoError = curl_errno($curl); 
                $sMensajeError = curl_error($curl);                
            }

            $response = array(
                'nCodigoError' => $nCodigoError,
                'sMensajeError'  => "Operacion Exitosa!!",
                'sData' => $responseGral
            );
            curl_close($curl);
            return $response;
    }

}

?>