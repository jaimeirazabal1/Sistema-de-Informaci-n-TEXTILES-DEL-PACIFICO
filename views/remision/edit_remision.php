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
        <script type="text/javascript" src="../../js/updatePayMethod.js"></script>
        <script type="text/javascript" src="../../js/updateObservationRemision.js"></script>
        <script type="text/javascript" src="../../js/price_format.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>Remisión</title>
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
                        Remisiones
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
                <h1>Remisión</h1>
                
                <?php                
                if(isset($_GET)){
                $metodoPago; 
                $observations;
                ?>
                <form method="post" action="../../controllers/ctrlEditRemision.php">                    
                <?php   
                    require '../../models/RemisionImpl.php';
                    require '../../models/ClientImpl.php';                    
                    
                    $objRemisionImpl = new RemisionImpl();
                    $objClientImpl = new ClientImpl();
                    
                    $billNumber;
                    
                    echo '<input type="hidden" id="typeHidden" value="RE">';
                    
                    foreach ($objRemisionImpl->getByCode($_GET['id']) as $valor) {
                        $billNumber = $valor->getCode();
                        $observations = $valor->getObservation();
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
                        
                        $metodoPago = $valor->getPayment();
                        
                        if($_GET['cj'] > 0)
                        {
                            if($valor->getValueSale() == 0)
                                echo '<script>alertify.error("El valor de los artículos es inferior al monto canjeable");</script>';                            
                        }
                        
                    }

                ?>
                </form>
                <?php                
                    }
                ?>
                
                
                <div class="encabezadoContenido">
                    <div class="tituloContenido"><h1>Seleccionar Artículos</h1></div><div class="agregarDato"></div><div class="buscar">
                            <input type="text" id="txbSearchStockRemision" placeholder="Buscar...">
                    </div>                    
                </div>
                
                <div class="listadoStockRemision">
                                        
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
                                    echo $totalCantidad;
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
                    <form id="formSubmit" method="post" action="../../controllers/ctrlInsertDetailRemision.php">                        
                        <br>
                        <h1></h1>
                        
                        <?php
                        echo '<input type="hidden" name="hiddenCodeRemision" value="'.$billNumber.'">';
                        echo '<input type="hidden" name="hiddenCodeArticle" id="hiddenCodeArticle">';        
                        echo '<input type="hidden" name="hiddenCanjeable" id="hiddenCanjeable" value="'.$_GET['cj'].'">'; 
                        ?>
                        
                        <input type="hidden" name="hiddenName" id="hiddenName">
                        <input type="hidden" name="hiddenPriceBuy" id="hiddenPriceBuy">
                        <input type="hidden" name="hiddenPriceSale" id="hiddenPriceSale">
                        <input type="hidden" name="hiddenColor" id="hiddenColor">
                        
                        <input type="hidden" name="hiddenPriceSale" id="hiddenAuxAvailable">                        
                        
                        <input id="txbQuantityBuy" name="txbQuantityBuy" type="number" step="0.01" placeholder="CANTIDAD" required>
                        <input type="text" id="example2" name="txbPriceSale" placeholder="PRECIO VENTA" required><br>
                        <p id="pDisponibles"></p>
                        <!--<p id="pPrecioCompra"></p>-->
                        <!--<p id="pPrecioVenta"></p>-->
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
                                <th>ACCION</th>
                            </tr>
                            
                            <?php
                            require '../../models/DetailRemisionImpl.php';
                            $objDetailRemisionImpl = new DetailRemisionImpl();
                            $contDetailRemision = 0;
                            
                            foreach ($objDetailRemisionImpl->getByCode($billNumber) as $valor) {
                                
                                if($contDetailRemision%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                <?php }
                                
                                        echo '<td id="tdd1'.$contDetailRemision.'">'.$valor->getCodeArticle().'</td>';
                                        echo '<td id="tdd1'.$contDetailRemision.'">'.$objColorImpl->getNameColor($valor->getColor()).'</td>';
                                        echo '<td class="tdDerecha" id="tdd2'.$contDetailRemision.'">'.$valor->getQuantity().'</td>';
                                        echo '<td class="tdDerecha" id="tdd3'.$contDetailRemision.'">';echo number_format($valor->getValueUnit(),0).'</td>';
                                        echo '<td class="tdDerecha" id="tdd4'.$contDetailRemision.'">';echo number_format($valor->getTotal(),0).'</td>';
                                        
                                                                           
                                    ?>
                                        
                                      <td id="tdAcciones">
                                            <?php
                                            //echo '<img class="imgEditClassDetailRemision" id="'.$contDetailRemision.'" src="../../res/edit-16.png">';                                        
                                            echo '<a href="../../controllers/ctrlDeleteDetailRemision.php?idf='.$billNumber.'&ida='.$valor->getCodeArticle().'&q='.$valor->getQuantity().'&cl='.$valor->getColor().'&cj='.$_GET['cj'].'"><img src="../../res/x-mark-16.png"></a>';                                                                                    
                                            ?>                                        
                                        </td>
                                </tr>                                                     
                            <?php
                            $contDetailRemision++;
                            }
                            ?>   
                        </table>
                    </form>                                       
                    
                <div class="contenidoCantidadPrecioDetail">
                    
                </div>
                <div class="detallesCantidadPrecioDetail">
                    <form id="formSubmit" method="post" action="../../controllers/ctrlUpdateDetailRemision.php">                        
                        <br>
                        <h1></h1>
                        
                        <?php
                        echo '<input type="hidden" name="hiddenCodeRemisionDetailRemision" value="'.$billNumber.'">';
                        echo '<input type="hidden" name="hiddenCodeArticleDetailRemision" id="hiddenCodeArticleDetailRemision">';      
                        ?>
                        
                        <input type="hidden" name="hiddenQuantityDetailRemision" id="hiddenName">
                        <input type="hidden" name="hiddenPriceBuyDetailRemision" id="hiddenPriceBuy">
                        
                        <input id="txbQuantityBuyDetailRemision" class="cantExample" name="txbQuantityBuyDetailRemision" type="text" placeholder="CANTIDAD" required>
                        <input type="text" id="example22" name="txbPriceSaleDetailRemision" placeholder="PRECIO VENTA" required><br>
                        <p id="pCantidadDetailRemision"></p>
                        <p id="pPrecioCompraDetailRemision"></p>
                        <p id="pMensajeDetailRemision"></p><br>
                        <input id="btnSubmitDetailRemision" type="submit" value="Guardar" disabled>
                    </form>
                </div>
                    
                </div>                              
                
                <?php echo '<br><br><textarea placeholder="Observaciones" name="txaObservation" id="txa-lg">'.$observations.'</textarea>'; ?>
                
                <div class="encabezadoContenido">
                    <div class="tituloContenido" id="pago"></div><div class="agregarDato"></div><div class="buscar">
                        <?php 
                                                
                        if(strcmp ($metodoPago, 'CO') == 0)
                        {
                            echo '<select name = "selectPayment" id="selectPaymentBill" class="re">';     
                            echo '<option value="CO" selected="selected">CONTADO</option>';
                            echo '<option value="CR">CREDITO</option>';
                            echo '</select><br><br>'; 
                        }
                        else if(strcmp ($metodoPago, 'CR') == 0)
                        {
                            echo '<select name = "selectPayment" id="selectPaymentBill" class="re" disabled>';     
                            echo '<option value="CO" >CONTADO</option>';
                            echo '<option value="CR" selected="selected">CREDITO</option>';
                            echo '</select><br><br>'; 
                        }                        

                        if(strcmp ($metodoPago, 'CR') == 0){
                            echo '<a href="../../views/collect/add_collect.php"><input type="button" value="Recaudar"></a> '; 
                        }
                        
                        
                        
                        echo '<a target="_blank" href="../../controllers/ctrlPrintRemisionBill.php?id='.$billNumber.'&cj='.$_GET['cj'].'"><input type="button" value="Imprimir"></a>'; 
                        ?>
                        <br><br><input type="button" id="btnDevueltas" value="Devueltas">
                    </div>                    
                </div>
                
                <?php
                if($_GET['cj'] > 0){
                    echo '<br><br><h1>Total Canjeable con IVA: '.number_format($_GET['cj']).'</h1><br>';
                }
                
                ?>
                
                <div class="contenidoDevueltas">
                    
                </div>
                <div class="detallesDevueltas">
                    <!--<form>-->                        
                        <br>
                        <h1>CALCULO DEVUELTAS</h1>
                                               
                        <input id="txbRecibido" class="cantExample" type="text" placeholder="RECIBIDO">
                        <p id="pMensajeDevuelta"></p><br>                        
                    <!--</form>-->
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
            
            <?php
            if(isset($_GET)){
                require_once '../../models/Credit.php';
                require_once '../../models/CreditImpl.php';
                require_once '../../models/RemisionImpl.php';
                $objCredit = new Credit();
                $objCreditImpl = new CreditImpl();
                                
                

                $num_rows_credit = $objCreditImpl->checkCodeRemisionInCredit($_GET['id']);
                //si existe el credito ingresa
                if ($num_rows_credit > 0) {
                    $objRemisionU = new Remision();
                    $objRemisionU->setCode($_GET['id']);                    
                    $objCredit->setType("RE");
                    $objCredit->setValue($objRemisionImpl->getValueRemision($objRemisionU));
                    $objCredit->setCodeBill($_GET['id']);
                    $objCreditImpl->updateValue($objCredit);
                    
                    //actualizar saldo
                    require_once '../../models/CollectImpl.php';
                    $totalCredito = $objCredit->getValue();
                    
                    $objCollectImpl = new CollectImpl();
                    
                    $idCredit = $objCreditImpl->getId($_GET['id'], 'RE');                    
                    $totalRecaudado = $objCollectImpl->sumValueByBiil($idCredit);
                    
                    $objCredit->setCode($idCredit);
                    $objCredit->setSaldo($totalCredito - $totalRecaudado);                    
                    $objCreditImpl->updateSaldo($objCredit);
                    
                    /*echo 'TOTAL CREDITO: '.$totalCredito.'<br>';
                    echo 'TOTAL RECAUDADO: '.$totalRecaudado.'<br>';
                    echo 'TOTAL SALDO: '.($totalCredito - $totalRecaudado).'<br>';*/
                    
                }
            }
            ?>
            
            
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