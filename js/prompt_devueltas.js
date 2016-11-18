$(document).ready(function (){
    
    $('.contenidoDevueltas').click(function (){
        $('.contenidoDevueltas').fadeOut('fast');
        $('.detallesDevueltas').fadeOut('fast');
    });
    
    
    var code;
    var quantity;
    var priceVenta;
    
    $('#btnDevueltas').click(function (){
        $('.contenidoDevueltas').fadeIn('fast');
        $('.detallesDevueltas').fadeIn('fast');
    });
            
   /* $('#txbRecibido').focusout(function (){
       var recibido = $('#txbRecibido').val().replace(",", "");     
       var total = $('#totalBill').val();
       $('#pMensajeDevuelta').text('Devuelta: $ '+(recibido-total));
       //alert(cantidadComprar+" - "+$('#totalBill').val());
    }); */
    
    $('#txbRecibido').keypress(function (){
       var keycode = (event.keyCode ? event.keyCode : event.which);
       if(keycode == '13') {//entra si presiona enter
            var recibido = $('#txbRecibido').val().replace(",", "");     
            var total = $('#totalBill').val();
            var cambio = recibido - total;

            var numberCambio = new String(cambio);
            var resultCambio = '';

             while (numberCambio.length > 3)
             {
                 resultCambio = ',' + numberCambio.substr(numberCambio.length - 3) + resultCambio;
                 numberCambio = numberCambio.substring(0, numberCambio.length - 3);
             }

             resultCambio = numberCambio + resultCambio;
             $('#pMensajeDevuelta').text('Devuelta: $ '+ resultCambio);
             //alert(cantidadComprar+" - "+$('#totalBill').val());
        }
    }); 
    
});