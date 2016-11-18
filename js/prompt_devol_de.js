$(document).ready(function (){
    
    $('.contenidoDevoluciones').click(function (){
        $('.contenidoDevoluciones').fadeOut('fast');
        $('.detallesDevolucion').fadeOut('fast');
    });
    
    
    var codeBill;
    var codeNote;
    var codeArticle;
    var colorArticle;
    var fecha;
    var nameArticle;
    var cantidad;
    var valUnit;
    
    $('.imgEditClass').click(function (){
        $('.contenidoDevoluciones').fadeIn('fast');
        $('.detallesDevolucion').fadeIn('fast');
        
       
        var id = $(this).attr("id");
        
        codeBill = $('#hiddenBill').val();
        codeNote = $('#hiddenNote').val();
        codeArticle = $('#td1'+id).text();
        nameArticle = $('#td2'+id).text();
        cantidad = $('#td4'+id).text();
        fecha = $('#td7'+id).text();
        colorArticle = $('#td8'+id).text();        
        valUnit = $('#td5'+id).text(); 

//        alert("fac: "+codeBill+" Nota: "+codeNote+" art: "+codeArticle+" fecha: "+fecha+" color: "+colorArticle);
     
       $('#pDisponibles').text("\DISPONIBLES: "+cantidad);
       $('.detallesDevolucion h1').text(nameArticle);
       
        $('#hiddenIdf').attr('value', codeBill);
        $('#hiddenIdn').attr('value', codeNote);
        $('#hiddenIda').attr('value', codeArticle);
        $('#hiddenFc').attr('value', fecha);
        $('#hiddenCl').attr('value', colorArticle);
        $('#hiddenValUnit').attr('value', valUnit);
        
    });
            
    $('#txbRegresar').keyup(function (){
       /*var cantidadComprar = $('#txbQuantityBuy').val().replace(",", "");       
       var auxCant = parseInt($('#hiddenAuxAvailable').val().replace(",", "")); */
        
       var cantidadRegresar = parseFloat($('#txbRegresar').val());       
       	
       if(cantidadRegresar<=cantidad && cantidadRegresar!=0)
       {
           //alert("Si Disponibles: "+auxCant+"\nSolicitadas: "+cantidadComprar);
           $('#btnSubmit').removeAttr('disabled');       
           $('#pMensaje').text("");
       }
       else
       {
           //alert("No Disponibles: "+auxCant+"\nSolicitadas: "+cantidadComprar);
           $('#btnSubmit').attr('disabled', 'disabled'); 
           $('#pMensaje').text("CANTIDAD NO DISPONIBLE");           
       }
    }); 
});