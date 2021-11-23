$(document).ready(function () {
    getOpinion();

    $(document).on('click', '#downloadPDF', function (e) {
        var Url_pdf = e.currentTarget.attributes['data-pdf'].value;
        if (Url_pdf != "") {
            $('#iframeComplaince').attr('src', Url_pdf);
            $('#mdlEvent').modal('show');
            
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Este tipo, no contiene algun archivo para descargar',
                showConfirmButton: false,
                timer: 2000
            }); 
        }
    });
});

function getOpinion() {
    // $('#dSpinner').modal('show');
    var url = '../controller/ComplianceOpinion.php?method=getEvent';
    $.post(url, { 'ID': ID, 'nIdExtration': nIdExtration },
        function (response) {
            // $('#dSpinner').modal('hide');
            var obj = JSON.parse(response);
            if (obj.nCodigoError == 0) {
                

            var objet = obj['sDataEvents'];
            var objDetalle = obj['sDataExtraction'];
            $('#sContribuyente').html(objDetalle.sContribuyente);
            $('#sCreateAt').html(objDetalle.sCreateAt);
            $('#sStatus').html(objDetalle.sStatus);
            $('#nLimiteRate').html(objDetalle.nLimiteRate);
            $('#dPeriodFrom').html(objDetalle.dPeriodFrom);
            $('#dPeriodTo').html(objDetalle.dPeriodTo);
            $('#dStartedAt').html(objDetalle.dStartedAt);
            $('#dUpdatedAt').html(objDetalle.dUpdatedAt);
            $('#sDuration').html(objDetalle.sDuration);
            $('#nCreatedDataPoints').html(objDetalle.nCreatedDataPoints);
            $('#nUpdatedDataPoints').html(objDetalle.nUpdatedDataPoints);
            
            var sHtml = '';
            var num = 1;
            if (objet) {
                $.each(objet, function (key, value) {
                    sHtml = sHtml + '<tr>';
                    sHtml = sHtml + '<td class="align-middle text-center">' + objet[key]['nIDEv'] + '</td>';                                                      //ID
                    sHtml = sHtml + '<td class="align-middle text-center"><span class="">' + objet[key]["sTaxplayer"] + '</span></td>';                               //Contribullente
                    sHtml = sHtml + '<td class="align-middle text-left"><span>' + objet[key]["sTypeEvent"] + '</span></span></td>'; // Extractor
                    sHtml = sHtml + '<td class="align-middle text-center"><span>' + objet[key]["sResource"] + '</span></td>';       //Duracion
                    sHtml = sHtml + '<td class="align-middle text-center"><span>' + objet[key]["dCreateAt"] + '</span></td>';          //Creados En
                    sHtml = sHtml + '<td class="align-middle text-center">';
                    sHtml = sHtml + '<a id="downloadPDF" href="#" data-pdf="' + objet[key]["sURLTaxtConpliance"] + '"><i class="fas fa-file-pdf fa-5x"></i></a>';             //Acciones
                    sHtml = sHtml + '</td>';
                    sHtml = sHtml + '</tr>';
                    num++;
                });
                $('#tblEvent').DataTable().destroy();
                $('#tblEvent tbody').empty();

                $('#grdEvents').html(sHtml);

                Swal.fire({
                    icon: 'success',
                    title: 'Consulta Exitosa!!!',
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {
                $('#tblEvent').DataTable().destroy();
                $('#tblEvent tbody').empty();

                $('#grdEvents').html("No se encontraron resultados :( !!!");
            }
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'No se encontraron elementos que mostrar',
                showConfirmButton: false,
                timer: 2000
            }).then(function(){
                window.location.href="../index.php";
            });       
        }


        }).fail(function (error) {
            console.log(error);
        });
}
