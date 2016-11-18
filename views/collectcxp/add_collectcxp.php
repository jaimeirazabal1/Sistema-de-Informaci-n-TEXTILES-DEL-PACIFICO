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
        <script src="../../js/prompt_collect_cxp.js"></script>
        <script type="text/javascript" src="../../js/jquery.price_format.2.0.min.js"></script>
        <script type="text/javascript" src="../../js/price_format.js"></script>
        <script src="../../js/updatePayMethod.js"></script>
        <title>Cuentas por Pagar</title>
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
                <h1>Agregar Pago Cuenta por Pagar</h1>
                
                                
                <div class="encabezadoContenido">
                    <div class="tituloContenido"><h1>Seleccionar CxP</h1></div><div class="agregarDato"></div><div class="buscar">
                            <input type="text" id="txbSearchCxpInCollect" placeholder="Buscar...">
                    </div>                    
                </div>
                
                <div class="listadoCreditBill">
                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>CODIGO</th>
                                <th>PROVEEDOR</th>
                                <th>IDENTIFICACION</th>
                                <th>FECHA CREACION</th>
                                <th>VALOR</th>
                                <th>SALDO</th>
                                <th>ACCION</th>
                            </tr>
                            
                            <?php
                            require '../../models/CxpImpl.php';
                            require '../../models/ClientImpl.php';                            
                            $objCxpImpl = new CxpImpl();
                            $cont = 0;
                            
                            foreach ($objCxpImpl->getByStateGE() as $valor) {
                                $objClientImpl = new ClientImpl();
                                $cliente = $objClientImpl->getNameClient($valor->getProveedor());
                                
                                if($cont%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                <?php }?>
                                        
                                    <?php echo '<td id="td1'.$cont.'">'.$valor->getCode(); ?></td>                                
                                    <?php echo '<td id="td2'.$cont.'">'.$cliente; ?></td>    
                                    <?php echo '<td id="td3'.$cont.'">'.$valor->getProveedor(); ?></td>    
                                    <?php echo '<td id="td4'.$cont.'">'.$valor->getFechaCreacion(); ?></td>    
                                    <?php echo '<td id="td5'.$cont.'">'.number_format($valor->getTotalCuenta()); ?></td>    
                                    <?php echo '<td id="td6'.$cont.'">'.number_format($valor->getSaldoCuenta()); ?></td>                                        
                                                                     
                                    
                                    <td id="tdAcciones">
                                        <?php
                                        echo '<img class="imgEditClass" id="'.$cont.'" src="../../res/add-list-16.png">';                                        
                                        ?>                                         
                                    </td>  
                                </tr>                                                     
                            <?php
                            $cont++;
                            }
                            ?>   
                        </table>
                    </form> 
                </div>
                
                
                <div class="contenidoRecaudo">
                    
                </div>
                <div class="detallesRecaudo">
                    <form id="formSubmit" method="post" action="../../controllers/ctrlInsertCollectCxp.php">                        
                        <br>
                        <h1>RECAUDAR</h1><br>
                        
                        <?php
                        echo '<input type="hidden" name="hiddenCodeCxp" id="hiddenCodeCxp">';        
                        ?>
                        
<!--                        <input type="hidden" name="hiddenName" id="hiddenName">
                        <input type="hidden" name="hiddenPriceBuy" id="hiddenPriceBuy">
                        <input type="hidden" name="hiddenPriceSale" id="hiddenPriceSale">
                        
                        <input type="hidden" name="hiddenPriceSale" id="hiddenAuxAvailable">-->
                        
                    
                        <input type="text" id="example2" class="txbValue" autocomplete="off" name="txbValue" placeholder="VALOR" maxlength="14" required><br>
                        <input id="txbObservations" name="txbObservations" type="text" placeholder="OBSERVACIONES" maxlength="200">
                        <select name="selectTypePay">
                            <option value="E">Efectivo</option>
                            <option value="C">Consignación</option>
                        </select>
                        <input type="hidden" name="hiddenSaldo" id="hiddenSaldo">
                        <input type="hidden" name="hiddenType" id="hiddenType">
                        <input type="hidden" name="hiddenValAux" id="hiddenValAux">
                        
                        <p id="pValor"></p>
                        <p id="pSaldo"></p>
                        <p id="pMensaje"></p><br>
                        <input id="btnSubmit" type="submit" value="Guardar" disabled>
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
    echo '<script>document.location.href = "http://'.$ip.'/dischiguiro/login.php"; </script>';    
}
?>