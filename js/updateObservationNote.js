$(document).ready(function() {
    
    var consulta;

    //comprobamos si se pulsa una tecla
    $("#txa-lg").keyup(function(e) {
        consulta = "UPDATE nota SET NOTAOBSER = '"+$("#txa-lg").val().toUpperCase()+"' WHERE NOTACODIG = "+$('#tdCodeNote').text();  
        
        //hace la búsqueda
        $.ajax({            
            type: "POST",            
            url: "../../models/UpdateObservationNote.php",
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