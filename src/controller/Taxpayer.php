<?php
include('../database/config.php');
include('../class/Satws.class.php');

$PostParams = $_POST;
if (!empty($PostParams)) {
    $satWs = new Classs\Satws();
    if ($PostParams["sType"] = 1) {
        $type = "ciec";
    }else{
        $type = "efirma";
    }
    $satWs->setsRFC($PostParams["sRFC"]);
    $satWs->setsType($type);
    $satWs->setsPassword($PostParams["sPassword"]);
    $resultAPI = $satWs->createCredencial();

    echo json_encode($resultAPI);
    
} else {
    $response = array(
        'nCodigoError' => $nCodigoError,
        'sMensajeError'  => "Los parametros no son los esperados.",
        'sData' => ""
    );
    echo json_encode($response);
}


?>