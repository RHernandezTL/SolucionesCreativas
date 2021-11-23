<?php
include('../database/config.php');
include('../database/DB.class.php');
include('../model/Extraction.class.php');
include('../model/Events.class.php');
include('../class/Satws.class.php');

$params = $_POST;

if (!empty($params)) {
    if (isset($_GET["method"])) {

        $type = $_GET["method"];
        switch ($type) {

            case 'getEvent':
                $arrayResult = array();
                $_Id = $params['ID'];
                $_nIdExtration = $params['nIdExtration'];
                $satWs = new Classs\Satws();
                $extract = new Model\extraction();
                $event = new Model\events();
                
                //Busqueda en la BD detalle de la extraccion de un contibuyente
                $extract->setnIdExtration($_nIdExtration);
                $searchExtraction = $extract->getInfoExtractionByIdExt();

                //Busqueda en la BD de los eventos de un contibuyente guardados dentro del mes actual por ID de extraction
                $event->setnIdExtration($_nIdExtration);
                $searchEvents = $event->getInfoEventTaxplayer();

                if (count($searchEvents["sDataEvents"]) > 0 && count($searchExtraction) > 0) {
                    
                    $arrayResult = array_merge($searchEvents,$searchExtraction);
                    
                } else {
                    $resulInsertEvent = "";
                    $URLDownloadPDF = "";

                    //Busqueda de eventos de un contribuyente directo al API del SATWS
                    $satWs->setnID($_Id);
                    $consultSatWs = $satWs->getEventOpinionCompliance();
                    $data = $consultSatWs["sData"];
                    $hidraMember = (array)json_decode($data, true);
                    $arrayEvents = $hidraMember["hydra:member"];
                    // print_r($arrayEvents);
                    foreach ($arrayEvents as $value) {
                        // echo count($value["data"]["object"])." Ver filas";
                        $URLDownloadPDF = "";
                        $_type= "";
                        $_Resourse = isset($value["data"]["object"]["file"]) > 0 ? $value["data"]["object"]["file"]["id"] : "";
                        switch ($value["type"]) {
                            case 'file.created':
                                $_type= "Archivo Creado.";
                                break;
                            case 'tax_compliance_check.created':
                                $_type= "Opinión de cumplimiento Creada.";

                                $satWs->setsResource($_Resourse);
                                $resultDownloadPDF = $satWs->downloadPdfOpinion();

                                //Obtener la URL del documento obtenido devuelto del API de SATWS
                                preg_match_all("#<a.*?>([^<]+)</a>#", $resultDownloadPDF["sData"], $foo);
                                $URLDownloadPDF = array_shift($foo[1]);
                                break;
                            
                            default:
                                $_type= "Sin identificar aun.";
                                break;
                        }

                        $URL = $URLDownloadPDF ? $URLDownloadPDF : "";
                        $event->setnIdExtration($_nIdExtration);
                        $event->setnIDEv($value["id"]);
                        $event->setsTaxplayer($value["taxpayer"]["name"]);
                        $event->setsResource($value["resource"]);
                        $event->setsTypeEvent($_type);
                        $event->setsURLTaxtConpliance($URL);
                        $event->setdCreateAt($value["createdAt"]);

                        $resulInsertEvent = $event->insertEvents();
                    }
                    
                    if ($resulInsertEvent != null && $resulInsertEvent != "") {
                         //Busqueda en la BD detalle de la extraccion de un contibuyente
                        $extract->setnIdExtration($_nIdExtration);
                        $searchExtraction = $extract->getInfoExtractionByIdExt();
                        
                        //Busqueda en la BD de los eventos de un contibuyente guardados dentro del mes actual por ID de extraction
                        $event->setnIdExtration($_nIdExtration);
                        $searchEvents = $event->getInfoEventTaxplayer();

                        $arrayResult = array_merge($searchEvents,$searchExtraction);

                    } else {
                        # code...
                    }
                    
                }
                // print_r($arrayResult);
                if (count($arrayResult) > 0) {
                    echo json_encode($arrayResult);
                } else {
                    $arrayResult = array(
                        'nCodigoError' => 99,
                        'sMensajeError'  => "No se encontró información",
                        'sDataEvents' => ""
                    );
                    echo json_encode($arrayResult);
                }
                
                

                break;

            default:
                # code...
                break;
        }
    }
}



