<?php
session_start();

include '../../com/server.php';
$server = new SimpleXMLElement($xmlstr);
$ip = $server->server[0]->ip;

if (!empty($_SESSION['userCode']) && !empty($_SESSION['userName']))
{
    require '../../models/SystemImpl.php';
    $objSystemImpl = new SystemImpl();
    $iva = $objSystemImpl->getValue(1);
    
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
        <script src="../../js/prompt_cambio.js"></script>
        <title>Cambios</title>
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
                        Cambios
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
                <h1>Remision</h1>
                
                <?php                
                if(isset($_GET)){                                 
                ?>
                <form method="post" action="../../controllers/ctrlEditRemision.php">
                <?php   
                    require '../../models/RemisionImpl.php';
                    $objRemisionImpl = new RemisionImpl();
                    
                    $billNumber;
                    ?>
                    <table>
                    <?php
                    foreach ($objRemisionImpl->getByCode($_GET['id']) as $valor) {
                        $billNumber = $valor->getCode();
                        
                        require '../../models/ClientImpl.php';
                        $objClientImpl = new ClientImpl();
                        $client = $objClientImpl->getNameClient($valor->getClient());
                        
                        echo '<input type="hidden" id="ocultoDocCliente" value="'.$valor->getClient().'">'
                        
                    ?>
                    
                            <tr>
                                <th>REMISION No</th>
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
                                        <td><?php echo $valor->getCode(); ?></td>
                                        <td><?php echo $valor->getClient(); ?></td>
                                        <td><?php echo $client; ?></td>
                                        <td><?php echo $valor->getGenerationDate(); ?></td>
                                        <td class="tdDerecha"><?php echo number_format($valor->getValueSale(),0); ?></td>                                                 
                                        <td class="tdDerecha"><?php echo number_format($valor->getValueIVA(),0); ?></td>                                        
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
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>REFERENCIA</th>
                                <th>ARTICULO</th>
                                <th>CANTIDAD</th>
                                <th>VALOR UNITARIO</th>
                                <th>VALOR TOTAL</th>   
                                <th class="tdNoVisible">COLOR</th>
                                <th>ACCION</th>
                                
                            </tr>
                            
                            <?php
                            require '../../models/DetailRemisionImpl.php';
                            require '../../models/StockImpl.php';
                            
                            
                            
                            
                            $objDetailRemisionImpl = new DetailRemisionImpl();
                            $cont = 0;
                            
                            foreach ($objDetailRemisionImpl->getByCode($billNumber) as $valor) {
                                
                                
                                if($cont%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                <?php }
                                
                                $objStockImpl = new StockImpl();
                                $article = $objStockImpl->getNameArticle($valor->getCodeArticle());
                                
                                ?>
                                        <?php 
                                        echo '<td id="td1'.$cont.'">'.$valor->getCodeArticle().'</td>';
                                        echo '<td id="td2'.$cont.'">'.$article.'</td>';                                        
                                        echo '<td id="td3'.$cont.'" class="tdDerecha">'.$valor->getQuantity().'</td>';
                                        echo '<td id="td4'.$cont.'" class="tdDerecha">'.number_format($valor->getValueUnit(),0).'</td>';
                                        echo '<td id="td5'.$cont.'" class="tdDerecha">'.number_format($valor->getTotal(),0).'</td>';
                                        echo '<td class="tdNoVisible" id="td6'.$cont.'">'.$valor->getColor().'</td>'; ?>                                                                               
                                        
                                        <td id="tdAcciones">
                                        <?php
                                        echo '<img src="../../res/undo-2-16.png" class="imgCambio" id="'.$cont.'">';
                                        ?>
                                    </td>
                                </tr>                                                     
                            <?php
                            $cont++;
                            }
                            ?>                                  
                            
                        </table>
                        <?php
                            echo '<input type="hidden" value="'.$iva.'" id="txbHiddenIva">';
                        ?>   
                    </form>                                       
                    
                 
                </div>                                
                
                <div class="jump"></div>
                
                
                <div class="encabezadoContenido">
                    <div class="tituloContenido"><h1>Artículos a cambiar</h1></div><div class="agregarDato"></div><div class="buscar">                            
                    </div>                    
                </div>
                
                <div class="listado">                                        
                    <form method="post" action="">
                        <table id="tableChangeRemision">
                            <tr>
                                <th>REFERENCIA</th>
                                <th>ARTICULO</th>
                                <th>CANTIDAD</th>
                                <th>VALOR UNITARIO</th>
                                <th>VALOR TOTAL</th>    
                                <th class="tdNoVisible">COLOR</th>
                            </tr>                            
                        </table>
                        <input type="hidden" value="0" id="txbHiddenTotalCambio" name="txbHiddenTotalCambio">
                    </form>
                </div>
                
                <div class="jump"></div>
                
                <div class="encabezadoContenido">
                    <div class="tituloContenido"><h1 id="h1Total">Total canjeable sin IVA: $ 0</h1></div><div class="agregarDato"></div><div class="buscar">
                        <?php echo '<input type="button" id="btnChangeFinRemision" value="Cambiar">'; ?>                        
                    </div>                    
                </div> 
                
            </section>
            
            
            
            <div class="contenidoDevueltas">
                    
            </div>
            <div class="detallesDevueltas">
                <form>                        
                    <br>
                    <h1>CANTIDAD A CAMBIAR</h1><br>
                    <input id="txbCantidadCambiar" min="0.01" type="number" step="0.01" required>
                    <input id="btnAddChangeRemision" type="button" value="Agregar">
                    <p id="pMensajeDevuelta"></p><br>                        
                </form>
            </div>
            
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
    echo '<script>document.location.href = "http://'.$ip.'/dischiguiro/login.php"; </script>';    
}
?>