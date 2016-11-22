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
        <script type="text/javascript" src="../../js/DataTables-1.10.12/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){

                });
        </script>
        <title>Arqueo de Caja</title>
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
                <h1>Arqueo de Caja</h1>
                
                <?php
                if($_POST)
                {?>
                    <form id="formReporteArqueo" method="post">
                        <?php 
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$_POST['txbFechaInicio'].'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$_POST['txbFechaFin'].'">';
                        echo '<input id="btnConsultarArqueo" type="submit" value="Consultar"><label> </label>';
                        echo '<input id="btnGenerarArqueo" type="submit" value="Generar PDF">';                        
                        ?>
                    </form>    
                <?php
                }
                else
                {?>
                    <form id="formReporteArqueo" method="post">
                        <?php 
                        $dateNow = date("Y-m-d");
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$dateNow.'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$dateNow.'">';
                        ?>
                        <input id="btnConsultarArqueo" type="submit" value="Consultar"><label> </label>
                        <input id="btnGenerarArqueo" type="submit" value="Generar PDF">
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
                                
                                require '../../models/BillImpl.php'; 
                                $objBillImpl = new BillImpl();

                                $sumTotalRecaudos = $objBillImpl->getSumRecaudos($_POST['txbFechaInicio'], $_POST['txbFechaFin'], 'CO');
                                $sumTotalContado = $objBillImpl->getSumPaymentCO($_POST['txbFechaInicio'], $_POST['txbFechaFin'], 'CO');
                                $sumTotalCredito = $objBillImpl->getSumPaymentCR($_POST['txbFechaInicio'], $_POST['txbFechaFin'], 'CR');
                                $sumSaldoCxP = $objBillImpl->getSumSaldoCxP($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
								$sumTotalGastos = $objBillImpl->getSumGastos($_POST['txbFechaInicio'], $_POST['txbFechaFin']);

                                $sumTotalIngresos = $sumTotalRecaudos + $sumTotalContado;
                                $sumTotalEgresos = $sumSaldoCxP + $sumTotalGastos;

                                $sumSaldos = $sumTotalIngresos - $sumTotalEgresos;
                               
                                ?>
                                                    
                                <form method="post">
                                <table>
                                    <tr>
                                        <th>DETALLE</th>
                                        <th>INGRESOS</th>
                                        <th>EGRESOS</th>                                        
                                    </tr>
                                </table>
                                <?php
                                
                                echo '<table><tr>
                                        <td>RECAUDOS</td>
                                        <td class="tdDerecha">'.number_format($sumTotalRecaudos,0).'</td>
                                        <td></td>
                                    </tr></table>';
                                ?>
                                
                                        <table class="datatable">
                                            <thead>
                                                <th><?php echo strtoupper("CÓdigo de Recaudo") ?></th>
                                                <th><?php echo strtoupper("CÓdigo de CrÉdito") ?></th>
                                                <th><?php echo strtoupper("IdentificaciÓn del cliente") ?></th>
                                                <th><?php echo strtoupper("Nombre del Cliente") ?></th>
                                                <th><?php echo strtoupper("Valor Recaudo") ?></th>
                                                <th ><?php echo strtoupper("Fecha Recaudo") ?></th>
                                                <th width="300px"><?php echo strtoupper("ObservaciÓn") ?></th>
                                                <th><?php echo strtoupper("Tipo Recaudo") ?></th>
                                            </thead>
                                            <?php $recaudos=$objBillImpl->getRecaudos(); ?>
                                            <?php foreach ($recaudos as $key => $value): ?>
                                                <tr>
                                                    <td><?php echo $value['RECAUCODIG'] ?></td>
                                                    <td><?php echo $value['RECAUCREDI'] ?></td>
                                                    <td><?php echo $value['CREDICLIEN'] ?></td>
                                                    <td><?php echo $value['CLIENNOMBR'] ?></td>
                                                    <td><?php echo $value['RECAUVALOR'] ?></td>
                                                    <td ><?php echo $value['RECAUFECHA'] ?></td>
                                                    <td width="300px"><p><?php echo isset($value['RECAUOBSER']) ? $value['RECAUOBSER'] : '' ?></p></td>
                                                    <td><?php echo isset($value['RECAUTIPO']) ? $value['RECAUTIPO'] : '' ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                        </table>
                                   
                                <?php                                
                                echo '<table><tr>
                                        <td>VENTAS CONTADO</td>
                                        <td class="tdDerecha">'.number_format($sumTotalContado,0).'</td>
                                        <td></td>
                                    </tr></table>';
                                ?>
                             
                                        <table class="datatable">
                                            <thead>
                                                <th><?php echo strtoupper("CÓdigo de RemisiÓn") ?></th>
                                                <th><?php echo strtoupper("IdentificaciÓn del cliente") ?></th>
                                                <th><?php echo strtoupper("Nombre del cliente") ?></th>
                                                <th><?php echo strtoupper("Fecha de RemisiÓn") ?></th>
                                                <th><?php echo strtoupper("Valor de RemisiÓn") ?></th>
                                                <th width="400px"><?php echo strtoupper("ObservaciÓn") ?></th>
                                            </thead>
                                            <?php $recaudos=$objBillImpl->ventasContado(); ?>
                                            <?php foreach ($recaudos as $key => $value): ?>
                                                <tr>
                                                    <td><?php echo $value['REMISCODIG'] ?></td>
                                                    <td><?php echo $value['REMISCLIEN'] ?></td>
                                                    <td><?php echo $value['CLIENNOMBR'] ?></td>
                                                    <td><?php echo $value['REMISFECGE'] ?></td>
                                                    <td><?php echo $value['REMISVALOR'] ?></td>
                                                    <td width="400px"><?php echo isset($value['REMISOBSER']) ? $value['REMISOBSER'] : ''  ?></td>
                                               
                                                </tr>
                                            <?php endforeach ?>
                                        </table>
                                    
                                <?php 
                                echo '<table><tr>
                                        <td>COMPROBANTES EGRESO</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($sumSaldoCxP,0).'</td>
                                    </tr></table>';
                                ?>
                             
                                        <table class="datatable">
                                            <thead>
                                                <th>CÓDIGO PAGO</th>
                                                <th>CÓDIGO CUENTA POR PAGAR</th>
                                                <th>VALOR PAGO</th>
                                                <th>FECHA DE GENERACIÓN</th>
                                                <th width="400px">OBSERVACIÓN</th>
                                                <th> TIPO DE PAGO</th>
                                            </thead>
                                            <?php $recaudos=$objBillImpl->comprobantesDeEgreso(); ?>
                                            <?php if (count($recaudos)): ?>
                                                
                                                <?php foreach ($recaudos as $key => $value): ?>
                                                    <tr>
                                                        <td><?php echo $value['CUEPAPAGCO'] ?></td>
                                                        <td><?php echo $value['CUEPAPAGCP'] ?></td>
                                                        <td><?php echo $value['CUEPAPAGVA'] ?></td>
                                                        <td><?php echo $value['CUEPAPAGFG'] ?></td>
                                                        <td><?php echo $value['CUEPAPAGOB'] ?></td>
                                                        <td><?php echo  $value['CUEPAPAGTI']  ?></td>
                                                   
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6"> <center>No se encontraron registros</center> </td>
                                                </tr>
                                            <?php endif ?>
                                        </table>
                                    
                                <?php 
                                echo '<table><tr>
                                        <td>GASTOS</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($sumTotalGastos,0).'</td>
                                    </tr></table>';
                                ?>
                             
                                        <table class="datatable">
                                            <thead>
                                                <th>CÓDIGO RECIBO</th>
                                                <th>CÓDIGO CLIENTE</th>
                                                <th>NOMBRE CLIENTE</th>
                                                <th>CÓDIGO DEL CONCEPTO</th>
                                                <th>NOMBRE DEL CONCEPTO</th>
                                                <th>FECHA GENERACIÓN DEL GASTO</th>
                                                <th>VALOR DEL GASTO</th>
                                            </thead>
                                            <?php $recaudos=$objBillImpl->gastos(); ?>
                                            <?php if (count($recaudos)): ?>
                                                
                                                <?php foreach ($recaudos as $key => $value): ?>
                                                    <tr>
                                                        <td><?php echo $value['GASTORECIB'] ?></td>
                                                        <td><?php echo $value['GASTOCLIEN'] ?></td>
                                                        <td><?php echo $value['CLIENNOMBR'] ?></td>
                                                        <td><?php echo $value['GASTOCONCE'] ?></td>
                                                        <td><?php echo $value['CONCENOMBR'] ?></td>
                                                        <td><?php echo  $value['GASTOFECHA']  ?></td>
                                                        <td><?php echo  $value['GASTOVALOR']  ?></td>
                                                   
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6"> <center>No se encontraron registros</center> </td>
                                                </tr>
                                            <?php endif ?>
                                        </table>
                                    
                                <?php 
                                echo '<table><tr>
                                        <td>SUBTOTALES</td>
                                        <td class="tdDerecha">'.number_format($sumTotalIngresos,0).'</td>
                                        <td class="tdDerecha">'.number_format($sumTotalEgresos,0).'</td>
                                    </tr>';
                                echo '<tr id="trColor">
                                        <td colspan="2">SALDO</td>
                                        <td class="tdDerecha">'.number_format($sumSaldos,0).'</td>
                                    </tr>';
                                ?>
                                        
                                </table>
                                </form>  
                   
                    <?php

                    {?>
                    
                    <br><br>

                    <br>
                        
                    <?php
                    }
                    ?>
                    
                    <div id="superContenedorCanvas">
                        <div id="contenedorCanvas">
                            <canvas id="canvas">                            
                            </canvas>
                        </div>
                    </div>
                <script>
                    if($('#sumInvtrHidden').val() > 0 && $('#sumRemisionHidden').val() > 0)
                    {
                    
                        var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

                        var barChartData = {
                                labels : ["Inventario","FacturaciÓn"],
                                datasets : [
                                        {
                                                fillColor : "rgba(151,187,205,0.5)",
                                                strokeColor : "rgba(151,187,205,0.8)",
                                                highlightFill : "rgba(151,187,205,0.75)",
                                                highlightStroke : "rgba(151,187,205,1)",
                                                data : [$('#sumInvtrHidden').val(),$('#sumRemisionHidden').val()]
                                        }
                                ]

                        }
                        window.onload = function(){
                                var ctx = document.getElementById("canvas").getContext("2d");
                                window.myBar = new Chart(ctx).Bar(barChartData, {
                                        responsive : true
                                });
                        }
                    }   
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