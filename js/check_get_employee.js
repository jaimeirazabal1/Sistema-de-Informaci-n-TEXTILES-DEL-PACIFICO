$(document).ready(function(){
         
      var consulta;
             
      //hacemos focus
      $("#txbCodeEmployee").focus();
                                                 
      //comprobamos si se pulsa una tecla
      $("#txbCodeEmployee").keyup(function(e){  
        //obtenemos el texto introducido en el campo
        consulta = $("#txbCodeEmployee").val();
        
        
        $.ajax({
            type: "POST",
            url: "../../models/CheckGetEmployee.php",
            data: "b="+consulta,
            dataType: "html",
            error: function(){
                alert("error petición ajax");
            },
            success: function(data){
                if(data !== "")
                {
                    $("#txbNameEmployee").val(data);                
                    //$("#txbCode").focus();
                    n();
                }
                else
                {
                    $("#txbNameEmployee").val(data);                
                    n();
                }
                    
            }
        });
    });    
});