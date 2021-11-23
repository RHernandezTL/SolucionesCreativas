<?php
namespace Model;

class events{
    public $nIdEvent;
    public $nIdExtration;		
    public $nIDEv;
    public $sTaxplayer;
    public $sResource;
    public $sTypeEvent;
    public $sURLTaxtConpliance;
    public $dCreateAt;

    public function getnIdEvent() {
        return $this->nIdEvent;
    }
    public function setnIdEvent($value) {
        $this->nIdEvent = $value;
    }

    public function getnIdExtration() {
        return $this->nIdExtration;
    }
    public function setnIdExtration($value) {
        $this->nIdExtration = $value;
    }

    public function getnIDEv() {
        return $this->nIDEv;
    }
    public function setnIDEv($value) {
        $this->nIDEv = $value;
    }
    
    public function getsTaxplayer() {
        return $this->sTaxplayer;
    }
    public function setsTaxplayer($value) {
        $this->sTaxplayer = $value;
    }
    
    public function getsResource() {
        return $this->sResource;
    }
    public function setsResource($value) {
        $this->sResource = $value;
    }

    public function getsTypeEvent() {
        return $this->sTypeEvent;
    }
    public function setsTypeEvent($value) {
        $this->sTypeEvent = $value;
    }

    public function getsURLTaxtConpliance() {
        return $this->sURLTaxtConpliance;
    }
    public function setsURLTaxtConpliance($value) {
        $this->sURLTaxtConpliance = $value;
    }

    public function getdCreateAt() {
        return $this->dCreateAt;
    }
    public function setdCreateAt($value) {
        $this->dCreateAt = $value;
    }

    public function insertEvents(){

        $db = new \Database\DB($GLOBALS["hostname"],$GLOBALS["username"],$GLOBALS["password"],$GLOBALS["database"],$GLOBALS["dbport"]);

        $params = array(
            self::getnIdExtration(),
            self::getnIDEv(),
            self::getsTaxplayer(),
            self::getsResource(),
            self::getsTypeEvent(),
            self::getsURLTaxtConpliance(),
            self::getdCreateAt()
        );
        // print_r($params);
        // exit;
        $selectExtraction = $db->query("CALL `db_satws_v2`.`sp_insert_events_taxpayer`(?,?,?,?,?,?,?)",$params);

        $insertError = $db->getError();
        if ($insertError) {
            $response = array(
                'nCodigoError' => 99,
                'sMensajeError'  => $insertError
            );
        } else {
            $response = array(
                'nCodigoError' => 0,
                'sMensajeError'  => "Operación Exitosa!!",
                'sData' => $selectExtraction
            );
        }
        return $response;
    }

    public function getInfoEventTaxplayer(){

        $db = new \Database\DB($GLOBALS["hostname"],$GLOBALS["username"],$GLOBALS["password"],$GLOBALS["database"],$GLOBALS["dbport"]);

        $params = array(
            self::getnIdExtration()
        );
        $selectEvents = $db->query("CALL `db_satws_v2`.`sp_select_events_taxpayer`(?)",$params);

        $insertError = $db->getError();
        if ($insertError) {
            $response = array(
                'nCodigoError' => 99,
                'sMensajeError'  => $insertError
            );
        } else {
            $response = array(
                'nCodigoError' => 0,
                'sMensajeError'  => $insertError,
                'sDataEvents' => $selectEvents
            );
        }
        return $response;
    }

}
?>