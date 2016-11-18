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
                if(isset($_GET)){?>
                <form method="post" action="../../controllers/ctrlEditRemision.php">
                <?php   
                    require '../../models/RemisionImpl.php';
                    $objRemisionImpl = new RemisionImpl();
                    
                    $billNumber;
                    $observations;
                    ?>
                    <table>
                    <?php
                    foreach ($objRemisionImpl->getByCode($_GET['id']) as $valor) {
                        $billNumber = $valor->getCode();
                        $observations = $valor->getObservation();
                        require '../../models/ClientImpl.php';
                        $objClientImpl = new ClientImpl();
                        $client = $objClientImpl->getNameClient($valor->getClient());
                        
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
                                        <td><?php echo $valor->getCodeArticle() ?></td>
                                        <td><?php echo $article; ?></td>
                                        <td class="tdDerecha"><?php echo $valor->getQuantity() ?></td>
                                        <td class="tdDerecha"><?php echo number_format($valor->getValueUnit(),0); ?></td>
                                        <td class="tdDerecha"><?php echo number_format($valor->getTotal(),0); ?></td>         
                                </tr>                                                     
                            <?php
                            $cont++;
                            }
                            ?>   
                        </table>
                    </form>                                       
                    
                 
                </div>                                
                
                <?php echo '<br><br><textarea placeholder="Observaciones" readonly name="txaObservation" id="txa-lg">'.$observations.'</textarea>'; ?>
                
                
                <div class="encabezadoContenido">
                    <div class="tituloContenido"></div><div class="agregarDato"></div><div class="buscar">
                        <?php echo '<a target="_blank" href="../../controllers/ctrlPrintRemisionBill.php?id='.$billNumber.'"><input type="button" value="Imprimir"></a>'; ?>
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