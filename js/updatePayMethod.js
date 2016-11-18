$(document).ready(function() {
    
    var consulta, billNumber, tipo;

    //comprobamos si se pulsa una tecla
    $("#selectPaymentBill").change(function(e) {
        
        tipo = $("#selectPaymentBill").attr('class');
        
        if(tipo === 'fa')
            consulta = "UPDATE factura SET FACTUFORPA = '"+$("#selectPaymentBill").val()+"' WHERE FACTUCODIG = "+$("#billNumberHidden").val();  
        else if(tipo === 're')
            consulta = "UPDATE remision SET REMISFORPA = '"+$("#selectPaymentBill").val()+"' WHERE REMISCODIG = "+$("#billNumberHidden").val();  
        
        if($("#selectPaymentBill").val() === 'CR'){
            $("#selectPaymentBill").attr('disabled', 'disabled');
        }
        
        //hace la búsqueda
        $.ajax({            
            type: "POST",            
            url: "../../models/UpdatePayMethod.php",
            data: "b="+consulta+"&idc="+$("#txbCodeClient").val()+"&idf="+$("#txbCode").val()+"&val="+$("#txbValueSale").val()+"&user="+$("#userHidden").val()+"&pay="+$("#selectPaymentBill").val()+"&type="+$("#typeHidden").val(),
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
//                $("#pago").empty();                
//                $("#pago").append(data);
            }
        });
    }); 
});