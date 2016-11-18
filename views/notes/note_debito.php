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
        <script src="../../js/prompt_devol_de.js"></script>
        <script type="text/javascript" src="../../js/updateObservationNote.js"></script>
        <title>Notas</title>
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
                        Notas
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
                <h1>Nota</h1>
                
                <?php                
                if(isset($_GET)){?>
                <form method="post" action="../../controllers/ctrlInsertNoteCredit.php">
                <?php   
                    require '../../models/CxpImpl.php';
                    $objCxpImpl = new CxpImpl();
                    
                    require '../../models/NoteImpl.php';
                    $objNoteImpl = new NoteImpl();
                    
                    $billNumber;
                    $noteNumber;
                    $observations;
                    ?>
                    <table>
                    <?php
                    foreach ($objNoteImpl->getByCode($_GET['idn']) as $valor) {
                        $noteNumber = $valor->getCode();
                        echo '<input type="hidden" name="hiddenNote" id="hiddenNote" value="'.$noteNumber.'">';
                        $observations = $valor->getObservation();
                    ?>
                    
                            <tr>
                                <th>NOTA No</th>
                                <th>CXP No.</th>
                                <th>FECHA</th>
                                <th>TIPO</th>
                                <th>VALOR</th>    
                                <th>IVA</th>
                            </tr>
                            
                            <?php
                            if($cont%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                <?php }
                                ?>
                                        <td id="tdCodeNote"><?php echo $valor->getCode(); ?></td>
                                        <td><?php echo $valor->getCodeBill(); ?></td>
                                        <td><?php echo $valor->getRegistrationDate(); ?></td>
                                        <td><?php echo $valor->getTypeNote(); ?></td>
                                        <td class="tdDerecha"><?php echo number_format($valor->getValue(),0); ?></td>                                                 
                                        <td class="tdDerecha"><?php echo number_format($valor->getValueIva(),0); ?></td>                                        
                                </tr>                                                     
                            <?php
                            $cont++;
                            }
                            ?>
                            
                            
                    </table>
                    <br>
                    <h1>Cuenta x Pagar</h1>
                
                    
                    <table>
                    <?php
                    foreach ($objCxpImpl->getByCode($_GET['idf']) as $valor) {
                        $billNumber = $valor->getCode();
                        echo '<input type="hidden" name="hiddenBill" id="hiddenBill" value="'.$billNumber.'">';
                        require '../../models/ClientImpl.php';
                        $objClientImpl = new ClientImpl();
                        $client = $objClientImpl->getNameClient($valor->getProveedor());
                        
                    ?>
                        <br>
                            <tr>
                                <th>NIT/CC</th>
                                <th>CLIENTE</th>
                                <th>FECHA</th>
                                <th>VENTA</th>    
                                <th>IVA</th>
                            </tr>
                            
                            <?php
                            if($cont%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                <?php }
                                ?>
                                        <td><?php echo $valor->getProveedor(); ?></td>
                                        <td><?php echo $client; ?></td>
                                        <td><?php echo $valor->getFechaCreacion(); ?></td>
                                        <td class="tdDerecha"><?php echo number_format($valor->getTotalCuenta(),0); ?></td>                                                 
                                        <td class="tdDerecha"><?php echo number_format($valor->getIva(),0); ?></td>                                        
                                </tr>                                                     
                            <?php
                            $cont++;
                            }
                            ?>
                            
                            
                    </table>   
                        
                   
                </form>
                <?php                
                    }
                ?>
                
                
                
                <div class="encabezadoContenido">
                    <div class="tituloContenido"><h1>Detalles</h1></div><div class="agregarDato"></div><div class="buscar">                            
                    </div>                    
                </div>
                
                
                <div class="listado">                                        
                    <form method="post" action="../../controllers/ctrlInsertNoteCredit.php">
                        <table>
                            <tr>
                                <th>REFERENCIA</th>
                                <th>ARTICULO</th>
                                <th>COLOR</th>
                                <th>CANTIDAD</th>
                                <th>VALOR UNITARIO</th>
                                <th>VALOR TOTAL</th>                                
                                <th class="tdNoVisible">FECHA</th>
                                <th class="tdNoVisible">ID COLOR</th>
                                <th>ACCION</th>    
                            </tr>
                            
                            <?php
                            require '../../models/DetailCxpImpl.php';
                            require '../../models/StockImpl.php';
                            require '../../models/ColorImpl.php';
                            $objColorImpl = new ColorImpl();
                            
                            $objDetailCxpImpl = new DetailCxpImpl();
                            $cont = 0;
                            
                            foreach ($objDetailCxpImpl->getByCodeNoDevolucion($billNumber) as $valor) {
                                
                                
                                if($cont%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                <?php }
                                
                                $objStockImpl = new StockImpl();
                                $article = $objStockImpl->getNameArticle($valor->getCodeArticle());
                                $idColor = $valor->getColor();
                                ?>
                                        <?php echo'<td id="td1'.$cont.'">'.$valor->getCodeArticle().'</td>
                                        <td id="td2'.$cont.'">'.$article.'</td>                                        
                                        <td class="tdDerecha" id="td3'.$cont.'">'.$objColorImpl->getNameColor($idColor).'</td>
                                        <td class="tdDerecha" id="td4'.$cont.'">'.($valor->getCantidad() - $valor->getDevolucion()).'</td>
                                        <td class="tdDerecha" id="td5'.$cont.'">'.number_format($valor->getValorUnitario(),0).'</td>
                                        <td class="tdDerecha" id="td6'.$cont.'">'.number_format($valor->getTotal(),0).'</td>
                                        <td class="tdNoVisible" id="td7'.$cont.'">'.$valor->getFechaCreacion().'</td>
                                        <td class="tdNoVisible" id="td8'.$cont.'">'.$valor->getColor().'</td>'; ?>         
                                        <?php
                                        //echo '<td id="tdAcciones"><a href="../../controllers/ctrlInsertNoteDebito.php?idf='.$valor->getCodeCxp().'&ida='.$valor->getCodeArticle().'&cl='.$valor->getColor().'&f='.$valor->getFechaCreacion().'&idn='.$_GET['idn'].'"> <img id="'.$cont.'" src="../../res/undo-2-16.png"></a></td>';
                                        echo '<td id="tdAcciones"><img class="imgEditClass" id="'.$cont.'" src="../../res/undo-2-16.png"></td>' 
                                        ?>                                       
                                </tr>   
                                
                            <?php
                            $cont++;
                            }
                            ?>   
                        </table>
                    </form>                                       
                    
                 
                </div>                                
                
                <?php echo '<br><br><textarea placeholder="Observaciones de la nota" name="txaObservation" id="txa-lg">'.$observations.'</textarea>'; ?>
                
                
                <div class="encabezadoContenido">
                    <div class="tituloContenido"></div><div class="agregarDato"></div><div class="buscar">
                        <?php // echo '<a target="_blank" href="../../controllers/ctrlPrintCxpBill.php?id='.$billNumber.'"><input type="button" value="Imprimir"></a>'; ?>
                    </div>                    
                </div>
                
                <div class="contenidoDevoluciones">                    
                </div>
                <div class="detallesDevolucion">
                    <form id="formSubmit" method="post" action="../../controllers/ctrlInsertNoteDebito.php">                        
                        <br>
                        <h1>DEVOLUCIONES</h1><br>
                        
                        <!--<input type="text" id="example2" class="txbValue" name="txbValue" placeholder="VALOR" maxlength="14" required><br>-->
                        <input id="txbRegresar" name="txbRegresar" type="number" step="0.01" placeholder="CANTIDAD" required>
                        <input type="hidden" name="hiddenIdn" id="hiddenIdn">
                        <input type="hidden" name="hiddenIdf" id="hiddenIdf">
                        <input type="hidden" name="hiddenIda" id="hiddenIda">
                        <input type="hidden" name="hiddenFc" id="hiddenFc">
                        <input type="hidden" name="hiddenCl" id="hiddenCl">
                        <input type="hidden" name="hiddenValUnit" id="hiddenValUnit">
                        
                        <p id="pDisponibles"></p>
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