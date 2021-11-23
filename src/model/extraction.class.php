<?php
namespace Model;

class extraction{

    public $nIdExtration;
    public $nID;
    public $sContribuyente;
    public $sRFC;
    public $sExtractor;
    public $sPersonType;
    public $dPeriodFrom;
    public $dPeriodTo;
    public $sStatus;
    public $dStartedAt;
    public $dUpdatedAt;
    public $sDuration;
    public $nCreatedDataPoints;
    public $nUpdatedDataPoints;
    public $nRateLimitedAt;
    public $dCreatedAt;

    public function getnIdExtration() {
        return $this->nIdExtration;
    }
    public function setnIdExtration($value) {
        $this->nIdExtration = $value;
    }
    
    public function getnID() {
        return $this->nID;
    }
    public function setnID($value) {
        $this->nID = $value;
    }
   
    public function getsContribuyente() {
        return $this->sContribuyente;
    }
    public function setsContribuyente($value) {
        $this->sContribuyente = $value;
    }
  
    public function getsRFC() {
        return $this->sRFC;
    }
    public function setsRFC($value) {
        $this->sRFC = $value;
    }

    public function getsExtractor() {
        return $this->sExtractor;
    }
    public function setsExtractor($value) {
        $this->sExtractor = $value;
    }

    public function getsPersonType() {
        return $this->sPersonType;
    }
    public function setsPersonType($value) {
        $this->sPersonType = $value;
    }

    public function getdPeriodFrom() {
        return $this->dPeriodFrom;
    }
    public function setdPeriodFrom($value) {
        $this->dPeriodFrom = $value;
    }

    public function getdPeriodTo() {
        return $this->dPeriodTo;
    }
    public function setdPeriodTo($value) {
        $this->dPeriodTo = $value;
    }

    public function getsStatus() {
        return $this->sStatus;
    }
    public function setsStatus($value) {
        $this->sStatus = $value;
    }

    public function getdStartedAt() {
        return $this->dStartedAt;
    }
    public function setdStartedAt($value) {
        $this->dStartedAt = $value;
    }

    public function getdUpdatedAt() {
        return $this->dUpdatedAt;
    }
    public function setdUpdatedAt($value) {
        $this->dUpdatedAt = $value;
    }

    public function getsDuration() {
        return $this->sDuration;
    }
    public function setsDuration($value) {
        $this->sDuration = $value;
    }

    public function getnCreatedDataPoints() {
        return $this->nCreatedDataPoints;
    }
    public function setnCreatedDataPoints($value) {
        $this->nCreatedDataPoints = $value;
    }

    public function getnUpdatedDataPoints() {
        return $this->nUpdatedDataPoints;
    }
    public function setnUpdatedDataPoints($value) {
        $this->nUpdatedDataPoints = $value;
    }

    public function getnRateLimitedAt() {
        return $this->nRateLimitedAt;
    }
    public function setnRateLimitedAt($value) {
        $this->nRateLimitedAt = $value;
    }
    
    public function getdCreatedAt() {
        return $this->dCreatedAt;
    }
    public function setdCreatedAt($value) {
        $this->dCreatedAt = $value;
    }

    public function getInfoExtraction(){

        $db = new \Database\DB($GLOBALS["hostname"],$GLOBALS["username"],$GLOBALS["password"],$GLOBALS["database"],$GLOBALS["dbport"]);

        $selectExtraction = $db->query("CALL `db_satws_v2`.`sp_select_extractions`()");

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
    
    public function getInfoExtractionByIdExt(){

        $db = new \Database\DB($GLOBALS["hostname"],$GLOBALS["username"],$GLOBALS["password"],$GLOBALS["database"],$GLOBALS["dbport"]);

        $params = array(
            self::getnIdExtration()
        );
        $selectExtractionID = $db->query("CALL `db_satws_v2`.`sp_select_extractions_by_id`(?)",$params);

        $insertError = $db->getError();
        if ($insertError) {
            $response = array(
                'nCodigoError' => 99,
                'sMensajeError'  => $insertError
            );
        } else {
            $response = array(
                'sDataExtraction' => array_shift($selectExtractionID)
            );
        }
        return $response;
    }

    public function insertExtraction()
    {
        $db = new \Database\DB($GLOBALS["hostname"],$GLOBALS["username"],$GLOBALS["password"],$GLOBALS["database"],$GLOBALS["dbport"]);

        $params = array(
            self::getnID(),
            self::getsContribuyente(),
            self::getsRFC(),
            self::getsExtractor(),
            self::getsPersonType(),
            self::getdPeriodFrom(),
            self::getdPeriodTo(),
            self::getsStatus(),
            self::getdStartedAt(),
            self::getdUpdatedAt(),
            self::getsDuration(),
            self::getnCreatedDataPoints(),
            self::getnUpdatedDataPoints(),
            self::getnRateLimitedAt(),
            self::getdCreatedAt()
        );

        $insertExtraction = $db->query("CALL `db_satws_v2`.`sp_insert_extractions`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",$params);
        $insertError = $db->getError();
        if ($insertError) {
            $response = array(
                'nCodigoError' => 99,
                'sMensajeError'  => $insertError,
                'sData' =>''
            );
        } else {
            $response = array(
                'nCodigoError' => $insertExtraction[0]["nMsg"],
                'sMensajeError'  => $insertExtraction[0]["sMsg"],
                'sData' => ''
            );
        }
        
        return $response;
    }
    
}