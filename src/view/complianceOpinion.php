<?php 

$postParams = $_POST; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opinión de cumplimiento</title>
    <?php include('header.php');?>
    
    <style>
        .dataExtraction {
            border-width: 0.2rem;
            border: solid #efeff3;
            padding: 1.5rem;
            margin-right: 0;
            margin-left: 0;
        }

        .dataEventComplaince {
            border-width: 0.2rem;
            border: solid #f7f7f9;
            padding: 1.5rem;
            margin-right: 0;
            margin-left: 0;
        }

        .bd-example-modal-lg .modal-dialog {
            display: table;
            position: relative;
            margin: 0 auto;
            top: calc(50% - 24px);
        }

        .bd-example-modal-lg .modal-dialog .modal-content {
            background-color: transparent;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container my-3">
    <?php include('menu.php')?>
        <div id='data_spinner'>
            <h2 class="container text-center my-4 py-4">Consulta y de los eventos de un contribuyente y descarga en PDF la opinion de cumplimiento</h2>
            <div class="dataExtraction py-4">
                <table class="table table-bordered">
                    <thead></thead>
                    <tbody>
                        <tr>
                            <th scope="col">Contribuyente</th>
                            <td colspan="3" id="sContribuyente">.....</td>
                            <th scope="col">Creado en</th>
                            <td scope="col" id="sCreateAt">.....</td>
                            <th scope="col">Estatus</th>
                            <td scope="col" id="sStatus">.....</td>
                        </tr>
                        <tr>
                            <th scope="row">límite de tasa en</th>
                            <td colspan="1" id="nLimiteRate">.....</td>
                            <th colspan="1">Periodo desde </th>
                            <td colspan="1" id="dPeriodFrom">.....</td>
                            <th colspan="1">Periodo Hasta</th>
                            <td colspan="1" id="dPeriodTo">.....</td>
                            <th colspan="1">Opciones</th>
                            <td colspan="1"></td>
                        </tr>
                        <tr>
                            <th colspan="1" scope="row">Empezó En</th>
                            <td colspan="1" id="dStartedAt">.....</td>
                            <th colspan="1">Terminado End</th>
                            <td colspan="1" id="dUpdatedAt">.....</td>
                            <th colspan="1">Duraciónd</th>
                            <td colspan="3" id="sDuration">.....</td>
                        </tr>
                        <tr>
                            <th colspan="1">Datos Creados</th>
                            <td colspan="3" id="nCreatedDataPoints">.....</td>
                            <th colspan="1">Datos Actualizados</th>
                            <td colspan="3" id="nUpdatedDataPoints">.....</td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div class="dataExtraction my-6">
                <table class="table table-dark" id="tblEvent">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Contribuyente</th>
                            <th>Tipo</th>
                            <th>Recurso</th>
                            <th>Creado En</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="grdEvents">
                        <!-- Carga de información dinamica-->
                    </tbody>
                </table>
            </div>


            <!-- INIT MODAL DOWNLOAD PDF COMPLAINCE OF OPINION-->
            <div class="modal fade" id="mdlEvent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="max-width:1070px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detalle de eventos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Init conteiner -->
                            <div class="" id="frmComplaince">
                                <iframe class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="iframeComplaince" src="" style="height:800px; width:90%;"></iframe>
                            </div>
                            <!-- Final container -->
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIN MODAL -->

            <!-- INIT MODAL SPINNER-->
            <div class="modal fade bd-example-modal-lg" id="dSpinner" data-backdrop="static" data-keyboard="false" tabindex="-1">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content" style="width: 48px">
                        <span class="fa fa-spinner fa-spin fa-3x"></span>
                    </div>
                </div>
            </div>
            <!-- FIN MODAL SPINNER-->
        </div>

    </div>
    <!-- INIT SCRIPT -->
    <?php include('footer.php')?>
    <script type="text/javascript" src="../js/complianceOpinion.js"></script>
    <script type="text/javascript">
        var ID = '<?php echo $postParams['ID']; ?>';
        var nIdExtration = '<?php echo $postParams['nIdExtration']; ?>';
    </script>
    <!-- FINISH SCRIPT -->
</body>

</html>