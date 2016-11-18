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
        <script src="../../js/jquery-barcode.js"></script>
        <script src="../../js/prompt_barcode.js"></script>
        <script src="../../js/search.js"></script>
        <title>Inventario</title>
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
                        <a href="../../">Sistema de Información TEXTILES DEL PACIFICO</a>                        
                    </div><div class="arrowImgRight">
                        <img src="../../res/arrow-25-16.png">
                    </div><div class="opcionSeleccionada">
                        Inventario
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
            
            <section class="contenido" id="contenidoGeneral">
                <div class="encabezadoContenido">
                    <div class="tituloContenido"><h1>Gestión Inventario</h1></div><div class="agregarDato">
                        <a href="add_stock.php"><input type="button" value="Agregar"></a></div><div class="buscar">
                            <input type="text" id="txbSearchStock" placeholder="Buscar...">
                        </div>                    
                </div>
                <div class="listado">
                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>REFERENCIA</th>
                                <th>ARTICULO</th>
                                <th>MOVIMIENTO</th>
                                <th>CANTIDAD</th> 
                                <th>COLOR</th>
                                <th>ACCION</th>
                            </tr>
                            
                            <?php
                            require '../../models/StockImpl.php';                            
                            require '../../models/ColorImpl.php';
                            $objStockImpl = new StockImpl();
                            $objColorImpl = new ColorImpl();
                            $cont = 0;
                            
                            foreach ($objStockImpl->getAll() as $valor) {
                                if($cont%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                <?php }?>
                                    <?php echo '<td id="td1'.$cont.'">'.$valor->getCode().'</td>'; ?>                                
                                    <td><?php echo $valor->getName(); ?></td>
                                    <?php
                                    if(strcmp ($valor->getMove(), 'E') == 0 || strcmp ($valor->getMove(), 'e') == 0)
                                        echo '<td>ENTRADA</td>';
                                    else if(strcmp ($valor->getMove(), 'S') == 0 || strcmp ($valor->getMove(), 's') == 0)
                                        echo '<td>SALIDA</td>';
                                    else
                                        echo '<td></td>';
                                    ?>                                
										<td class="tdDerecha"><?php echo $valor->getQuantity() ?></td>                               
                                    
                                    <?php
                                    if(strcmp ($valor->getColor(), '') == 0)
                                        echo '<td></td>';
                                    else
                                        echo '<td>'.$objColorImpl->getNameColor($valor->getColor()).'</td>';
                                    ?>  
                                    
                                    
                                    <td id="tdAcciones">
                                        <?php
                                        echo '<a href="edit_stock.php?id='.$valor->getCode().'&n='.$valor->getName().'&c='.$valor->getColor().'"><img src="../../res/edit-16.png"></a>';                                                                                
                                        echo '<a href="edit_prices.php?id='.$valor->getCode().'&n='.$valor->getName().'&c='.$valor->getColor().'"><img src="../../res/edit-property-16.png"></a>';                                                                                                                        
//echo '<img class="imgBarcodeClass" id="'.$cont.'" src="../../res/line-width-16.png">';                                        
                                        ?>                                        
                                    </td>                                      
                                    
                                    
                                    
                                </tr>                                                     
                            <?php
                            $cont++;
                            }
                            ?>   
                        </table>
                    </form> 
                    
                    <?php echo '<p>Ultimos registros de '.$objStockImpl->getCount().' encontrados</p>';   ?>                   
                    
                </div>
                
                <div class="contenidoBarcode">
                    
                </div>
                <div class="detallesBarcode">
                    <form id="formSubmit" method="post" target="_blank" action="../../controllers/ctrlPrintCodebar.php">                        
                        <br>
                        <h1>CODIGO DE BARRAS</h1>
                        <div id="bcTarget"></div>  
                        <br>
                        <input type="hidden" name="hiddenCodeArticle" id="hiddenCodeArticle">        
                        <input id="btnSubmitBarcode" type="submit" value="Imprimir">
                    </form>
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
    echo '<script>document.location.href = "http://'.$ip.'/mio/login.php"; </script>';    
}
?>