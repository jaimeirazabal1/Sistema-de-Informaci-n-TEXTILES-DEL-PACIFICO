$(document).ready(function() {
    
    var consulta;

    //comprobamos si se pulsa una tecla
    $("#txa-lg").keyup(function(e) {
        
        consulta = "UPDATE remision SET REMISOBSER = '"+$("#txa-lg").val().toUpperCase()+"' WHERE REMISCODIG = "+$("#billNumberHidden").val();  
        
        //hace la búsqueda
        $.ajax({            
            type: "POST",            
            url: "../../models/UpdateObservationRemision.php",
            data: "b="+consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
            }
        });
    }); 
});