<?php
    include('../database/config.php');
    include('../database/DB.class.php');
    include('../model/Extraction.class.php');
    include('../class/Satws.class.php');

    $searchExtraction = getInfoExtractionDB();

    if (count($searchExtraction["sData"]) > 0) {
        
        echo json_encode($searchExtraction);    
    
    } else {
        
        // Si No se obtuvieron registros de la base de datos
        // Entonces
        // Se consulta directo a API de SATWS
        $response = connectSatWsApi();
        echo json_encode($response);       
    }
    
    function getInfoExtractionDB(){
        
        $extract = new Model\extraction();
        $searchExtraction = $extract->getInfoExtraction();
        return $searchExtraction;
    }


    function connectSatWsApi(){

        $curl = curl_init();        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $GLOBALS["URL_SATWS"]."extractions/?itemsPerPage=100",
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
                $response = array(
                    'nCodigoError' => $nCodigoError,
                    'sMensajeError'  => $sMensajeError,
                    'sData' => ""
                );
                curl_close($curl);
                
                return $response;
                
            }else{
                
                $responseApi = (array)json_decode($responseGral, true);
                curl_close($curl);
                $extract = new Model\extraction();
                
                foreach ($responseApi["hydra:member"] as $value) {
                    $periodFrom = "";
                    $periodTo = "";
                    if (count($value["options"]) > 0) {
                        $periodFrom = $value["options"]["period"]["from"] ? $value["options"]["period"]["from"] : "";
                        $periodTo = $value["options"]["period"]["to"] ? $value["options"]["period"]["to"] : "";
                    }
                    $extractor = "";
                    switch ($value["extractor"]) {
                        case 'tax_compliance':
                            $extractor = "Opinión de Cumplimiento";
                            break;                        
                            
                        case 'monthly_tax_return':
                            $extractor = "Declaración Mensual";
                            break;                        
                        case 'annual_tax_return':
                            $extractor = "Declaración Anual";
                            break;                        
                        case 'tax_retention':
                            $extractor = "Retenciones";
                            break;                        
                        case 'rif_tax_return':
                            $extractor = "Declaración RIF";
                            break;                        
                        case 'tax_status':
                            $extractor = "Situación fiscal";
                            break;                        
                        case 'invoice':
                            $extractor = "Factura";
                            break;                        
                        default:
                            $extractor = "Indefinido";
                            break;
                    }
                    if ($value["status"] == "finished") {
                        $estatus = "Terminado";
                    }elseif($value["status"] == "failed"){
                        $estatus = "Error";
                    }

                    $extract->setnID($value["id"]);
                    $extract->setsContribuyente($value["taxpayer"]["name"]);
                    $extract->setsRFC($value["taxpayer"]["id"]);
                    $extract->setsExtractor($extractor);
                    $extract->setsPersonType($value["taxpayer"]["personType"]);
                    $extract->setdPeriodTo($periodTo);
                    $extract->setdPeriodFrom($periodFrom);
                    $extract->setsStatus($estatus);
                    $extract->setdStartedAt($value["startedAt"]);
                    $extract->setdUpdatedAt($value["updatedAt"]);
                    $extract->setsDuration("00:00:00");
                    $extract->setnCreatedDataPoints($value["createdDataPoints"]);
                    $extract->setnUpdatedDataPoints($value["updatedDataPoints"]);
                    $extract->setnRateLimitedAt($value["rateLimitedAt"]);
                    $extract->setdCreatedAt($value["createdAt"]);
                    
                    $extract->insertExtraction();
                    
                }

                $counRegister = count($responseApi["hydra:member"]);
                
                if ($counRegister > 0) {

                    $searchExtraction = getInfoExtractionDB();
                    return $searchExtraction;

                }else{
                    return array(
                        'nCodigoError' => 99,
                        'sMensajeError'  => "Operacion fallida!!",
                        'sData' => ""
                    );
                }
        }
    }
?>