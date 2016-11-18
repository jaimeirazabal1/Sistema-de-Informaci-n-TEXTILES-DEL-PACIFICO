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
        <script src="../../js/jquery/jquery.js"></script>
        <script src="../../js/search.js"></script>
        <script src="../../js/prompt_collect.js"></script>
        <script type="text/javascript" src="../../js/jquery.price_format.2.0.min.js"></script>
        <script type="text/javascript" src="../../js/price_format.js"></script>
        <script src="../../js/updatePayMethod.js"></script>
        <title>Recaudos</title>
    </head>
    <body>
        <section class="contenedor">
            <header>
                <div class="logoEmpresa">
                    </div><div class="sesion">
                        Salir<a href="../../controllers/ctrlLogout.php"><img src="../../res/logout-24.png"></a>
                    </div>                    
                <div class="contenedorRutaApp">
                    <div class="nombreAplicacion">
                        <a href="../../">Sistema de Información TEXTILES DEL PACIFICO </a> 
                    </div><div class="arrowImgRight">
                        <img src="../../res/arrow-25-16.png">
                    </div><div class="opcionSeleccionada">
                        Recaudos
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
                <h1>Recaudo</h1>
                
                                
                <div class="encabezadoContenido">
                    <div class="tituloContenido"><h1>Créditos del Cliente</h1></div><div class="agregarDato"></div><div class="buscar">    
                        <input type="button" class="imgEditClass" value="Recaudar">                        
                    </div>                    
                </div>
                
                <div class="listadoCreditBill">
                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>CODIGO</th>
                                <th>CLIENTE</th>
                                <th>REMISION</th>
                                <th>FECHA</th>                                
                                <th>VALOR</th>   
                                <th>SALDO</th>                                
                                <th>TIPO</th>
                            </tr>
                            
                            <?php
                            require '../../models/CreditImpl.php';
                            require '../../models/ClientImpl.php';
                            $objCreditImpl = new CreditImpl();
                            $cont = 0;
                            $contTotalSaldo = 0;
                            
                            foreach ($objCreditImpl->getByStateAC($_GET['id']) as $valor) {
                                /*$quantityAvailable = $objCreditImpl->getQuantityAvailable($valor->getCode());
                                $quantitySale = $objCreditImpl->getQuantitySale($valor->getCode());
                                $totalCantidad = $quantityAvailable - $quantitySale; */
                                
                                $objClientImpl = new ClientImpl();
                                
                                if($cont%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                <?php }?>
                                    <?php echo '<td id="td1'.$cont.'">'.$valor->getCode(); ?></td>                                
                                    <?php echo '<td id="td2'.$cont.'">'.$objClientImpl->getNameClient($valor->getCodeClient()); ?></td>
                                    <?php echo '<td class="tdDerecha" id="td3'.$cont.'">'.$valor->getCodeBill(); ?></td>                                
                                    <?php echo '<td id="td4'.$cont.'">'.$valor->getRegistrationDate(); ?></td>                                
                                    <?php echo '<td class="tdDerecha" id="td5'.$cont.'">'.number_format($valor->getValue()); ?></td>                                
                                    <?php echo '<td class="tdDerecha" id="td6'.$cont.'">'.number_format($valor->getSaldo()); ?></td>                                
                                    <?php echo '<td id="td7'.$cont.'">'.$valor->getType(); ?></td>       
                                    
                                    <?php
                                    $contTotalSaldo += $valor->getSaldo();
//                                    echo "Saldo;  ".$contTotalSaldo;
                                    ?>

                                    <!--<td id="tdAcciones">-->
                                        <?php                                        
                                        //echo '<a id="articleDetail1" href="edit_detail.php?idf='.$billNumber.'&ida='.$valor->getCode().'&n='.$valor->getName().'&pc='.$priceBuy.'"><img id="imgEdit1" src="../../res/add-list-16.png"></a>';                                        
//                                        echo '<img class="imgEditClass" id="'.$cont.'" src="../../res/add-list-16.png">';                                        
                                        ?>                                        
                                    <!--</td>-->                                      
                                </tr>                                                     
                            <?php
                            $cont++;                            
                            }
                            ?>   
                        </table>
                    </form>
                    <?php 
                        if($cont == 0)
                            echo '<p>No se encontraron créditos para el cliente</p>'; 
                    ?>
                </div>
                
                
                <div class="contenidoRecaudo">
                    
                </div>
                <div class="detallesRecaudo">
                    <form id="formSubmit" method="post" action="../../controllers/ctrlInsertCollect.php">                        
                        <br>
                        <h1>RECAUDAR</h1><br>
                        
                        <?php
                        echo '<input type="hidden" name="hiddenCodeClient" id="hiddenCodeClient" value="'.$_GET['id'].'">'; 
                        echo '<input type="hidden" name="hiddenCodeCredit" id="hiddenCodeCredit">'; 
                        echo '<input type="hidden" name="hiddenSaldoCredit" id="hiddenSaldoCredit" value="'.$contTotalSaldo.'">';
                        ?>
                        
<!--                        <input type="hidden" name="hiddenName" id="hiddenName">
                        <input type="hidden" name="hiddenPriceBuy" id="hiddenPriceBuy">
                        <input type="hidden" name="hiddenPriceSale" id="hiddenPriceSale">
                        
                        <input type="hidden" name="hiddenPriceSale" id="hiddenAuxAvailable">-->
                        
                    
                        <input type="text" id="example2" class="txbValue" name="txbValue" autocomplete="off" placeholder="VALOR" maxlength="14" required><br>
                        <input id="txbObservations" name="txbObservations" type="text" placeholder="OBSERVACIONES" maxlength="200">
                        <select name="selectTypePay">
                            <option value="E">Efectivo</option>
                            <option value="C">Consignación</option>
                        </select>
                        <input type="hidden" name="hiddenSaldo" id="hiddenSaldo">
                        <input type="hidden" name="hiddenType" id="hiddenType">
                        
                        <p id="pValor"></p>
                        <p id="pSaldo"></p>
                        <p id="pMensaje"></p><br>
                        <input id="btnSubmit" type="submit" value="Guardar" disabled>
                    </form>
                </div>
                
                
                <div class="jump"></div>
                <h1>Recaudos Realizados</h1><br>
                
                <div class="listado">
                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>RECIBO</th>
                                <th>CREDITOS</th>                                
                                <th>CONCEPTO</th>                                
                                <th>VALOR</th>                                
                                <th>FECHA</th>
                                <th>PAGO</th>  
                                <th>ACCION</th>
                            </tr>
                            
                            <?php
                            require '../../models/CollectImpl.php';
                            $objCollectImpl = new CollectImpl();
                            
                            require '../../models/ConceptImpl.php';
                            $objConceptImpl = new ConceptImpl();
                            
                            $contR = 0;
                            
                            foreach ($objCollectImpl->getCollectByClientA($_GET['id']) as $valor) {
                                ?>
                                <tr>
                                    <td class="tdDerecha"><?php echo $valor->getCode(); ?></td>
                                    
                                    <td class="tdDerecha">
                                    <?php
                                    foreach ($objCollectImpl->getCollectByClientB($valor->getCode()) as $valorB) {
                                        echo  $valorB->getCodeCredit().' ';                                                              
                                    }?>
                                    </td>
                                    
                                    <td><?php echo $objConceptImpl->getNameConcept(1); ?></td> 
                                    <td class="tdDerecha"><?php echo number_format($objCollectImpl->getCollectByClientC($valor->getCode())); ?></td> 
                                    
                                    <?php
                                    foreach ($objCollectImpl->getCollectByClientD($valor->getCode()) as $valorD) {
                                        echo '<td>'.$valorD->getRegistrationDate().'</td>'   
                                        .'<td>';
                                                if(strcmp($valorD->getTypePay(), 'C') == 0)
                                                    echo 'CONSIGNACION'; 
                                                else if(strcmp($valorD->getTypePay(), 'E') == 0)
                                                    echo 'EFECTIVO';                                        
                                        echo '</td>';
                                    }
                                    ?>
                                    
                                    
                                    <td id="tdAcciones">
                                        <?php                                       
                                        echo '<a target="_blank" href="../../controllers/ctrlPrintCollect.php?id='.$valor->getCode().'&idc='.$_GET['id'].'"><img src="../../res/printer-2-16.png"></a>';     
                                        ?>                                        
                                    </td>  
                                </tr>
                                <?php
                                $contR++;
                                }
                                ?>
                        </table>
                    </form>                     
                    
                    <?php 
                        if($contR == 0)
                            echo '<p>No se encontraron recaudos</p>'; 
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