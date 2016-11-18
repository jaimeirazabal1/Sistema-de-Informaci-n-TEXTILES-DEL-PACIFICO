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
        <script src="../../js/search.js"></script>
        <script src="../../js/prompt.js"></script>
        <script src="../../js/prompt_detail.js"></script>
        <script src="../../js/prompt_devueltas.js"></script>
        <script type="text/javascript" src="../../js/jquery.price_format.2.0.min.js"></script>
        <script type="text/javascript" src="../../js/price_format.js"></script>
        <title>Facturación</title>
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
                        <a href="../../">Sistema de Información MIOS SPORT</a>                        
                    </div><div class="arrowImgRight">
                        <img src="../../res/arrow-25-16.png">
                    </div><div class="opcionSeleccionada">
                        Facturación
                    </div>
                </div>
            </header>
            <nav id="menu">
                <ul>
                    <li><a href="../config/"><img src="../../res/settings-4-16.png">Parametros</a></li>
                    <li><a href="../clients/"><img src="../../res/guest-16.png">Clientes</a></li>
                    <li><a href="../stock/"><img src="../../res/list-ingredients-16.png">Inventario</a></li>                    
                    <li><a href="../remision"><img src="../../res/invoice-16.png">Remisión</a></li>
                    <li><a href="../collect/"><img src="../../res/cash-receiving-16.png">Recaudos</a></li>
                    <li><a href="../change/"><img src="../../res/undo-2-16.png">Cambios</a></li>
                    <li><a href="../spend/"><img src="../../res/banknotes-16.png">Gastos</a></li> 
                    <li><a href="../reports/"><img src="../../res/line-16.png">Reportes</a></li>   
                </ul>
            </nav>
            
            <section class="contenido" id="contenidoGeneral">
                <h1>Factura</h1>
                
                <?php                
                if(isset($_GET)){
                
                ?>
                <form method="post" action="../../controllers/ctrlEditBill.php">                    
                <?php   
                    require '../../models/BillImpl.php';
                    require '../../models/ClientImpl.php';                    
                    
                    $objBillImpl = new BillImpl();
                    $objClientImpl = new ClientImpl();
                    
                    $billNumber;
                    
                    foreach ($objBillImpl->getByCode($_GET['id']) as $valor) {
                        $billNumber = $valor->getCode();
                        echo '<input type="hidden" id="userHidden" value="'.$_SESSION['userCode'].'">';
                        echo '<input type="hidden" id="billNumberHidden" value="'.$billNumber.'">';
                        echo '<input type="number" name="txbCode" id="txbCode" value="'.$valor->getCode().'" readonly>';
                        echo '<input type="text" name="txbCodeClient" id="txbCodeClient" value="'.$valor->getClient().'" maxlength="12" required readonly>';
                        echo '<input type="hidden" id="totalBill" value="'.$valor->getValueSale().'">';
                        
                        $clientName = $objClientImpl->getNameClient($valor->getClient());
                        echo '<input type="text" name="txbCodeClient" value="'.$clientName.'" readonly>';
                        
                        echo '<input type="text" name="txbDateGeneration" value="'.$valor->getGenerationDate().'" readonly>';
                        echo '<input type="text" name="txbValueSale" id="txbValueSale" value="'.number_format($valor->getValueSale(),0).'" readonly>';
                        echo '<input type="text" name="txbValueIva" id="txbValueIva" value="'.number_format($valor->getValueIVA(),0).'" readonly>';
                        
                    }

                ?>
                </form>
                <?php                
                    }
                ?>
                
                
                
                <div class="encabezadoContenido">
                    <div class="tituloContenido"><h1>Seleccionar Artículos</h1></div><div class="agregarDato"></div><div class="buscar">
                            <input type="text" id="txbSearchStockBill" placeholder="Buscar...">
                    </div>                    
                </div>
                
                <div class="listadoStockBill">
                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>REFERENCIA</th>
                                <th>ARTICULO</th>
<!--                                <th>MOVIMIENTO</th>-->
                                <th>CANTIDAD</th>
                                <th class="tdNoVisible">PRECIO COSTO</th>
                                <th>COLOR</th>
                                <th class="tdNoVisible">PRECIO VENTA</th>
                                <th>ACCION</th>
                            </tr>
                            
                            <?php
                            require '../../models/StockImpl.php';
                            require '../../models/ColorImpl.php';
                            $objStockImpl = new StockImpl();
                            $objColorImpl = new ColorImpl();
                            $cont = 0;
                            
                            foreach ($objStockImpl->getByAlmacen() as $valor) {
                                $quantityAvailable = $objStockImpl->getQuantityAvailable($valor->getCode(), $valor->getColor());
                                $quantitySale = $objStockImpl->getQuantitySale($valor->getCode(), $valor->getColor());
                                $totalCantidad = $quantityAvailable - $quantitySale; 
                                //$idColor = $objStockImpl->getColor($valor->getCode());
                                $idColor = $valor->getColor();
                                $valueSaleUnit = $objStockImpl->getLastPriceVenta($valor->getCode(), $idColor);
                                
                                
                                
                            if($totalCantidad>0){    
                                if($cont%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                <?php }?>
                                    <?php echo '<td id="td1'.$cont.'">'.$valor->getCode(); ?></td>                                
                                    <?php echo '<td id="td2'.$cont.'">'.$valor->getName(); ?></td>
                                    
                                    
                                    <?php echo '<td class="tdDerecha" id="td3'.$cont.'">';
                                    echo number_format($totalCantidad,0);
                                    echo '</td>';?>
                                    
                                    <?php echo '<td class="tdNoVisible" id="td4'.$cont.'">';
                                    $priceBuy = $objStockImpl->getLastPriceSold($valor->getCode(), $valor->getColor()); 
                                    echo number_format($priceBuy,0);
                                    echo '</td>';
                                    
                                    echo '<td id="td5'.$cont.'">'.$objColorImpl->getNameColor($idColor).'</td>';

                                    echo '<td class="tdNoVisible" id="td6'.$cont.'">'.$idColor.'</td>';
                                    echo '<td class="tdNoVisible" id="td7'.$cont.'">'.$valueSaleUnit.'</td>';
                                    
                                    
                                    echo '<input type="hidden" id="txbOculto"'.$cont.' name="txbOculto" value="5">';
                                    
                                    ?>                             
                                    
                                    <td id="tdAcciones">
                                        <?php                                        
                                        echo '<img class="imgEditClass" id="'.$cont.'" src="../../res/add-list-16.png">';                                        
                                        ?>                                        
                                    </td>                                      
                                </tr>                                                     
                            <?php
                            $cont++;
                            }
                            }
                            ?>   
                        </table>
                    </form> 
                </div>
                
                
                <div class="contenidoCantidadPrecio">
                    
                </div>
                <div class="detallesCantidadPrecio">
                    <form id="formSubmit" method="post" action="../../controllers/ctrlInsertDetail.php">                        
                        <br>
                        <h1></h1>
                        
                        <?php
                        echo '<input type="hidden" name="hiddenCodeBill" value="'.$billNumber.'">';
                        echo '<input type="hidden" name="hiddenCodeArticle" id="hiddenCodeArticle">';        
                        ?>
                        
                        <input type="hidden" name="hiddenName" id="hiddenName">
                        <input type="hidden" name="hiddenPriceBuy" id="hiddenPriceBuy">
                        <input type="hidden" name="hiddenPriceSale" id="hiddenPriceSale">
                        <input type="hidden" name="hiddenColor" id="hiddenColor">
                        
                        <input type="hidden" name="hiddenPriceSale" id="hiddenAuxAvailable">                        
                    
                        
                        <input id="txbQuantityBuy" class="cantExample" name="txbQuantityBuy" type="text" placeholder="CANTIDAD" required>
                        <!--<input type="text" id="example2" name="txbPriceSale" placeholder="PRECIO VENTA" required><br>-->
                        <p id="pDisponibles"></p>
                        <!--<p id="pPrecioCompra"></p>-->
                        <p id="pPrecioVenta"></p>
                        <p id="pMensaje"></p><br>
                        <input id="btnSubmit" type="submit" value="Guardar" disabled>
                    </form>
                </div>
                
                
                
                <br><br>
                <h1>Detalles</h1>
                <br>
                
                
                <div class="listado">                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>REFERENCIA</th>
                                <th>COLOR</th>
                                <th>CANTIDAD</th>
                                <th>VALOR UNITARIO</th>
                                <th>VALOR TOTAL</th>                                
                                <!--<th>ACCION</th>-->
                            </tr>
                            
                            <?php
                            require '../../models/DetailImpl.php';
                            $objDetailImpl = new DetailImpl();
                            $contDetail = 0;
                            
                            foreach ($objDetailImpl->getByCode($billNumber) as $valor) {
                                
                                
                                if($contDetail%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                <?php }
                                
                                        echo '<td id="tdd1'.$contDetail.'">'.$valor->getCodeArticle().'</td>';
                                        echo '<td id="tdd1'.$contDetail.'">'.$objColorImpl->getNameColor($valor->getColor()).'</td>';
                                        echo '<td class="tdDerecha" id="tdd2'.$contDetail.'">';echo number_format($valor->getQuantity(),0).'</td>';
                                        echo '<td class="tdDerecha" id="tdd3'.$contDetail.'">';echo number_format($valor->getValueUnit(),0).'</td>';
                                        echo '<td class="tdDerecha" id="tdd4'.$contDetail.'">';echo number_format($valor->getTotal(),0).'</td>';
                                        
                                                                           
                                    ?>
                                        
<!--                                        UPDATE AND DELETE DISABLED-->
<!--                                        <td id="tdAcciones">
                                            <?php/*
                                            echo '<img class="imgEditClassDetail" id="'.$contDetail.'" src="../../res/edit-16.png">';                                        
                                            echo '<a href="../../controllers/ctrlDeleteDetail.php?idf='.$billNumber.'&ida='.$valor->getCodeArticle().'&q='.$valor->getQuantity().'"><img src="../../res/x-mark-16.png"></a>';                                                                                    
                                            */?>                                        
                                        </td>  -->
                                </tr>                                                     
                            <?php
                            $contDetail++;
                            }
                            ?>   
                        </table>
                    </form>                                       
                    
                <div class="contenidoCantidadPrecioDetail">
                    
                </div>
                <div class="detallesCantidadPrecioDetail">
                    <form id="formSubmit" method="post" action="../../controllers/ctrlUpdateDetail.php">                        
                        <br>
                        <h1></h1>
                        
                        <?php
                        echo '<input type="hidden" name="hiddenCodeBillDetail" value="'.$billNumber.'">';
                        echo '<input type="hidden" name="hiddenCodeArticleDetail" id="hiddenCodeArticleDetail">';      
                        ?>
                        
                        <input type="hidden" name="hiddenQuantityDetail" id="hiddenName">
                        <input type="hidden" name="hiddenPriceBuyDetail" id="hiddenPriceBuy">
                        
                        <input id="txbQuantityBuyDetail" class="cantExample" name="txbQuantityBuyDetail" type="text" placeholder="CANTIDAD" required>
                        <input type="text" id="example22" name="txbPriceSaleDetail" placeholder="PRECIO VENTA" required><br>
                        <p id="pCantidadDetail"></p>
                        <p id="pPrecioCompraDetail"></p>
                        <p id="pMensajeDetail"></p><br>
                        <input id="btnSubmitDetail" type="submit" value="Guardar" disabled>
                    </form>
                </div>
                    
                 
                </div>                              
                
                <div class="encabezadoContenido">
                    <div class="tituloContenido" id="pago"></div><div class="agregarDato"></div><div class="buscar">
                        <?php 
                        echo '<a target="_blank" href="../../controllers/ctrlPrintBill.php?id='.$billNumber.'"><input type="button" value="Imprimir"></a>'; 
                        ?>
                        <input type="button" id="btnDevueltas" value="Devueltas">
                    </div>                    
                </div>
                
                <div class="contenidoDevueltas">
                    
                </div>
                <div class="detallesDevueltas">
                    <form>                        
                        <br>
                        <h1>CALCULO DEVUELTAS</h1>
                                               
                        <input id="txbRecibido" class="cantExample" type="text" placeholder="RECIBIDO">
                        <p id="pMensajeDevuelta"></p><br>                        
                    </form>
                </div>
                
            </section>
            <footer>
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