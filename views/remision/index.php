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
        <title>Remisiones</title>
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
                <div class="encabezadoContenido">
                    <div class="tituloContenido"><h1>Gestión Remisiones</h1></div><div class="agregarDato">
                        <a href="add_remision.php"><input type="button" value="Crear Remisión"></a></div><div class="buscar">
                            <input type="number" id="txbSearchRemision" placeholder="Buscar...">
                        </div>                    
                </div>
                <div class="listado">
                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>CODIGO</th>
                                <th>CLIENTE</th>
                                <th>IDENTIFICACION</th>
                                <th>FECHA CREACION</th>
                                <th>VALOR</th>
                                <th>ACCION</th>
                            </tr>
                            
                            <?php
                            require '../../models/RemisionImpl.php';
                            require '../../models/ClientImpl.php';                            
                            $objRemisionImpl = new RemisionImpl();
                            $cont = 0;
                            
                            foreach ($objRemisionImpl->getAll() as $valor) {
                                $objClientImpl = new ClientImpl();
                                $cliente = $objClientImpl->getNameClient($valor->getClient());
                                
                                if($cont%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                <?php }?>
                                    <td><?php echo $valor->getCode(); ?></td>
                                    <td><?php echo $cliente ?></td>
                                    <td><?php echo $valor->getClient(); ?></td>
                                    <td><?php echo $valor->getGenerationDate(); ?></td>
                                    <td class="tdDerecha"><?php echo number_format($valor->getValueSale()); ?></td>
                                    
                                    
                                    
                                    
                                    <td id="tdAcciones">
                                        <?php
                                        echo '<a href="view_remision.php?id='.$valor->getCode().'"><img src="../../res/open-in-browser-16.png"></a>';
                                        echo '<a href="edit_remision.php?id='.$valor->getCode().'"><img src="../../res/edit-16.png"></a>';
                                        
                                        /*if(strcmp ($valor->getState(), 'AC') == 0 || strcmp ($valor->getState(), 'ac') == 0)
                                           echo '<a href="../../controllers/ctrlCancelRemision.php?id='.$valor->getCode().'&ac"><img src="../../res/x-mark-16.png"></a>'; 
                                        else if(strcmp ($valor->getState(), 'IN') == 0 || strcmp ($valor->getState(), 'in') == 0)
                                           echo '<a href="../../controllers/ctrlCancelRemision.php?id='.$valor->getCode().'&in"><img src="../../res/check-mark-16.png"></a>'; */
                                        echo '<a target="_blank" href="../../controllers/ctrlPrintRemisionBill.php?id='.$valor->getCode().'"><img src="../../res/printer-2-16.png"></a>';     
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