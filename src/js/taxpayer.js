$(document).ready(function () {

    $(document).on('click', '#newTaxpayer', function (e) {
        var sRFC = $('#sRFC').val();
        var sType = $('#sType').val();
        var sPassword = $('#sPassword').val();

        $.post('../controller/Taxpayer.php', 
        { 
            'sRFC': sRFC, 
            'sType': sType,
            'sPassword': sPassword
        },
        function (response) {
            var obj = JSON.parse(response);
            if (obj["nCodigoError"] == 0) {
                
                Swal.fire({
                    icon: 'success',
                    title: 'operacion Exitosa',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function(){
                    window.location.href="../index.php";
                });
            }

        });
        
    });
});