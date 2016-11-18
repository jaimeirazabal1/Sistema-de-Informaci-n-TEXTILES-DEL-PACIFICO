$(document).ready(function() {
    $('.contenidoBarcode').click(function (){
        $('.contenidoBarcode').fadeOut('fast');
        $('.detallesBarcode').fadeOut('fast');
    });
    
    var codeArticle;
    
    $('.imgBarcodeClass').click(function (){
        $('.contenidoBarcode').fadeIn('fast');
        $('.detallesBarcode').fadeIn('fast');
        id = $(this).attr("id");
        codeArticle = $('#td1'+id).text();
        $('#hiddenCodeArticle').attr('value', codeArticle);
        $("#bcTarget").barcode(codeArticle, "code128");
    });
    
    $('#btnSubmitBarcode').click(function (){
        $('.contenidoBarcode').fadeOut('fast');
        $('.detallesBarcode').fadeOut('fast');
    });
    
    
});






























