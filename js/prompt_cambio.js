$(document).ready(function (){
    
    $('.contenidoDevueltas').click(function (){
        $('.contenidoDevueltas').fadeOut('fast');
        $('.detallesDevueltas').fadeOut('fast');
    });
    
    
    var code;
    var name;
    var quantity;
    var priceUnit;
    var priceTotal;
    var color;
    
    $('.imgCambio').click(function (){
        var id = $(this).attr("id");
        $('.contenidoDevueltas').fadeIn('fast');
        $('.detallesDevueltas').fadeIn('fast');
        
        code = $('#td1'+id).text();
        name = $('#td2'+id).text();
        quantity = $('#td3'+id).text();
        priceUnit = $('#td4'+id).text();
        priceTotal = $('#td5'+id).text();
        color = $('#td6'+id).text();
        
        $('#txbCantidadCambiar').val(quantity);
        $('#txbCantidadCambiar').attr('max', quantity);       
        
    });
    
    $('#btnAddChange').click(function (){
       //alert("Articulo: "+code+"\nCantidad: "+quantity+"\nValor Unit: "+priceUnit+"\n");
       var cantSolicitada = $('#txbCantidadCambiar').val();
       var totalSolicitado = 0;
       totalSolicitado = parseFloat(cantSolicitada) * parseFloat(priceUnit.replace(",", ""));
       
       //totalSolicitado = (totalSolicitado * parseInt($('#txbHiddenIva').val()) / 100);
       
        var aux = parseFloat($('#txbHiddenTotalCambio').val()) + totalSolicitado;
       
        var newTotal = aux;
        $('#txbHiddenTotalCambio').attr('value', newTotal);
        var number = new String(newTotal);
        var result = '';

        while (number.length > 3)
        {
            result = ',' + number.substr(number.length - 3) + result;
            number = number.substring(0, number.length - 3);
        }

        result = number + result;        
       
       
       //**************************
        var newTotalA = totalSolicitado;        
        var numberA = new String(newTotalA);
        var resultA = '';

        while (numberA.length > 3)
        {
            resultA = ',' + numberA.substr(numberA.length - 3) + resultA;
            numberA = numberA.substring(0, numberA.length - 3);
        }

        resultA = numberA + resultA;
       
       //**************************
       
       $row = '<tr> <td>'+code+'</td> <td>'+name+'</td> <td class="tdDerecha">'+cantSolicitada+'</td> <td class="tdDerecha">'+priceUnit+'</td> <td class="tdDerecha">'+resultA+'</td><td class="tdNoVisible">'+color+'</td> </tr>'
       $('#tableChange').append($row);
       //var aiv =  result + (result * (parseInt($('#txbHiddenIva').val()) / 100));
       $('#h1Total').text("Total canjeable sin IVA: $ "+result);
       
      
       $('.contenidoDevueltas').fadeOut('fast');
       $('.detallesDevueltas').fadeOut('fast');
    });  
    
    $('#btnAddChangeRemision').click(function (){
       //alert("Articulo: "+code+"\nCantidad: "+quantity+"\nValor Unit: "+priceUnit+"\n");
       var cantSolicitada = $('#txbCantidadCambiar').val();
       var totalSolicitado = 0;
       totalSolicitado = parseFloat(cantSolicitada) * parseFloat(priceUnit.replace(",", ""));
       
       //totalSolicitado = (totalSolicitado * parseInt($('#txbHiddenIva').val()) / 100);
       
        var aux = parseFloat($('#txbHiddenTotalCambio').val()) + totalSolicitado;
       
        var newTotal = aux;
        $('#txbHiddenTotalCambio').attr('value', newTotal);
        var number = new String(newTotal);
        var result = '';

        while (number.length > 3)
        {
            result = ',' + number.substr(number.length - 3) + result;
            number = number.substring(0, number.length - 3);
        }

        result = number + result;        
       
       
       //**************************
        var newTotalA = totalSolicitado;        
        var numberA = new String(newTotalA);
        var resultA = '';

        while (numberA.length > 3)
        {
            resultA = ',' + numberA.substr(numberA.length - 3) + resultA;
            numberA = numberA.substring(0, numberA.length - 3);
        }

        resultA = numberA + resultA;
       
       //**************************
       
       $row = '<tr> <td>'+code+'</td> <td>'+name+'</td> <td class="tdDerecha">'+cantSolicitada+'</td> <td class="tdDerecha">'+priceUnit+'</td> <td class="tdDerecha">'+resultA+'</td><td class="tdNoVisible">'+color+'</td> </tr>'
       $('#tableChangeRemision').append($row);
       //var aiv =  result + (result * (parseInt($('#txbHiddenIva').val()) / 100));
       $('#h1Total').text("Total canjeable sin IVA: $ "+result);
       
      
       $('.contenidoDevueltas').fadeOut('fast');
       $('.detallesDevueltas').fadeOut('fast');
    });  
    
    $('#btnChangeFin').click(function (){
       var arr = [];
       var cont = 0;
       
       $('#tableChange tr').each(function () {
           if(cont > 0)
           {
               var cod = $(this).find("td").eq(0).html();
               var nom = $(this).find("td").eq(1).html();
               var cant = $(this).find("td").eq(2).html();            
               var puni = $(this).find("td").eq(3).html();  
               var ptot = $(this).find("td").eq(4).html();  
               var col = $(this).find("td").eq(5).html();
               
               cant = cant.replace(",", ""); 
               puni = puni.replace(",", ""); 
               ptot = ptot.replace(",", "");                
               arr[cont] = [cod,nom,cant,puni,ptot,col];               
           }
           cont++; 
        });
        
        //var datas = {a:{'foo':'bar'},b:{'this':'that'}};
            $.ajax({ url: '../../controllers/ctrlChange.php',
            type: 'POST',                                              
            data: {'datas':JSON.stringify(arr)},
            error: function(){
                alert("error petición ajax");
            },
            success: function(data){ 
                var idc = $('#ocultoDocCliente').val();
                document.location.href = "../../controllers/ctrlInsertBillChange.php?idc="+idc+"&cj="+data;            
            }
            });
    }); 
    
    $('#btnChangeFinRemision').click(function (){
       var arr = [];
       var cont = 0;
       
       $('#tableChangeRemision tr').each(function () {
           if(cont > 0)
           {
               var cod = $(this).find("td").eq(0).html();
               var nom = $(this).find("td").eq(1).html();
               var cant = $(this).find("td").eq(2).html();            
               var puni = $(this).find("td").eq(3).html();  
               var ptot = $(this).find("td").eq(4).html();  
               var col = $(this).find("td").eq(5).html();
              
               cant = cant.replace(",", ""); 
               puni = puni.replace(",", ""); 
               ptot = ptot.replace(",", "");                
               arr[cont] = [cod,nom,cant,puni,ptot,col];               
           }
           cont++; 
        });
        
        //var datas = {a:{'foo':'bar'},b:{'this':'that'}};
            $.ajax({ url: '../../controllers/ctrlChange.php',
            type: 'POST',                                              
            data: {'datas':JSON.stringify(arr)},
            error: function(){
                alert("error petición ajax");
            },
            success: function(data){ 
                var idc = $('#ocultoDocCliente').val();
                document.location.href = "../../controllers/ctrlInsertRemisionChange.php?idc="+idc+"&cj="+data;            
            }
            });
    }); 
    
    $('#txbRecibido').focusout(function (){
       var recibido = $('#txbRecibido').val().replace(",", "");     
       var total = $('#totalBill').val();
       $('#pMensajeDevuelta').text('Devuelta: $ '+(recibido-total));
       //alert(cantidadComprar+" - "+$('#totalBill').val());
    });
    
    
      
});
