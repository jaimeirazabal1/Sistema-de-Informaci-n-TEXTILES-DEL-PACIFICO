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
        <script src="../../js/prompt_note.js"></script>
        <script type="text/javascript" src="../../js/jquery.price_format.2.0.min.js"></script>
        <script type="text/javascript" src="../../js/price_format.js"></script>
        <script src="../../js/updatePayMethod.js"></script>
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
                        <a href="../../">Sistema de Información MIOS SPORT</a>                        
                    </div><div class="arrowImgRight">
                        <img src="../../res/arrow-25-16.png">
                    </div><div class="opcionSeleccionada">
                        Notas Crédito
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
                <h1>Agregar Nota</h1>
                
                                
                <div class="encabezadoContenido">
                    <div class="tituloContenido"><h1>Seleccionar Remisión</h1></div><div class="agregarDato"></div><div class="buscar">
                            <input type="text" id="txbSearchRemisionNotes" placeholder="Buscar...">
                    </div>                    
                </div>
                
                <div class="listadoRemisionRemision">
                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>REMISION</th>
                                <th>CLIENTE</th>
                                <th class="tdNoVisible">TIPO ID</th>
                                <th>TIPO</th>
                                <th>NIT/CC</th>
                                <th>FECHA</th>                                
                                <th>VALOR</th>   
<!--                                <th>SALDO</th>                                -->
                                <th>ACCION</th>
                            </tr>
                            
                            <?php
                            require '../../models/RemisionImpl.php';
                            require '../../models/ClientImpl.php';
                            require '../../models/TypeClientImpl.php';
                            $objRemisionImpl = new RemisionImpl();
                            $objTypeClientImpl = new TypeClientImpl();
                            $cont = 0;
                            
                            foreach ($objRemisionImpl->getAllLimit() as $valor) {
                                /*$quantityAvailable = $objRemisionImpl->getQuantityAvailable($valor->getCode());
                                $quantitySale = $objRemisionImpl->getQuantitySale($valor->getCode());
                                $totalCantidad = $quantityAvailable - $quantitySale; */
                                
                                $objClientImpl = new ClientImpl();
                                
                                if($cont%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                <?php }?>
                                    <?php echo '<td class="tdDerecha" id="td1'.$cont.'">'.$valor->getCode(); ?></td>                                
                                    <?php echo '<td id="td2'.$cont.'">'.$objClientImpl->getNameClient($valor->getClient()); ?></td>
                                     <?php 
                                        $idTC = $objClientImpl->getTypeClient($valor->getClient());
                                        echo '<td class="tdNoVisible" id="td6'.$cont.'">'.$idTC; 
                                        echo '<td id="td7'.$cont.'">'.$objTypeClientImpl->getNameTypeClient($idTC); 
                                     ?></td>
                                    <?php echo '<td class="tdDerecha" id="td3'.$cont.'">'.$valor->getClient(); ?></td>                                
                                    <?php echo '<td id="td4'.$cont.'">'.$valor->getGenerationDate(); ?></td>                                
                                    <?php echo '<td class="tdDerecha" id="td5'.$cont.'">'.number_format($valor->getValueSale()); ?></td>                                
                                    <?php //echo '<td class="tdDerecha" id="td6'.$cont.'">'.number_format($valor->getSaldo()); ?></td>                                

                                    
                                    
                                    <td id="tdAcciones">
                                        <?php                                        
                                        //echo '<a id="articleDetail1" href="edit_detail.php?idf='.$billNumber.'&ida='.$valor->getCode().'&n='.$valor->getName().'&pc='.$priceBuy.'"><img id="imgEdit1" src="../../res/add-list-16.png"></a>';                                        
                                        //echo '<img class="imgEditClass" id="'.$cont.'" src="../../res/add-list-16.png">';                                        
                                        echo '<a href="../notes/add_ntcr.php?idf='.$valor->getCode().'"> <img id="'.$cont.'" src="../../res/add-list-16.png"></a>';                                                                                
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
                
                
                <div class="contenidoNota">
                    
                </div>
                <div class="detallesNota">
                    <form id="formSubmit" method="post" action="../../controllers/ctrlInsertNote.php">                        
                        <br>
                        <h1>AGREGAR NOTA</h1><br>
                        
                        <?php
                        echo '<input type="hidden" name="hiddenCodeRemision" id="hiddenCodeRemision">';        
                        ?>
                        <select name="selectTypeNote" id="selectTypeNote">                           
                        </select>
                        <br>
                        <input type="text" id="example2" class="txbValue" name="txbValue" placeholder="VALOR" maxlength="14" required><br>
                        <input id="txbObservations" name="txbObservations" type="text" placeholder="OBSERVACIONES" maxlength="200">
                        
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