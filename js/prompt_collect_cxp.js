$(document).ready(function (){
    
    $('#formSubmit').submit(function(){
	$(':submit').attr('disabled', 'disabled');
    })
    
    $('.contenidoRecaudo').click(function (){
        $('.contenidoRecaudo').fadeOut('fast');
        $('.detallesRecaudo').fadeOut('fast');
    });
        
    var codeCxp;
    var valor;
    var saldo;
    var id;
    var type;
    
    $('.imgEditClass').click(function (){
        $('.contenidoRecaudo').fadeIn('fast');
        $('.detallesRecaudo').fadeIn('fast');
        id = $(this).attr("id");
        
        codeCxp = $('#td1'+id).text();
        valor = $('#td5'+id).text();
        saldo = $('#td6'+id).text();   
        $('#btnSubmit').removeAttr('disabled'); 
        
//        alert("Saldo: "+saldo+" - Valor: "+valor);
//        type =  $('#td7'+id).text();   
               
        $('#pValor').text("VALOR: "+valor);
        
        if(saldo != 0)
            $('#pSaldo').text("SALDO: "+saldo);
        $('#pMensaje').text("");
        
        $('#hiddenSaldo').attr('value', saldo);
        $('#hiddenCodeCxp').attr('value', codeCxp);
        $('#hiddenValAux').attr('value', valor);
//        $('#hiddenType').attr('value', type);      
                
    });
    
    
             
    $('.txbValue').keyup(function (){      
       var valorPagar = $(".txbValue").val().replace(",", "");       
       var saldoActual = $("#hiddenSaldo").val().replace(",", "");
       var aux =  $('#hiddenValAux').val().replace(",", "");    
       
       aux = aux.replace(",", "");       
       aux = parseFloat(aux.replace(",", ""));
       valorPagar = valorPagar.replace(",", "");       
       valorPagar = parseFloat(valorPagar.replace(",", ""));       
       saldoActual = saldoActual.replace(",", "");  
       saldoActual = parseFloat(saldoActual.replace(",", ""));  
       
//       alert("VPagar: "+valorPagar+"\nSaldoActual"+saldoActual+"\nAux: "+aux);
       
       if(valorPagar > 0){
           //var maxVal = saldoActual;
           
           if(saldoActual == 0){
               if(valorPagar <= aux){
                   $('#btnSubmit').removeAttr('disabled');       
                   $('#pMensaje').text("");
                }
                else{
                    $('#btnSubmit').attr('disabled', 'disabled'); 
                    $('#pMensaje').text("EL VALOR DEBE SER MENOR AL TOTAL"); 
                }
           }           
           else if(valorPagar <= saldoActual){
               $('#btnSubmit').removeAttr('disabled');       
               $('#pMensaje').text("");
           }
           else{
               $('#btnSubmit').attr('disabled', 'disabled'); 
               $('#pMensaje').text("EL VALOR DEBE SER MENOR AL SALDO"); 
           }
            
       }
       else{
           $('#btnSubmit').attr('disabled', 'disabled'); 
           $('#pMensaje').text("EL VALOR DEBE SER MAYOR A CERO(0)"); 
       }       
    }); 
    
    
});