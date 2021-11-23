<?php include('../database/config.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Cotribuyente</title>
    <?php include('header.php'); ?>
</head>
<body>
    <div class="container my-2">
        <?php include('menu.php') ?>
        <h2 class="container text-center my-4 py-4">Alta de un contribuyente en el ambiente de [<?php echo $GLOBALS["Environment"]; ?>]</h2>
        <iframe name="frame" style="display:none;"></iframe>
        <div class="row">
            <form method="POST" action="../controller/Taxpayer.php" target="frame" class="col-md-6 col-lg-6" style="margin:0 auto">
                <legend>Registra tu credencial del Servicio de Administración Tributaria (SAT)</legend>
                <div class="mb-3">
                    <label for="disabledSelect" class="form-label">CIEC / E.FIRMA</label>
                    <select id="sType" name="sType" class="form-select">
                        <option value="1">ciec</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="disabledTextInput" class="form-label">RFC *</label>
                    <input type="text" id="sRFC" name="sRFC" class="form-control" placeholder="RFC" required maxlength="13">
                </div>
                <div class="mb-3">
                    <label for="disabledTextInput" class="form-label">Contraseña *</label>
                    <input type="password" id="sPassword" name="sPassword" class="form-control" maxlength="8" required placeholder="Password">
                </div>
                <div class="text-center my-3">
                    <button type="button" id="newTaxpayer" class="btn btn-primary form-control">Guardar</button>
                </div>
            </form>
        </div>

    </div>
    <!-- INIT SCRIPT -->
    <?php include('footer.php') ?>
    <script type="text/javascript" src="../js/taxpayer.js"></script>
    <!-- FINISH SCRIPT -->
</body>

</html>