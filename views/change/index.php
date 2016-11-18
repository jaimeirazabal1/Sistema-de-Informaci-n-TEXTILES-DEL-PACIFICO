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
                <div class="encabezadoContenido">
                    <div class="tituloContenido"><h1>Gestión Cambios Remisiones</h1></div><div class="agregarDato">
                        <a href="index.php"><input type="button" value="Cambios Facturas"></a></div><div class="buscar">
                            <input type="number" id="txbSearchRemisionChange" placeholder="Buscar...">
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
                                        echo '<a href="view_remision.php?id='.$valor->getCode().'"><img src="../../res/undo-2-16.png"></a>';
                                        ?>
                                    </td>  
                                </tr>                                                     
                            <?php
                            $cont++;
                            }?>   
                                
                        </table>
                    </form> 
                                       
                    
                </div>
            </section>
            <footer>
                <div class="contenedorRutaSoporte">
                    <div class="opcionSeleccionadaSoporte">
                        Mios Sport In
                    </div><div class="arrowImgLeft">
                        <img src="../../res/arrow-89-16.png">
                    </div><div class="nombreDesarrollador">
                        Soporte y Desarrollo
                    </div>
                </div>
                <nav id="menu">
                    <ul>
                        <li><a href="#"><img src="../../res/mobile-phone-8-16.png">(+57) 300 xxx xx xx</a></li>
                        <li><a href="#"><img src="../../res/email-16.png">comercial@miossport.com</a></li>
                    </ul>
                </nav>
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