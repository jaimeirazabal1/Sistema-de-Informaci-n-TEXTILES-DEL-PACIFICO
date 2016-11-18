$(document).ready(function (){
    
    $('.contenidoCantidadPrecio').click(function (){
        $('.contenidoCantidadPrecio').fadeOut('fast');
        $('.detallesCantidadPrecio').fadeOut('fast');
    });
    
    
    var code;
    var name;
    var quantityAvailable;
    var priceBuy;
    var color;
//    var priceSale;
    
    $('.imgEditClass').click(function (){
        $('.contenidoCantidadPrecio').fadeIn('fast');
        $('.detallesCantidadPrecio').fadeIn('fast');
        
       
        var id = $(this).attr("id");
        
        code = $('#td1'+id).text();
        name = $('#td2'+id).text();
        quantityAvailable = $('#td3'+id).text();
        priceBuy = $('#td4'+id).text();
        color = $('#td6'+id).text();
//        priceSale = $('#td7'+id).text();
        
     
       $('#pDisponibles').text("\DISPONIBLES: "+quantityAvailable);
       //$('#pPrecioCompra').text("\PRECIO COMPRA: $ "+priceBuy);
//       $('#pPrecioVenta').text("\PRECIO VENTA: $ "+priceSale);
       $('.detallesCantidadPrecio h1').text(name);
       
        $('#hiddenCodeArticle').attr('value', code);
//        $('#hiddenName').attr('value', name); 
        $('#hiddenPriceBuy').attr('value', priceBuy);
        $('#hiddenAuxAvailable').attr('value', quantityAvailable);
        $('#hiddenColor').attr('value', color);
         
        
    });
            
    $('#txbQuantityBuy').keyup(function (){
       /*var cantidadComprar = $('#txbQuantityBuy').val().replace(",", "");       
       var auxCant = parseInt($('#hiddenAuxAvailable').val().replace(",", "")); */
        
       var cantidadComprar = $('#txbQuantityBuy').val();       
       var auxCant = parseFloat($('#hiddenAuxAvailable').val());
        
		
       if(cantidadComprar<=auxCant && cantidadComprar!=0)
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