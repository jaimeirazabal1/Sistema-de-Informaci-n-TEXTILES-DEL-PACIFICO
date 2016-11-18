$(document).ready(function () {
    // cada vez que se cambia el valor del combo
    $("#txbCode").keypress(function () {
        var txt = $('#txbCode').val();
        if(txt.length >= 16)
        {
            alertify.dismissAll();
            alertify.error("El código del artículo excede la longitud permitida: 16 caracteres");
        }
    });
});