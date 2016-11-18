<?php
session_start();

include '../../com/server.php';
$server = new SimpleXMLElement($xmlstr);
$ip = $server->server[0]->ip;

if (!empty($_SESSION['userCode']) && !empty($_SESSION['userName']))
{
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../../css/style.css" rel="stylesheet">
        <link rel="icon" href="../../res/favicon.png" type="image/png" sizes="16x16">
        <script src="../../js/jquery/jquery.js"></script>
        <script src="../../js/forms.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <script type="text/javascript" src="../../js/jquery.tablesorter/jquery.tablesorter.js"></script> 
        <script type="text/javascript" src="../../js/controls.js"></script>         
        <script type="text/javascript" src="../../js/jquery.price_format.2.0.min.js"></script>
        <script type="text/javascript" src="../../js/price_format.js"></script>

                <script type="text/javascript" src="../../js/jsPDF-master/dist/jspdf.debug.js"></script>
        <script type="text/javascript" src="../../js/jsPDF-master/examples/js/basic.js"></script>
        <title>Reporte Inventario</title>
    </head>
    <body>
        <section class="contenedor">
            <header>
                <div class="menuImg"></div><div class="logoEmpresa">
                    </div><div class="sesion">
                        Salir<a href="../../controllers/ctrlLogout.php"><img src="../../res/logout-24.png"></a>
                    </div>                    
                <div class="contenedorRutaApp">
                    <div class="nombreAplicacion">
                        <a href="../../">Sistema de Información TEXTILES DEL PACIFICO </a>                        
                    </div><div class="arrowImgRight">
                        <img src="../../res/arrow-25-16.png">
                    </div><div class="opcionSeleccionada">
                        Reportes
                    </div>
                </div>
            </header>
            <nav id="menu">
                <ul>                    
                    <li><a href="../../views/config/"><img src="../../res/settings-4-16.png">Parámetros</a></li>
                    <li><a href="../../views/clients/"><img src="../../res/guest-16.png">Clientes</a></li>
                    <li><a href="../../views/stock/"><img src="../../res/list-ingredients-16.png">Inventario</a></li>
                    <li><a href="../../views/remision"><img src="../../res/invoice-16.png">Remisión</a></li>
                    <li><a href="../../views/collect/"><img src="../../res/cash-receiving-16.png">Recaudos</a></li>                                       
                    <li><a href="../../views/notes/"><img src="../../res/paper-16.png">Notas</a></li> 
                    <li><a href="../../views/cxp/"><img src="../../res/document-2-16.png">Cuentas por Pagar</a></li> 
                    <li><a href="../../views/spend/"><img src="../../res/banknotes-16.png">Gastos</a></li> 
                    <li><a href="../../views/reports/"><img src="../../res/line-16.png">Reportes</a></li> 
                </ul>
            </nav>
            
            <section class="contenido" id="contenidoGeneral2">
                <h1>Reporte de Movimientos Kardex</h1>
                <script type="text/javascript">
                function demoFromHTML() {
                        $("td:hidden,th:hidden",".table_to_pdf").show();
                    var pdf = new jsPDF('l', 'pt', 'a4');
                    
                     pdf.cellInitialize();
                    pdf.setFontSize(10);
                    $.each( $('.table_to_pdf tr'), function (i, row){
                        $.each( $(row).find("td, th"), function(j, cell){
                             var txt = $(cell).text().trim().split(" ").join("\n") || " ";
                            if ($(cell).prop("tagName") == "TH") {
                                $(cell).css("backgroundColor","grey")
                            }
                             var width = (j==0) ? 70 : 45; //make with column smaller
                             //var height = (i==0) ? 40 : 30;
                             pdf.cell(10, 50, 80, 50, txt, i);
                        });
                    });
                        pdf.save('Reporte de Movimientos Kardex.pdf');

                }
            </script>
                <?php
                if($_POST)
                {?>
                    <form id="formReporteKardex" method="post">
                        <?php 
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$_POST['txbFechaInicio'].'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$_POST['txbFechaFin'].'">';
                        echo '<input id="txbReferencia" required name="txbReferencia" type="text" placeholder="REFERENCIA" value="'.$_POST['txbReferencia'].'">';
                        ?>                        
                        <input id="btnConsultarKardex" type="submit" value="Consultar">
                        <input id="btnGenerarKardex" type="button" value="Generar PDF" onclick="demoFromHTML();return false;">
                    </form>    
                <?php
                }
                else
                {?>
                    <form id="formReporteKardex" method="post">
                        <?php 
                        $dateNow = date("Y-m-d");
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$dateNow.'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$dateNow.'">';
                        ?>
                        <input id="txbReferencia" name="txbReferencia" required type="text" placeholder="REFERENCIA">                        
                        <input id="btnConsultarKardex" type="submit" value="Consultar">
                        <input id="btnGenerarKardex" type="button" value="Generar PDF" onclick="demoFromHTML();return false;">
                    </form>
                <?php
                }
                ?>                
            </section>
            
            <section class="contenido" id="contenidoGeneral2">                
                <div class="listado">                                      
                    <?php
                    if($_POST)
                    {
                        $dateInicio = $_POST['txbFechaInicio'];
                        $dateFin = $_POST['txbFechaFin'];
                        
                        if($dateFin>=$dateInicio){
                            require_once '../../models/StockImpl.php';
                            require_once '../../models/SystemImpl.php';
                            $objStockImpl = new StockImpl();

//                            if ($objStockImpl->getCountByAlmacenBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia'], $_POST['selectColor']) > 0)
                            if ($objStockImpl->getCountByAlmacenBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia']) > 0)
                            {
                                $totalCostoInventario = 0;
                            ?>
                                <!--HEAD-->
                                <form method="post">
                                <table>
                                    <tr>
                                        <th>REFERENCIA</th>
                                        <th>ARTICULO</th>
                                        <th>CANTIDAD INICIAL</th>
                                        <th>COSTO</th>
                                    </tr>                                     
                                    
                                <?php
                                
                                $objSystemImpl = new SystemImpl();
                                
                                foreach ($objStockImpl->getByAlmacenBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia'], $_POST['selectColor']) as $valorStock) {
                                    
                                    foreach ($objStockImpl->getFirstQuantityAvailableBetweenDate($valorStock->getCode(),$_POST['txbFechaInicio'], $_POST['txbFechaFin'],  $valorStock->getColor()) as $valFirst){
                                        $firstQuantityAvailable = $valFirst->getQuantity();
                                        $firstPriceBuy = $valFirst->getPriceBuy();
                                    }                                    
                                    
                                    echo '<tr>
                                        <td>'.$valorStock->getCode().'</td>
                                        <td>'.$valorStock->getName().'</td>
                                        <td class="tdDerecha">'.$firstQuantityAvailable.'</td>
                                        <td class="tdDerecha">'.number_format($firstQuantityAvailable * $firstPriceBuy).'</td>
                                        </tr>';
                                }                                 
                                ?>
                                </table>
                                <!--END HEAD-->
                                
                                <div class="jump"></div>    
                                
                                <!--BODY-->    
                                <table id="myTable" class="tablesorter table_to_pdf">
                                    <thead>                                
                                    <tr>
                                        <th class="tdColor color-black">DOCUMENTO</th>
                                        <th class="tdColor color-black" id="tdDate">FECHA</th>
                                        <th class="tdColor color-black">ENTRADA</th>                                        
                                        <th class="tdColor color-black">SALIDA</th>     
                                        <th class="tdColor color-black">SALDO KGS</th>
                                        <th class="tdColor color-black">COSTO UNITARIO</th>
                                        <th class="tdColor color-black">COSTO ENTRADA</th>
                                        <th class="tdColor color-black">COSTO SALIDA</th>     
                                        <th class="tdColor color-black">SALDO EN PESOS</th>
                                    </tr>                                         
                                    </thead>
                                    <tbody>
                                <?php
                                require_once '../../models/DetailCxpImpl.php';
                                $objDetailCxpImpl = new DetailCxpImpl();
                                require_once '../../models/NoteDetailImpl.php';
                                $objNoteDetailImpl = new NoteDetailImpl();
                                
                                $totalSaldo = 0;
                                $totalSaldoPesos = 0;
                                $totalEntradas = 0;
                                $totalSalidas = 0;  
                                $totalCosoEntradas = 0;
                                $totalCostoSalidas = 0;
                                $ultimoPrecioCosto = $objStockImpl->getLastPriceSold($_POST['txbReferencia'], null);
                                
                                $contSD = 1;
//                              echo  '<script>console.log("ahi va")</script>';
                                
                                //ENTRADAS SIN DOCUMENTO
                                foreach ($objStockImpl->getWithoutDocument($_POST['txbReferencia']) as $valorSD) {
                                    $totalSaldo += $valorSD->getQuantity();
                                    $totalSaldoPesos += ($valorSD->getPriceBuy()*$valorSD->getQuantity());
                                    
                                    echo '<tr class="tr-report">
                                        <td>SD-'.$contSD.'</td>
                                        <td>'.$valorSD->getMoveDate().'</td>
                                        <td class="tdDerecha">'.$valorSD->getQuantity().'</td>
                                        <td class="tdDerecha">0</td>
                                        <td class="tdDerecha">'.number_format($totalSaldo,2).'</td>
                                        <td class="tdDerecha">'.number_format($valorSD->getPriceBuy()).'</td>
                                        <td class="tdDerecha">'.number_format($valorSD->getQuantity() * $valorSD->getPriceBuy()).'</td>
                                        <td class="tdDerecha">0</td>
                                        <td class="tdDerecha cantExample">'.number_format($totalSaldoPesos).'</td>
                                        </tr>';
                                    
                                    $contSD++;
                                    $totalEntradas += $valorSD->getQuantity();  
                                    $totalCostoEntradas += ($valorSD->getPriceBuy() * $valorSD->getQuantity());
                                }
                                //-----------------------------------------------------------------                                
                                //ENTRADAS POR PAGAR
                                foreach ($objDetailCxpImpl->getByCodeBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia']) as $valorDCXP) {
                                    $totalSaldo += $valorDCXP->getCantidad();
                                    $totalSaldoPesos += ($valorDCXP->getValorUnitario()*$valorDCXP->getCantidad());
                                   
                                    echo '<tr class="tr-report">
                                        <td>CXP-'.$valorDCXP->getCodeCxp().'</td>
                                        <td>'.$valorDCXP->getFechaCreacion().'</td>
                                        <td class="tdDerecha">'.$valorDCXP->getCantidad().'</td>
                                        <td class="tdDerecha">0</td>
                                        <td class="tdDerecha">'.number_format($totalSaldo,2).'</td>
                                        <td class="tdDerecha">'.number_format($valorDCXP->getValorUnitario()).'</td>
                                        <td class="tdDerecha">'.number_format($valorDCXP->getValorUnitario() * $valorDCXP->getCantidad()).'</td>
                                        <td class="tdDerecha">0</td>
                                        <td class="tdDerecha cantExample">'.number_format($totalSaldoPesos).'</td>
                                        </tr>';
                                    $totalEntradas += $valorDCXP->getCantidad();  
                                    $totalCostoEntradas += ($valorDCXP->getValorUnitario() * $valorDCXP->getCantidad());
                                }
                                //-----------------------------------------------------------------                                
                                //NOTAS CREDITO DEVOL DEL CLIENTE AL INVENTARIO
                                foreach ($objNoteDetailImpl->getByCodeBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia'], 'CR') as $valorNTC) {
                                    $totalSaldo += $valorNTC->getDevolucion();
                                    $totalSaldoPesos += ($ultimoPrecioCosto*$valorNTC->getDevolucion());
                                   
                                    echo '<tr class="tr-report">
                                        <td>NTC-'.$valorNTC->getCode().'</td>
                                        <td>'.$valorNTC->getDate().'</td>
                                        <td class="tdDerecha">'.$valorNTC->getDevolucion().'</td>
                                        <td class="tdDerecha">0</td>
                                        <td class="tdDerecha">'.number_format($totalSaldo,2).'</td>
                                        <td class="tdDerecha">'.number_format($ultimoPrecioCosto).'</td>
                                        <td class="tdDerecha">'.number_format($ultimoPrecioCosto * $valorNTC->getDevolucion()).'</td>
                                        <td class="tdDerecha">0</td>
                                        <td class="tdDerecha cantExample">'.number_format($totalSaldoPesos).'</td>
                                        </tr>';
                                    $totalEntradas += $valorNTC->getDevolucion();  
                                    $totalCostoEntradas += ($ultimoPrecioCosto * $valorNTC->getDevolucion());
                                }
                                //-----------------------------------------------------------------                                
                                //NOTAS DEBITO DEVOL AL PROVEDOR SALIDA DEL INVENTARIO
                                foreach ($objNoteDetailImpl->getByCodeBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia'], 'DE') as $valorNTD) {
                                    $totalSaldo -= $valorNTD->getDevolucion();
                                    $totalSaldoPesos -= ($ultimoPrecioCosto*$valorNTD->getDevolucion());
                                   
                                    echo '<tr class="tr-report">
                                        <td>NTD-'.$valorNTD->getCode().'</td>
                                        <td>'.$valorNTD->getDate().'</td>
                                        <td class="tdDerecha">0</td>    
                                        <td class="tdDerecha">'.$valorNTD->getDevolucion().'</td>                                        
                                        <td class="tdDerecha">'.number_format($totalSaldo,2).'</td>
                                        <td class="tdDerecha">'.number_format($ultimoPrecioCosto).'</td>
                                        <td class="tdDerecha">0</td>
                                        <td class="tdDerecha">'.number_format($ultimoPrecioCosto * $valorNTD->getDevolucion()).'</td>
                                        <td class="tdDerecha cantExample">'.number_format($totalSaldoPesos).'</td>
                                        </tr>';
                                    $totalSalidas += $valorNTD->getDevolucion();
                                    $totalCostoSalidas += ($ultimoPrecioCosto * $valorNTD->getDevolucion());                                    
                                }
                                
                                require_once '../../models/DetailRemisionImpl.php';
                                $objDetailRemisionImpl = new DetailRemisionImpl();
                                
                                //SALIDAS
                                foreach ($objDetailRemisionImpl->getByCodeBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia']) as $valorDR) {
                                    $totalSaldo -= $valorDR->getQuantity();
                                    $totalSaldoPesos -= ($ultimoPrecioCosto*$valorDR->getQuantity());
                                    
                                    echo '<tr class="tr-report">
                                        <td>REM-'.$valorDR->getCodeRemision().'</td>
                                        <td>'.$valorDR->getMoveDate().'</td>
                                        <td class="tdDerecha">0</td>   
                                        <td class="tdDerecha">'.$valorDR->getQuantity().'</td>                                        
                                        <td class="tdDerecha">'.number_format($totalSaldo,2).'</td>
                                        <td class="tdDerecha">'.number_format($ultimoPrecioCosto).'</td>
                                        <td class="tdDerecha">0</td>    
                                        <td class="tdDerecha">'.number_format($ultimoPrecioCosto * $valorDR->getQuantity()).'</td>                                        
                                        <td class="tdDerecha cantExample">'.number_format($totalSaldoPesos).'</td>
                                        </tr>';                                    
                                    $totalSalidas += $valorDR->getQuantity();
                                    $totalCostoSalidas += ($ultimoPrecioCosto * $valorDR->getQuantity());
                                }
                                echo '</tbody>';
                                
                                echo '<tr>
                                        <td></td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($totalEntradas,2,".",",").'</td>
                                        <td class="tdDerecha">'.number_format($totalSalidas,2,".",",").'</td>
                                        <td class="tdDerecha">'.number_format(($totalEntradas-$totalSalidas),2,".",",").'</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($totalCostoEntradas,2,".",",").'</td>
                                        <td class="tdDerecha">'.number_format($totalCostoSalidas,2,".",",").'</td>
                                        <td class="tdDerecha">'.number_format(($totalCostoEntradas-$totalCostoSalidas),2,".",",").'</td>
                                        </tr>'; 
                                ?>
                                
                                
                                </table>
                                <!--END BODY-->        
                                    
                                <div class="jump"></div>    
                                </form> 
                            <?php
                            }
                            else {
                                echo '<script>alertify.error("No se encontraron registros");</script>';                                
                            }
                        
                        }
                        else
                        {
                            echo '<script>alertify.error("La fecha final debe ser mayor que la fecha inicial");</script>';
                        }
                    }
                    ?>                          
                         
                </div>
            </section>
            <footer>
                <div class="contenedorRutaSoporte">
                    <div class="opcionSeleccionadaSoporte">
                        TEXTILES DEL PACIFICO
                    </div><div class="arrowImgLeft">
                        <img src="../../res/arrow-89-16.png">
                    </div><div class="nombreDesarrollador">
                        Soporte y Desarrollo
                    </div>
                </div>
                <div class="franjaGris"></div>
                <div class="franjaAzul"></div>       
            </footer>
        </section>
    </body>
</html>

<?php
}
else
{
    echo '<script>document.location.href = "http://'.$ip.'/tp/login.php"; </script>';    
}
?>