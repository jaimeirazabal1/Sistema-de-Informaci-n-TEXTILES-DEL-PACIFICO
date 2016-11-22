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
        <script src="../../js/Chart.js/Chart.js"></script>
        <script src="../../js/forms.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>Reporte Utilidad</title>
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
                <h1>Reporte de Utilidad</h1>
                
                <?php
                if($_POST)
                {?>
                    <form id="formReporteUtilidad" method="post">
                        <?php 
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$_POST['txbFechaInicio'].'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$_POST['txbFechaFin'].'">';
                        echo '<input id="btnConsultarUtilidad" type="submit" value="Consultar"><label> </label>';
                        echo '<input id="btnGenerarUtilidad" type="submit" value="Generar PDF">';                        
                        ?>
                    </form>    
                <?php
                }
                else
                {?>
                    <form id="formReporteUtilidad" method="post">
                        <?php 
                        $dateNow = date("Y-m-d");
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$dateNow.'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$dateNow.'">';
                        ?>
                        <input id="btnConsultarUtilidad" type="submit" value="Consultar"><label> </label>
                        <input id="btnGenerarUtilidad" type="submit" value="Generar PDF">
                    </form>
                <?php
                }
                ?>
                
            </section>
            
            <section class="contenido" id="contenidoGeneral2">                
                <div class="listado">                                        
                    
                            <?php
                            $sumTotalInventario = 0;
                            if($_POST)
                            {
                                $dateInicio = $_POST['txbFechaInicio'];
                                $dateFin = $_POST['txbFechaFin'];

                                if($dateFin>=$dateInicio){
                                
                                require '../../models/BillImpl.php'; 
                                require '../../models/DetailImpl.php';
                                require '../../models/StockImpl.php';
                                $objBillImpl = new BillImpl();
                                $objStockImpl = new StockImpl();

                                $sumTotalCredito = $objBillImpl->getSumPaymentCR($_POST['txbFechaInicio'], $_POST['txbFechaFin'], 'CR');
                                $sumTotalContado = $objBillImpl->getSumPaymentCO($_POST['txbFechaInicio'], $_POST['txbFechaFin'], 'CO');
                                $sumTotalIngresos = $sumTotalCredito + $sumTotalContado;
								$sumTotalCostos = $objStockImpl->getSumStockCosto($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
								$sumTotalGastos = $objBillImpl->getSumGastos($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
								$sumUtilidadOperativa = $sumTotalIngresos - $sumTotalCostos;
								$sumUtilidadPerdida = $sumUtilidadOperativa - $sumTotalGastos;


								$sumSubTotal = $sumTotalContado + $sumTotalIva + $sumTotalRemis;
								$sumTotalInventario = $objStockImpl->getSumStock($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
                               
                                ?>
                                                    
                                <form method="post">
                                <table>
                                    <tr>
                                        <th>DETALLE</th>
                                        <th>VALORES</th>
                                    </tr>
                            
                                <?php
                                echo '<input type="hidden" id="sumInvtrHidden" value="'.$sumTotalInventario.'">';
                                echo '<input type="hidden" id="sumRemisionHidden" value="'.$sumSubTotal.'">';                                        
                                
                                echo '<tr>
                                        <td>INGRESOS</td>
                                        <td class="tdDerecha">'.number_format($sumTotalIngresos,0).'</td>
                                    </tr>';                                
                                echo '<tr>
                                        <td class="tdDerecha">Ventas Credito</td>
                                        <td class="tdDerecha">'.number_format($sumTotalCredito,0).'</td>
                                    </tr>'; 
                                echo '<tr>
                                        <td class="tdDerecha">Ventas Contado</td>
                                        <td class="tdDerecha">'.number_format($sumTotalContado,0).'</td>
                                    </tr>'; 
                                echo '<tr>
                                        <td>- COSTOS</td>
                                        <td class="tdDerecha">'.number_format($sumTotalCostos,0).'</td>
                                    </tr>';
                                echo '<tr>
                                        <td>UTILIDAD OPERATIVA</td>
                                        <td class="tdDerecha">'.number_format($sumUtilidadOperativa,0).'</td>
                                    </tr>';
                                echo '<tr>
                                        <td>- GASTOS</td>
                                        <td class="tdDerecha">'.number_format($sumTotalGastos,0).'</td>
                                    </tr>';
                                echo '<tr id="trColor">
                                        <td>UTILIDAD o PERDIDA NETA</td>
                                        <td class="tdDerecha">'.number_format($sumUtilidadPerdida,0).'</td>
                                    </tr>';
                                ?>
                                        
                                </table>
                                </form>  
                   
                    <?php
                    if($sumTotalInventario > 0 && $sumSubTotal > 0)
                    {?>
                    
                    <br><br>
                    <h1>Utilidad = Ingresos - Gastos - Costos</h1>
                    <br>
                        
                    <?php
                    }
                    ?>
                    
                </script>
                    
                            <?php        
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