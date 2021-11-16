<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opinión de cumplimiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/13403dc2d8.js" crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet"/>

</head>
<body>
    <div class="container py-4">

    <h2 class="container text-center my-4 py-4">Consulta al API del proveedor SATWS</h2>

    <div class="table-responsive py-4">
        <table class="table table-dark align-middle" id="tblOpinion">
            <thead>
                <tr>
                    <th scope="col">Numero</th>
                    <th scope="col">ID</th>
                    <th scope="col">Contribuyente</th>
                    <th scope="col">Extractor</th>
                    <th scope="col">Periodo Desde</th>
                    <th scope="col">Periodo Hasta</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Empezo En</th>
                    <th scope="col">Terminado En</th>
                    <th scope="col">Duracion</th>
                    <th scope="col">Datos Creados</th>
                    <th scope="col">Datos Actualizados</th>
                    <th scope="col">Extraccion Liquidada En</th>
                    <th scope="col">Creado En</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="grdOpinion">
                <!-- Carga de información dinamica-->            
            </tbody>

        </table>
    </div>
</div>

<!-- INIT MODAL - Sol contiene datos estáticos-->    
    <div class="modal fade" id="mdlEvent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalle de eventos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <table class="table table-dark" id="">
                                <thead>
                                    <tr>
                                        <th scope="col">Evento</th>
                                        <th scope="col">Ocurrencias</th>
                                    </tr>
                                </thead>
                                <tbody id="">
                                    <tr>
                                        <td>Archivo Creado</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>Opinión de cumplimiento Creada</td>
                                        <td>1</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- INIT MODAL -->

    <!-- INIT SCRIPT -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.js"></script>
    <script src="js/index.js"></script>
    <!-- FINISH SCRIPT -->
</body>
</html>
