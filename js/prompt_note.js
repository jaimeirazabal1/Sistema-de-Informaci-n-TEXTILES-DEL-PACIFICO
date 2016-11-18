$(document).ready(function (){
    
    $('.contenidoNota').click(function (){
        $('.contenidoNota').fadeOut('fast');
        $('.detallesNota').fadeOut('fast');
    });
    
    
    var codeBill;
    var id;
    var typeClient;
    
    $('.imgEditClass').click(function (){
        $('.contenidoNota').fadeIn('fast');
        $('.detallesNota').fadeIn('fast');
        id = $(this).attr("id");
        
        codeBill = $('#td1'+id).text();
        typeClient = $('#td6'+id).text();
        
        $('#hiddenCodeRemision').attr('value', codeBill);

        $('#pMensaje').text("");
        
        //si es proveedor
        if(typeClient == 3){
            //$('#selectTypeNote option:eq(0)').attr('selected', 'selected');
            $('#selectTypeNote').empty();
            $('#selectTypeNote').append('<option value="DE" selected="selected">DEBITO</option>');
        }
        else{
            $('#selectTypeNote').empty();
            $('#selectTypeNote').append('<option value="CR" selected="selected">CREDITO</option>');
        }
    });
             
    $('.txbValue').keyup(function (){        
       var valorPagar = $(".txbValue").val().replace(",", "");       
       
       if(valorPagar > 0){
            $('#btnSubmit').removeAttr('disabled');       
            $('#pMensaje').text("");
       }
       else{
           $('#btnSubmit').attr('disabled', 'disabled'); 
           $('#pMensaje').text("EL VALOR DEBE SER MAYOR A CERO(0)"); 
       }  
     
    }); 
});