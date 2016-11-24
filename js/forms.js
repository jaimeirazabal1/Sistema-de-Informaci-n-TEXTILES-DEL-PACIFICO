
$(document).ready(function () {
    $("#btnConsultarInventario").click(function () {
        $('#formReporteInventario').attr('action', "stock.php");        
        $('#formReporteInventario').removeAttr('target');
    });
    $("#btnGenerarInventario").click(function () {
        $('#formReporteInventario').attr('action', "../../controllers/ctrlPrintInventario.php");
        $('#formReporteInventario').attr('target', "_blank");
    });
    
    
    $("#btnConsultarAlgodon").click(function () {
        $('#formReporteAlgodon').attr('action', "algodon.php");        
        $('#formReporteAlgodon').removeAttr('target');
    });
    $("#btnGenerarAlgodon").click(function () {
        $('#formReporteAlgodon').attr('action', "../../controllers/ctrlPrintAlgodon.php");
        $('#formReporteAlgodon').attr('target', "_blank");
    });

    $("#btnConsultarGastos2").click(function () {
        $('#formReporteGastos2').attr('action', "gastos.php");        
        $('#formReporteGastos2').removeAttr('target');
    });
    $("#btnGenerarGastos2").click(function () {
        $('#formReporteGastos2').attr('action', "../../controllers/ctrlPrintGastos.php");
        $('#formReporteGastos2').attr('target', "_blank");
    });
    $("#btnGenerarPdfMovimientoCarteraCliente").click(function () {
        $('#formMovimientoCarteraCliente').attr('action', "../../controllers/ctrlPrintMovimientoCarteraCliente.php");
        $('#formMovimientoCarteraCliente').attr('target', "_blank");
    });        
    
    $("#btnConsultarRayas").click(function () {
        $('#formReporteRayas').attr('action', "rayas.php");        
        $('#formReporteRayas').removeAttr('target');
    });
    $("#btnGenerarRayas").click(function () {
        $('#formReporteRayas').attr('action', "../../controllers/ctrlPrintRayas.php");
        $('#formReporteRayas').attr('target', "_blank");
    });
    
    
    $("#btnConsultarViscosa").click(function () {
        $('#formReporteViscosa').attr('action', "viscosa.php");        
        $('#formReporteViscosa').removeAttr('target');
    });
    $("#btnGenerarViscosa").click(function () {
        $('#formReporteViscosa').attr('action', "../../controllers/ctrlPrintViscosa.php");
        $('#formReporteViscosa').attr('target', "_blank");
    });
    
    
    $("#btnConsultarEsmerilada").click(function () {
        $('#formReporteEsmerilada').attr('action', "esmerilada.php");        
        $('#formReporteEsmerilada').removeAttr('target');
    });
    $("#btnGenerarEsmerilada").click(function () {
        $('#formReporteEsmerilada').attr('action', "../../controllers/ctrlPrintEsmerilada.php");
        $('#formReporteEsmerilada').attr('target', "_blank");
    });
    
    
    $("#btnVentasAlgodon").click(function () {
        $('#formVentasAlgodon').attr('action', "ventasalgodon.php");        
        $('#formVentasAlgodon').removeAttr('target');
    });
    $("#btnGenerarVentasAlgodon").click(function () {
        $('#formVentasAlgodon').attr('action', "../../controllers/ctrlPrintVentasAlgodon.php");
        $('#formVentasAlgodon').attr('target', "_blank");
    });
    
    
    $("#btnVentasRayas").click(function () {
        $('#formVentasRayas').attr('action', "ventasrayas.php");        
        $('#formVentasRayas').removeAttr('target');
    });
    $("#btnGenerarVentasRayas").click(function () {
        $('#formVentasRayas').attr('action', "../../controllers/ctrlPrintVentasRayas.php");
        $('#formVentasRayas').attr('target', "_blank");
    });
    
    
    $("#btnVentasViscosa").click(function () {
        $('#formVentasViscosa').attr('action', "ventasviscosa.php");        
        $('#formVentasViscosa').removeAttr('target');
    });
    $("#btnGenerarVentasViscosa").click(function () {
        $('#formVentasViscosa').attr('action', "../../controllers/ctrlPrintVentasViscosa.php");
        $('#formVentasViscosa').attr('target', "_blank");
    });
    
    
    $("#btnConsultarRecaudos").click(function () {
        $('#formReporteRecaudos').attr('action', "recaudos.php");        
        $('#formReporteRecaudos').removeAttr('target');
    });
    $("#btnGenerarRecaudos").click(function () {
        $('#formReporteRecaudos').attr('action', "../../controllers/ctrlPrintRecaudos.php");
        $('#formReporteRecaudos').attr('target', "_blank");
    });
    
    
    $("#btnConsultarStockArticulo").click(function () {
        $('#formReporteStockArticle').attr('action', "article.php");        
        $('#formReporteStockArticle').removeAttr('target');
    });
    $("#btnGenerarStockArticulo").click(function () {
        $('#formReporteStockArticle').attr('action', "../../controllers/ctrlPrintStockArticle.php");
        $('#formReporteStockArticle').attr('target', "_blank");
    });
    
    
    $("#btnConsultarMovimArticulo").click(function () {
        $('#formReporteMovimArticle').attr('action', "movimientos.php");        
        $('#formReporteMovimArticle').removeAttr('target');
    });
    $("#btnGenerarMovimArticulo").click(function () {
        $('#formReporteMovimArticle').attr('action', "../../controllers/ctrlPrintMovimArticle.php");
        $('#formReporteMovimArticle').attr('target', "_blank");
    });


    $("#btnConsultarRemision").click(function () {
        $('#formReporteRemision').attr('action', "bill.php");        
        $('#formReporteRemision').removeAttr('target');
    });
    $("#btnGenerarRemision").click(function () {
        $('#formReporteRemision').attr('action', "../../controllers/ctrlPrintRemision.php");
        $('#formReporteRemision').attr('target', "_blank");
    });
    
    
    $("#btnConsultarUtilidad").click(function () {
        $('#formReporteUtilidad').attr('action', "utility.php");        
        $('#formReporteUtilidad').removeAttr('target');
    });    
    $("#btnGenerarUtilidad").click(function () {
        $('#formReporteUtilidad').attr('action', "../../controllers/ctrlPrintUtilidad.php");
        $('#formReporteUtilidad').attr('target', "_blank");
    });
    
    
    $("#btnConsultarArqueo").click(function () {
        $('#formReporteArqueo').attr('action', "arqueocaja.php");        
        $('#formReporteArqueo').removeAttr('target');
    });    
    $("#btnGenerarArqueo").click(function () {
        $('#formReporteArqueo').attr('action', "../../controllers/ctrlPrintArqueo.php");
        $('#formReporteArqueo').attr('target', "_blank");
    });
    
    $("#btnGenerarArqueoDetallado").click(function () {
        $('#formReporteArqueo').attr('action', "../../controllers/ctrlPrintArqueoDetallado.php");
        $('#formReporteArqueo').attr('target', "_blank");
    });
        
    $("#btnConsultarEstadoCuenta").click(function () {
        $('#formReporteEstadoCuenta').attr('action', "state_account.php");        
        $('#formReporteEstadoCuenta').removeAttr('target');
    });    
    $("#btnGenerarEstadoCuenta").click(function () {
        $('#formReporteEstadoCuenta').attr('action', "../../controllers/ctrlPrintStateAccount.php");
        $('#formReporteEstadoCuenta').attr('target', "_blank");
    });
    
    
    $("#btnConsultarEstadoCuentaResumen").click(function () {
        $('#formReporteEstadoCuentaResumen').attr('action', "state_account_resumen.php");        
        $('#formReporteEstadoCuentaResumen').removeAttr('target');
    });    
    $("#btnGenerarEstadoCuentaResumen").click(function () {
        $('#formReporteEstadoCuentaResumen').attr('action', "../../controllers/ctrlPrintStateAccountResumen.php");
        $('#formReporteEstadoCuentaResumen').attr('target', "_blank");
    });
    
    
    $("#btnConsultarGastos").click(function () {
        $('#formReporteGastos').attr('action', "spend.php");        
        $('#formReporteGastos').removeAttr('target');
    });    
    $("#btnGenerarGastos").click(function () {
        $('#formReporteGastos').attr('action', "../../controllers/ctrlPrintSpend.php");
        $('#formReporteGastos').attr('target', "_blank");
    });

    
    $("#btnConsultarEstadoCuentaGeneral").click(function () {
        $('#formReporteEstadoCuentaGeneral').attr('action', "state_account_general.php");        
        $('#formReporteEstadoCuentaGeneral').removeAttr('target');
    });    
    $("#btnGenerarEstadoCuentaGeneral").click(function () {
        $('#formReporteEstadoCuentaGeneral').attr('action', "../../controllers/ctrlPrintStateAccountGeneral.php");
        $('#formReporteEstadoCuentaGeneral').attr('target', "_blank");
    });

    
    $("#btnGenerarCodebars").click(function () {
        $('#formReportCodebar').attr('action', "../../controllers/ctrlPrintCodebar.php");
        $('#formReportCodebar').attr('target', "_blank");
    });
    
    
    $("#btnConsultarSeller").click(function () {
        $('#formReporteSeller').attr('action', "seller.php");        
        $('#formReporteSeller').removeAttr('target');
    });    
    $("#btnGenerarSeller").click(function () {
        $('#formReporteSeller').attr('action', "../../controllers/ctrlPrintSeller.php");
        $('#formReporteSeller').attr('target', "_blank");
    });
    
    $("#btnConsultarKardex").click(function () {
        $('#formReporteKardex').attr('action', "kardex.php");        
        $('#formReporteKardex').removeAttr('target');
    });    
    $("#btnGenerarKardex").click(function () {
        $('#formReporteKardex').attr('action', "../../controllers/ctrlPrintKardex.php");
        $('#formReporteKardex').attr('target', "_blank");
    });
    
});