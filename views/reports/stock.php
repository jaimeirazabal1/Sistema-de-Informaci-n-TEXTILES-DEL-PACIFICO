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
        <script type="text/javascript" src="../../js/html2excel/src/jquery.table2excel.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>Reporte Inventario</title>
        <script type="text/javascript">
        $(document).ready(function(){

            $("#btnGenerarInventarioExcel").click(function(){
                var nombreArchivo = prompt('Ingrese el nombre del archivo');
                if (nombreArchivo) {
                  $("#tabla").table2excel({
                    exclude: ".noExl",
                        name: nombreArchivo,
                        filename: nombreArchivo ? nombreArchivo: 'Reporte de Inventario',
                        fileext: ".xls",
                        exclude_img: true,
                        exclude_links: true,
                        exclude_inputs: true
                  }); 

                }else{
                    
                    if (confirm('No se introdujo ningun nombre para el archivo, desea imprimirlo con el nombre de Reporte de Inventario?')) {
                          $("#tabla").table2excel({
                            exclude: ".noExl",
                                name: nombreArchivo,
                                filename: nombreArchivo ? nombreArchivo: 'Reporte de Inventario',
                                fileext: ".xls",
                                exclude_img: true,
                                exclude_links: true,
                                exclude_inputs: true
                          }); 
                    }else{
                        
                    }
                }
            });
        })
        </script>
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
                <h1>Reporte de Inventario</h1>
                
                <?php
                if($_POST)
                {?>
                    <form id="formReporteInventario" method="post">
                        <?php 
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$_POST['txbFechaInicio'].'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$_POST['txbFechaFin'].'">';
                        echo '<input id="txbReferencia" name="txbReferencia" type="text" placeholder="REFERENCIA" value="'.$_POST['txbReferencia'].'">';
                        
//                        echo '<select name="selectColor" id="selectColor">';
//                        include_once '../../models/ColorImpl.php';
//                        $objColorImpl = new ColorImpl();

//                        foreach ($objColorImpl->getAllOrderName() as $valor) {
//                            echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';                        
//                        }                    
//                        echo '</select>'; 
                        
                        ?>                        
                        <input id="btnConsultarInventario" type="submit" value="Consultar">
                        <input id="btnGenerarInventario" type="submit" value="Generar PDF">
                        <input id="btnGenerarInventarioExcel" type="submit"  value="Generar Excel">
                    </form>    
                <?php
                }
                else
                {?>
                    <form id="formReporteInventario" method="post">
                        <?php 
                        $dateNow = date("Y-m-d");
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$dateNow.'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$dateNow.'">';
                        ?>
                        <input id="txbReferencia" name="txbReferencia" type="text" placeholder="REFERENCIA">
                        
                        <?php
//                        echo '<select name="selectColor" id="selectColor">';
//                        include_once '../../models/ColorImpl.php';
//                        $objColorImpl = new ColorImpl();

//                        foreach ($objColorImpl->getAllOrderName() as $valor) {
//                            echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';                        
//                        }                    
//                        echo '</select>'; 
                        ?>
                        
                        <input id="btnConsultarInventario" type="submit" value="Consultar">
                        <input id="btnGenerarInventario" type="submit" value="Generar PDF">
                        <input id="btnGenerarInventarioExcel" type="submit"  value="Generar Excel">
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
                                <form method="post">
                                <table id="tabla">
                                    <tr>
                                        <th>REFERENCIA</th>
                                        <th>ARTICULO</th>
                                        <th>PRECIO COSTO</th>
                                        <th>PRECIO VENTA</th>
                                        <th>PRECIO TOTAL</th>
                                        <th>EXISTENCIAS</th>
                                        <th>COSTO INV.</th>
                                    </tr>
                                    
                                <?php
                                
                                $objSystemImpl = new SystemImpl();
                                
                                foreach ($objStockImpl->getByAlmacenBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia'], $_POST['selectColor']) as $valorStock) {
                                    $quantityAvailable = $objStockImpl->getQuantityAvailable($valorStock->getCode(), $valorStock->getColor());
                                    $quantitySale = $objStockImpl->getQuantitySale($valorStock->getCode(), $valorStock->getColor());
                                    $totalCantidad = $quantityAvailable - $quantitySale;
                                    $precioVenta = $objStockImpl->getLastPriceSold($valorStock->getCode(), $valorStock->getColor());
                                    $precioTotal = $precioVenta + ($precioVenta * $objSystemImpl->getValue(1)) / 100;
                                    
                                    echo '<tr>
                                        <td>'.$valorStock->getCode().'</td>
                                        <td>'.$valorStock->getName().'</td>';
                                        $prom = $objStockImpl->getPromPriceReport($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $valorStock->getCode(), $valorStock->getColor());
                                        $valueInventary = $prom * $totalCantidad;
                                        echo '<td class="tdDerecha">'.number_format($prom).'</td> 
                                        <td class="tdDerecha">'.number_format($precioVenta).'</td>
                                        <td class="tdDerecha">'.number_format(round($precioTotal,-3)).'</td>
                                        <td class="tdDerecha">'.($totalCantidad).'</td>
                                        <td class="tdDerecha" >'.number_format($valueInventary).'</td>
                                    </tr>';
                                    
                                   $totalCostoInventario += $valueInventary;
                                }                                
                                
                                echo '<tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="tdDerecha"><p>COSTO TOTAL INVENTARIO</p></td>
                                    <td class="tdDerecha"> '.number_format($totalCostoInventario).'</td>';
                                
                                ?>

                                </table>
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