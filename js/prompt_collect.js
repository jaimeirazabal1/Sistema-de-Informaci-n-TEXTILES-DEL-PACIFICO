$(document).ready(function (){
    $('#btnSubmit').attr('disabled', 'disabled'); 
    
    $('#formSubmit').submit(function(){
	$(':submit').attr('disabled', 'disabled');
    })
    
    $('.contenidoRecaudo').click(function (){
        $('.contenidoRecaudo').fadeOut('fast');
        $('.detallesRecaudo').fadeOut('fast');
    });
    
    var saldo;
    
    $('.imgEditClass').click(function (){
        $('.contenidoRecaudo').fadeIn('fast');
        $('.detallesRecaudo').fadeIn('fast');
       
        saldo = $('#hiddenSaldoCredit').val();   
        
               
        //$('#pValor').text("VALOR: "+valor);
        $('#pSaldo').text("SALDO: $ "+formato_numero(saldo,0,'.',','));
        $('#pMensaje').text("");                        
    });
    
    
             
    $('.txbValue').keyup(function (){        
       var valorPagar = $(".txbValue").val().replace(",", "");       
       var saldoActual = $("#hiddenSaldoCredit").val().replace(",", "");
       
       valorPagar = parseFloat(valorPagar.replace(",", ""));       
       saldoActual = parseFloat(saldoActual.replace(",", ""));  
       
//       alert("VPagar: "+valorPagar+"\nSaldoActual"+saldoActual);
       
       if(valorPagar > 0){
           if(valorPagar <= saldoActual){
               $('#btnSubmit').removeAttr('disabled');       
               $('#pMensaje').text("");
           }
           else{
               $('#pMensaje').text("RECAUDO MAYOR AL SALDO"); 
               $('#btnSubmit').attr('disabled', 'disabled'); 
           }
       }
       else{
           $('#btnSubmit').attr('disabled', 'disabled'); 
           $('#pMensaje').text("EL VALOR DEBE SER MAYOR A CERO(0)"); 
       }       
    }); 
    
    
    function formato_numero(numero, decimales, separador_decimal, separador_miles){ // v2007-08-06
    numero=parseFloat(numero);
    if(isNaN(numero)){
        return "";
    }

    if(decimales!==undefined){
        // Redondeamos
        numero=numero.toFixed(decimales);
    }

    // Convertimos el punto en separador_decimal
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");

    if(separador_miles){
        // Añadimos los separadores de miles
        var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
        while(miles.test(numero)) {
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }

    return numero;
}
    
});