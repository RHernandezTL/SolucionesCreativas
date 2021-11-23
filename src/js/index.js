$(document).ready(function () {
    console.log("Hola mundo");

    getOpinion();

    $(document).on('click', '#nID', function (e) {
        var nID = e.currentTarget.attributes['data-ID'].value;
        var nIdExtration = e.currentTarget.attributes['data-nIdExtration'].value;
        var paramsForm = '<form id="enviar" action="../src/view/complianceOpinion.php" method="post">' +
            '<input type="text" name="ID" value="' + nID + '"/>' +
            '<input type="text" name="nIdExtration" value="' + nIdExtration + '"/>' +
            '</form>';
        $('body').append(paramsForm);

        $('#enviar').submit();
        $('#enviar').remove();
    });
});

function getOpinion() {
    var url = 'controller/Extraction.php';
    $.post(url,
        function (response) {
            var obj = JSON.parse(response);
            var objet = obj['sData'];
            var sHtml = '';
            var num = 1;
            if (objet) {
                $.each(objet, function (key, value) {
                    var periodFrom = objet[key]["dPeriodFrom"] ? objet[key]["dPeriodFrom"] : "";
                    var periodTo = objet[key]["dPeriodTo"] ? objet[key]["dPeriodTo"] : "";

                    var startAt = objet[key]["dStartedAt"] ? objet[key]["dStartedAt"] : "";
                    var finishAt = objet[key]["finishedAt"] ? objet[key]["finishedAt"] : "";
                    var rateLimit = objet[key]["nRateLimitedAt"] ? objet[key]["nRateLimitedAt"] : "";

                    sHtml = sHtml + '<tr>';
                    sHtml = sHtml + '<td class="align-middle text-center">' + objet[key]['nIdExtration'] + '</td>';                                             //ID Interno
                    sHtml = sHtml + '<td class="align-middle text-center">'
                    sHtml = sHtml + '<a id="nID" href="#" data-ID="' + objet[key]['nID'] + '" data-nIdExtration="' + objet[key]['nIdExtration'] + '" onclick="goEventCompliance(' + objet[key]['nID'] + ');">' + objet[key]['nID'] + '</a></td>';                                                      //ID
                    sHtml = sHtml + '<td class="align-middle text-center"><span class="">' + objet[key]["sRFC"] + '</span></td>';                               //Contribullente
                    sHtml = sHtml + '<td class="align-middle text-left"><span class="d-inline-flex"><span>' + objet[key]["sExtractor"] + '</span></span></td>'; // Extractor
                    sHtml = sHtml + '<td class="align-middle text-left"><span>' + periodFrom + '</span></td>';                      //Periodo desde
                    sHtml = sHtml + '<td class="align-middle text-left"><span>' + periodTo + '</span></td>';                        // Periodo hasta
                    sHtml = sHtml + '<td class="align-middle text-center"><span>' + objet[key]["sStatus"] + '</span></td>';         //Estatus
                    sHtml = sHtml + '<td class="align-middle text-center"><span>' + startAt + '</span></td>';                       //Empezo En
                    sHtml = sHtml + '<td class="align-middle text-center"><span>' + objet[key]["dUpdatedAt"] + '</span></td>';      //Termino En
                    sHtml = sHtml + '<td class="align-middle text-center"><span>' + objet[key]["sDuration"] + '</span></td>';       //Duracion
                    sHtml = sHtml + '<td class="align-middle text-center"><span>' + objet[key]["nCreatedDataPoints"] + '</span></td>';              //Datos creados
                    sHtml = sHtml + '<td class="align-middle text-center"><span>' + objet[key]["nUpdatedDataPoints"] + '</span></td>';          //Datos Actualizados
                    sHtml = sHtml + '<td class="align-middle text-center"><span>' + rateLimit + '</span></td>';                             //Extraccon liquidacion en
                    sHtml = sHtml + '<td class="align-middle text-center"><span>' + objet[key]["dCreatedAt"] + '</span></td>';          //Creados En
                    sHtml = sHtml + '<td class="align-middle text-center">';
                    sHtml = sHtml + '<a href="#" onclick="showEventOpinion();"><i class="fas fa-file text-2"></i></a>';             //Acciones
                    sHtml = sHtml + '</td>';
                    sHtml = sHtml + '</tr>';
                    num++;
                });
                $('#tblOpinion').DataTable().destroy();
                $('#tblOpinion tbody').empty();

                $('#grdOpinion').html(sHtml);

                var table = $('#tblOpinion').DataTable({
                    "language": {
                        search: 'Buscar:',
                        "lengthMenu": "Mostrando _MENU_ registros por pagina",
                        "zeroRecords": "Sin datos",
                        "info": "Mostrando _PAGE_ de _PAGES_",
                        "infoEmpty": "Sin registros",
                        "infoFiltered": "(filtrados de _MAX_)",
                        paginate: {
                            first: 'Primero',
                            previous: 'Anterior',
                            next: 'Siguiente',
                            last: 'Último',
                        }
                    }
                });

            } else {
                $('#tblOpinion').DataTable().destroy();
                $('#tblOpinion tbody').empty();

                $('#grdOpinion').html("No se encontraron resultados :( !!!");
            }


        }).fail(function (error) {
            console.log(error);
        });
}

function showEventOpinion(ID) {
    console.log(ID);
    $('#mdlEvent').modal('show');
}

function goEventCompliance(ID) {
    var paramsForm = '<form id="enviar" action="../src/view/complianceOpinion.php" method="post">' +
        '<input type="text" name="ID" value="' + ID + '"/>' +
        '</form>';
    $('body').append(paramsForm);

    $('#enviar').submit();
    $('#enviar').remove();
}