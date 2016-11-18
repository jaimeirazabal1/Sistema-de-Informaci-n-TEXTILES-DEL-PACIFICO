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
                <h1>Existencias por Artículo</h1>
                
                <?php
                if($_POST)
                {?>
                    <form id="formReporteStockArticle" method="post">
                        <?php 
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$_POST['txbFechaInicio'].'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$_POST['txbFechaFin'].'">';
                        echo '<input id="txbReferencia" name="txbReferencia" type="text" placeholder="REFERENCIA" value="'.$_POST['txbReferencia'].'" required>';
                        ?>                        
                        <input id="btnConsultarStockArticulo" type="submit" value="Consultar">
                        <input id="btnGenerarStockArticulo" type="submit" value="Generar PDF">
                    </form>    
                <?php
                }
                else
                {?>
                    <form id="formReporteStockArticle" method="post">
                        <?php 
                        $dateNow = date("Y-m-d");
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$dateNow.'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$dateNow.'">';
                        ?>
                        <input id="txbReferencia" name="txbReferencia" type="text" placeholder="REFERENCIA" required>
                        <input id="btnConsultarStockArticulo" type="submit" value="Consultar">
                        <input id="btnGenerarStockArticulo" type="submit" value="Generar PDF">
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
                        $objStockImpl = new StockImpl();

                        if ($objStockImpl->getCountByAlmacenBetweenDateReportArticle($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia']) > 0)
                        {
                        ?>

                        <form method="post">
                        <table>
                            <tr>
                                <th>REFERENCIA</th>
                                <th>ARTICULO</th>
                                <th>MOVIMIENTO</th>
                                <th>CANTIDAD</th>
                                <th>FECHA</th>
                            </tr>

                        <?php
                        foreach ($objStockImpl->getByArticleInOutBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia']) as $valorStock) {
                            echo '<tr>
                                <td>'.$valorStock->getCode().'</td>
                                <td>'.$valorStock->getName().'</td>';
                                
                                if(strcmp ($valorStock->getMove(), 'E') == 0 || strcmp ($valorStock->getMove(), 'e') == 0)
                                    echo '<td>ENTRADA</td>';
                                else if(strcmp ($valorStock->getMove(), 'S') == 0 || strcmp ($valorStock->getMove(), 's') == 0)
                                    echo '<td>SALIDA</td>';
                                else if(strcmp ($valorStock->getMove(), 'D') == 0 || strcmp ($valorStock->getMove(), 'd') == 0)
                                    echo '<td>DEVOLUCION</td>';
                                else if(strcmp ($valorStock->getMove(), 'A') == 0 || strcmp ($valorStock->getMove(), 'a') == 0)
                                    echo '<td>ANULACION</td>';else
                                echo '<td></td>';                                    

                                echo '<td class="tdDerecha">'.($valorStock->getQuantity()).'</td>
                                <td class="tdDerecha">'.$valorStock->getMoveDate().'</td>
                            </tr>';
                        }                                
                        ?>

                        </table>
                        </form>  
                    
                    <?php
                    
                        $entradas = $objStockImpl->getCountArticleIn($_POST['txbFechaInicio'], $_POST['txbFechaFin'], strtoupper($_POST['txbReferencia']));
                        $salidas = $objStockImpl->getCountArticleOut($_POST['txbFechaInicio'], $_POST['txbFechaFin'], strtoupper($_POST['txbReferencia']));
                        $anuladas = $objStockImpl->getCountArticleAnul($_POST['txbFechaInicio'], $_POST['txbFechaFin'], strtoupper($_POST['txbReferencia']));
                        $existencias = $entradas - $salidas - $anuladas;
                        echo '<p>Total Entradas y Devoluciones: '.($entradas);                              
                        echo '<p>Total Salidas: '.($salidas);
                        echo '<p>Total Anulaciones: '.($anuladas);
                        echo '<p>Existencias: '.($existencias);
                    
                        }
                        else
                        {
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