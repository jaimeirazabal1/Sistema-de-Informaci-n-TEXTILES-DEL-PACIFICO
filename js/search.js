$(document).ready(function() {
    
    var consulta;

    //comprobamos si se pulsa una tecla
    $("#txbSearchClient").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchClient").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchClient.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });
    
    
    //comprobamos si se pulsa una tecla
    $("#txbSearchClientCollect").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchClientCollect").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchClientCollect.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });
    
    $("#txbSearchConceptos").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchConceptos").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchConcepto.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });
    
    $("#txbSearchTypeClient").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchTypeClient").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchTypeClient.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });
    
    $("#txbSearchStock").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchStock").val();

        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13') {//entra si presiona enter
        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchStock.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
        }
    });
    
    $("#txbSearchStockBill").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchStockBill").val();
        
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13') {//entra si presiona enter
        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchStockBill.php",
            data: "b=" + consulta+"&id=" + $("#txbCode").val(),
            
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listadoStockBill").empty();
                $(".listadoStockBill").append(data);
            }
        });
        }
    });
    
    $("#txbSearchRemisionNotes").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchRemisionNotes").val();
        
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13') {//entra si presiona enter
        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchRemisionNotes.php",
            data: "b=" + consulta+"&id=" + $("#txbCode").val(),
            
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listadoRemisionRemision").empty();
                $(".listadoRemisionRemision").append(data);
            }
        });
        }        
        
    });
    
    $("#txbSearchCxpNotes").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchCxpNotes").val();
        
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13') {//entra si presiona enter
        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchCxpNotes.php",
            data: "b=" + consulta+"&id=" + $("#txbCode").val(),
            
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listadoCxpCxp").empty();
                $(".listadoCxpCxp").append(data);
            }
        });
        }        
        
    });
    
    $("#txbSearchStockRemision").keyup(function(e) {
        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchStockRemision").val();
        
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13') {//entra si presiona enter
            
        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchStockRemision.php",
            data: "b=" + consulta+"&id=" + $("#txbCode").val(),
            
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listadoStockRemision").empty();
                $(".listadoStockRemision").append(data);
            }
        });
        }
    });
    
    $("#txbSearchBill").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchBill").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchBill.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });
    
    $("#txbSearchRemision").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchRemision").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchRemision.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });
    
    $("#txbSearchCxp").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchCxp").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchCxp.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });
    
    $("#txbSearchBillChange").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchBillChange").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchBillChange.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });
    
    $("#txbSearchColor").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchColor").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchColor.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });
    
    $("#txbSearchSystem").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchSystem").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchSystem.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });
    
    $("#txbSearchSpend").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchSpend").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchSpend.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });
    
    $("#txbSearchNote").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchNote").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchNote.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });
    
    $("#txbSearchBillNotes").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchBillNotes").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchBillNotes.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listadoBillBill").empty();
                $(".listadoBillBill").append(data);
            }
        });
    });
    
    $("#txbSearchCollect").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchCollect").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchCollect.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });
    
    $("#txbSearchCreditCollect").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchCreditCollect").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchClientCollect.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listadoCreditBill").empty();
                $(".listadoCreditBill").append(data);
            }
        });
    });
    
    $("#txbSearchCollectCxp").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchCollectCxp").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchCollectCxp.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });
    
    $("#txbSearchCxpInCollect").keyup(function(e) {
        
        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchCxpInCollect").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchCxpInCollect.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listadoCreditBill").empty();
                $(".listadoCreditBill").append(data);
            }
        });
    });

});