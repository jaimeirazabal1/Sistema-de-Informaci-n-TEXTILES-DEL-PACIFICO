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
        <script src="../../js/prompt_cxp.js"></script>
        <script src="../../js/prompt_detail.js"></script>
        <script type="text/javascript" src="../../js/jquery.price_format.2.0.min.js"></script>
        <script type="text/javascript" src="../../js/updatePayMethod.js"></script>
        <script type="text/javascript" src="../../js/price_format.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>Cuentas por Pagar</title>
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
                        Cuentas por Pagar
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
                <?php echo '<form method="post" action="../../controllers/ctrlEditCxp.php?id='.$_GET['id'].'">'; ?>                   
                <div class="tituloContenido"><h1>Cuenta por Pagar</h1></div><div class="agregarDato"></div><div class="buscar">
                    <input type="submit" value="Guardar"></div>
                
                <?php                
                if(isset($_GET)){
                $metodoPago; 
                $observations;
                ?>
                <!--<form method="post" action="../../controllers/ctrlEditCxp.php">-->                    
                <?php   
                    require '../../models/CxpImpl.php';
                    require '../../models/ClientImpl.php';                    
                    
                    $objCxpImpl = new CxpImpl();
                    $objClientImpl = new ClientImpl();
                    
                    $cxpNumber;
                    
                    echo '<input type="hidden" id="typeHidden" value="RE">'; ?>
                    
                    <table>
                        <tr>
                            <th colspan="8">CXP</th>                            
                        </tr>
                    
                    <?php
                    foreach ($objCxpImpl->getByCode($_GET['id']) as $valor) {
                        $cxpNumber = $valor->getCode();
                        //$observations = $valor->getObservation()
                        echo '<tr>';
                        echo '<input type="hidden" id="userHidden" value="'.$_SESSION['userCode'].'">';
                        echo '<input type="hidden" id="cxpNumberHidden" value="'.$cxpNumber.'">';
                        echo '<td>CXP No.</td>';                       
                        echo '<td><input class="inp-form" type="number" name="txbCode" id="txbCode" value="'.$valor->getCode().'" readonly></td>';
                        echo '<td>CC/NIT</td>';
                        echo '<td><input class="inp-form" type="text" name="txbCodeClient" id="txbCodeClient" value="'.$valor->getProveedor().'" maxlength="12" required readonly></td>';
                        echo '<td>Cliente</td>';
                        echo '<input type="hidden" id="totalCxp" value="'.$valor->getTotalCuenta().'">';
                        
                        $clientName = $objClientImpl->getNameClient($valor->getProveedor());
                        echo '<td><input class="inp-form" type="text" name="txbCodeClient" value="'.$clientName.'" readonly></td>';
                        echo '<td>Fecha Creación</td>';
                        echo '<td><input class="inp-form" type="text" name="txbDateGeneration" value="'.$valor->getFechaCreacion().'" readonly></td>';
                        echo '</tr>';
                        
                        echo '<tr>';
                        echo '<td>Fecha Vencimiento</td>';
                        echo '<td><input class="inp-form" type="text" name="txbDateVencimiento" value="'.$valor->getFechaVencimiento().'" readonly></td>';
                        echo '<td>Total</td>';
                        echo '<td><input class="inp-form" type="text" name="txbValueTotal" id="txbValueTotalCuenta"  title="Valor Total Cuenta" value="'.number_format($valor->getTotalCuenta(),0).'" readonly></td>';
                        echo '<td>Saldo</td>';
                        echo '<td><input class="inp-form" type="text" name="txbValueSaldoCuenta" id="txbValueSaldoCuenta"  readonly title="Valor Saldo Cuenta" value="'.number_format($valor->getSaldoCuenta(),0).'" ></td>';
                        echo '<td>IVA</td>';
                        echo '<td><input class="inp-form" type="text" name="txbValueIva" id="txbValueIva" title="Valor IVA" placeholder="Valor IVA" value="'.number_format($valor->getIva(),0).'" readonly></td>';
                        echo '</tr>';
                        
                        echo '<tr>';
                        echo '<td>Saldo IVA</td>';
                        echo '<td><input class="inp-form" type="text" name="txbValueSaldoIva" id="txbValueSaldoIva" placeholder="Saldo IVA" title="Valor Saldo IVA" value="'.number_format($valor->getSaldoIva(),0).'" ></td>';
                        echo '<td>Rete ICA</td>';
                        echo '<td><input class="inp-form" type="text" name="txbValueReteIca" id="txbValueReteIca" placeholder="Rete ICA" title="Valor Rete ICA" value="'.number_format($valor->getValorReteICA(),0).'" ></td>';
                        echo '<td>Saldo Rete ICA</td>';
                        echo '<td><input class="inp-form" type="text" name="txbValueSaldoReteIca" id="txbValueSaldoReteIca" placeholder="Saldo Rete ICA" title="Valor Saldo Rete ICA" value="'.number_format($valor->getSaldoReteICA(),0).'" ></td>';
                        echo '<td>Rete Timbre</td>';
                        echo '<td><input class="inp-form" type="text" name="txbValueReteTimbre" id="txbValueReteTimbre" title="Valor Rete Timbre" placeholder="Rete Timbre" value="'.number_format($valor->getValorReteTimbre(),0).'" ></td>';
                        echo '</tr>';
                        
                        echo '<tr>';
                        echo '<td>Saldo Rete Timbre</td>';
                        echo '<td><input class="inp-form" type="text" name="txbValueSaldoReteTimbre" id="txbValueSaldoReteTimbre"  title="Valor Saldo Rete Timbre" placeholder="Saldo Rete Timbre" value="'.number_format($valor->getSaldoReteTimbre(),0).'" ></td>';
                        echo '<td>Pago</td>';
                        echo '<td>';
                        
                        echo '<select name="selectTypePay">';
                            if(strcmp($valor->getTypePay(), "C") == 0)
                            {
                                echo '<option value="E">EFECTIVO</option>';
                                echo '<option value="C" selected>CONSIGNACION</option>';
                            }
                            else{
                                echo '<option value="E" selected>EFECTIVO</option>';
                                echo '<option value="C">CONSIGNACION</option>';
                            }                                     
                        echo '</select>';
                        echo '</td>';
                        
                        echo '</tr>';
                        
                        echo '</table>';
                    }

                ?>
                </form>
                <?php                
                    }
                ?>
                
                <br>
                <div class="encabezadoContenido">
                    <div class="tituloContenido"><h1>Agregar Artículos</h1></div><div class="agregarDato"></div><div class="buscar">
                    </div>                    
                </div>
                
                <div class="listadoStockRemision">                                        
                    <form method="post" action="../../controllers/ctrlInsertDetailCxp.php" id="formInsertArticle">
                        <?php
                            echo '<input type="hidden" name="hiddenCodeCxp" value="'.$cxpNumber.'">';                        
                        ?>
                        <input type="text" name="txbCode" id="txbCode1" placeholder="Referencia" maxlength="16" required>
                        <input type="text" name="txbName" id="txbName" placeholder="Articulo" maxlength="60" required>

                        <input type="number" name="txbQuantity" placeholder="Cantidad" step="0.01" required>                    
                        <input type="text" id="example2" name="txbPriceBuy" placeholder="Precio Costo" maxlength="14" required>
                        <!--<input type="text" value="" id="example2" name="example2">-->

                        <input type="text" name="txbPriceSold" placeholder="Precio Venta" id="example222" maxlength="14">

                        <?php
                            echo '<select name="selectColor" id="selectColor">';
                            include_once '../../models/ColorImpl.php';
                            $objColorImpl = new ColorImpl();

                            foreach ($objColorImpl->getAllOrderName() as $valor) {
                                echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';                        
                            }                    
                            echo '</select>'; 
                        ?>
                        <input type="submit" id="btnInsertarArticulo" value="Añadir">
                    </form><script src="../../js/check_cxp.js"></script> 
                </div>
                
                
                
                
                
                <br><br>
                <h1>Detalles Cuenta por Pagar</h1>
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
                            require '../../models/DetailCxpImpl.php';
                            $objDetailCxpImpl = new DetailCxpImpl();
                            $contDetailCxp = 0;
                            
                            foreach ($objDetailCxpImpl->getByCode($cxpNumber) as $valor) {
                                
                                if($contDetailCxp%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                <?php }
                                
                                        echo '<td id="tdd1'.$contDetailCxp.'">'.$valor->getCodeArticle().'</td>';
                                        echo '<td id="tdd1'.$contDetailCxp.'">'.$objColorImpl->getNameColor($valor->getColor()).'</td>';
                                        echo '<td class="tdDerecha" id="tdd2'.$contDetailCxp.'">'.$valor->getCantidad().'</td>';
                                        echo '<td class="tdDerecha" id="tdd3'.$contDetailCxp.'">';echo number_format($valor->getValorUnitario(),0).'</td>';
                                        echo '<td class="tdDerecha" id="tdd4'.$contDetailCxp.'">';echo number_format($valor->getTotal(),0).'</td>';
                                        
                                                                           
                                    ?>
                                        
                                      <td id="tdAcciones">
                                            <?php
                                            //echo '<img class="imgEditClassDetailCxp" id="'.$contDetailCxp.'" src="../../res/edit-16.png">';                                        
                                            echo '<a href="../../controllers/ctrlDeleteDetailCxp.php?idcxp='.$cxpNumber.'&ida='.$valor->getCodeArticle().'&q='.$valor->getCantidad().'&cl='.$valor->getColor().'"><img src="../../res/x-mark-16.png"></a>';                                                                                    
                                            ?>                                        
                                        </td>
                                </tr>                                                     
                            <?php
                            $contDetailCxp++;
                            }
                            ?>   
                        </table>
                    </form>                                       
                </div>    
                          
                <div class="encabezadoContenido">
                    <div class="tituloContenido" id="pago"></div><div class="agregarDato"></div><div class="buscar">
                        <?php 
                                               
                        echo '<a target="_blank" href="../../controllers/ctrlPrintCxp.php?id='.$cxpNumber.'"><input type="button" value="Imprimir"></a>'; 
                        ?>
                        
                    </div>                    
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
//                require_once '../../models/Credit.php';
//                require_once '../../models/CreditImpl.php';
//                require_once '../../models/CxpImpl.php';
//                $objCxp = new Cxp();
//                $objCxpImpl = new CxpImpl();                                              
//                
//                $objCxp->setCode($_GET['id']);                    
//                $objCxp->setTotalCuenta($objCxpImpl->getValue($_GET['id']));
//                
//              
//                require_once '../../models/CollectCxpImpl.php';
//                $objCollectCxpImpl = new CollectCxpImpl();
//                $totalRecaudado = $objCollectCxpImpl->sumValueByCxp($_GET['id']);
//
//                $objCxp->setSaldoCuenta($objCxp->getTotalCuenta() - $totalRecaudado);                    
//                $objCxpImpl->updateSaldo($objCxp);
                
                

//                $num_rows_credit = $objCreditImpl->checkCodeCxpInCredit($_GET['id']);
//                //si existe el credito ingresa
//                if ($num_rows_credit > 0) {
//                    $objCxpU = new Cxp();
//                    $objCxpU->setCode($_GET['id']);                    
//                    $objCredit->setType("RE");
//                    $objCredit->setValue($objCxpImpl->getValueCxp($objCxpU));
//                    $objCredit->setCodeCxp($_GET['id']);
//                    $objCreditImpl->updateValue($objCredit);
//                    
//                    //actualizar saldo
//                    require_once '../../models/CollectImpl.php';
//                    $totalCredito = $objCredit->getValue();
//                    
//                    $objCollectImpl = new CollectImpl();
//                    
//                    $idCredit = $objCreditImpl->getId($_GET['id'], 'RE');                    
//                    $totalRecaudado = $objCollectImpl->sumValueByBiil($idCredit);
//                    
//                    $objCredit->setCode($idCredit);
//                    $objCredit->setSaldo($totalCredito - $totalRecaudado);                    
//                    $objCreditImpl->updateSaldo($objCredit);
//                    
//                    /*echo 'TOTAL CREDITO: '.$totalCredito.'<br>';
//                    echo 'TOTAL RECAUDADO: '.$totalRecaudado.'<br>';
//                    echo 'TOTAL SALDO: '.($totalCredito - $totalRecaudado).'<br>';*/
//                    
//                }
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