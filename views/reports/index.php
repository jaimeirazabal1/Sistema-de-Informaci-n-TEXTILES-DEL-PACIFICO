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
        <!--<script src="../../js/search.js"></script>-->
        <!--<script src="../../js/reports.js"></script>-->
        <title>Reportes</title>
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
                        Reportes
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
                    <div class="tituloContenido"><h1>Reportes</h1></div><div class="agregarDato">
                        </div><div class="buscar">                              
                        </div>                    
                </div>
                <div class="listado">
                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>REPORTE</th>
                                <th>DESCRIPCION</th>
                                <th>ACCION</th>
                            </tr>
                            <tr>
                                <td>INVENTARIO</td>
                                <td>CONSULTAR INFORMACION DEL INVENTARIO</td>
                                <td id="tdAcciones"><a href="stock.php"><img src="../../res/line-16.png"></a></td>
                                <!--<td><img class="imgEditClass" id="0" src="../../res/line-16.png"></a></td>-->
                            </tr>
                            <tr>
                                <td>INVENTARIO</td>
                                <td>EXISTENCIAS POR ARTICULO</td>
                                <td id="tdAcciones"><a href="article.php"><img src="../../res/line-16.png"></a></td>
                            </tr>
                            <tr>
                                <td>INVENTARIO</td>
                                <td>EXISTENCIAS ALGODON</td>
                                <td id="tdAcciones"><a href="algodon.php"><img src="../../res/line-16.png"></a></td>
                            </tr>
                            <tr>
                                <td>INVENTARIO</td>
                                <td>EXISTENCIAS RAYAS</td>
                                <td id="tdAcciones"><a href="rayas.php"><img src="../../res/line-16.png"></a></td>
                            </tr>
                            <tr>
                                <td>INVENTARIO</td>
                                <td>EXISTENCIAS VISCOSA</td>
                                <td id="tdAcciones"><a href="viscosa.php"><img src="../../res/line-16.png"></a></td>
                            </tr>
                            <tr>
                                <td>INVENTARIO</td>
                                <td>EXISTENCIAS ESMERILADA</td>
                                <td id="tdAcciones"><a href="esmerilada.php"><img src="../../res/line-16.png"></a></td>
                            </tr>
                            <tr>
                                <td>INVENTARIO</td>
                                <td>MOVIMIENTOS POR ARTICULO</td>
                                <td id="tdAcciones"><a href="movimientos.php"><img src="../../res/line-16.png"></a></td>
                            </tr>
                            <tr>
                                <td>INVENTARIO</td>
                                <td>MOVIMIENTOS KARDEX</td>
                                <td id="tdAcciones"><a href="kardex.php"><img src="../../res/line-16.png"></a></td>
                            </tr>                            
                            <tr>
                                <td>VENTAS</td>
                                <td>VENTAS ALGODON X COLOR - KGS</td>
                                <td id="tdAcciones"><a href="ventasalgodon.php"><img src="../../res/line-16.png"></a></td>
                            </tr>
                            <tr>
                                <td>VENTAS</td>
                                <td>VENTAS RAYAS X COLOR - KGS</td>
                                <td id="tdAcciones"><a href="ventasrayas.php"><img src="../../res/line-16.png"></a></td>
                            </tr>
                            <tr>
                                <td>VENTAS</td>
                                <td>VENTAS VISCOSA X COLOR - KGS</td>
                                <td id="tdAcciones"><a href="ventasviscosa.php"><img src="../../res/line-16.png"></a></td>
                            </tr>
                            <tr>
                                <td>CONTABLE</td>
                                <td>ARQUEO CAJA</td>
                                <td id="tdAcciones"><a href="arqueocaja.php"><img src="../../res/line-16.png"></a></td>
                            </tr>
                            <tr>
                                <td>CONTABLE</td>
                                <td>ARQUEO CAJA DETALLADO</td>
                                <td id="tdAcciones"><a href="arqueocajaDetalle.php"><img src="../../res/line-16.png"></a></td>
                            </tr>
                            <tr>
                                <td>REMISIONES</td>
                                <td>INFORMACION DE REMISIONES</td>
                                <td id="tdAcciones"><a href="bill.php"><img src="../../res/line-16.png"></a></td>
                            </tr>                            
                            <tr>
                                <td>UTILIDAD</td>
                                <td>INFORMACION RELACIONADA CON LA UTILIDAD</td>
                                <td id="tdAcciones"><a href="utility.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>
                            <tr>
                                <td>ESTADO DE CUENTA</td>
                                <td>ESTADO DE CUENTA X CLIENTE</td>
                                <td id="tdAcciones"><a href="state_account.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>
                            <tr>
                                <td>ESTADO DE CUENTA</td>
                                <td>RESUMEN ESTADO DE CUENTA X CLIENTE</td>
                                <td id="tdAcciones"><a href="state_account_resumen.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>
                            <tr>
                                <td>ESTADO DE CUENTA GENERAL</td>
                                <td>ESTADO DE CUENTA GENERAL</td>
                                <td id="tdAcciones"><a href="state_account_general.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>
                            <tr>
                                <td>FUERZA DE VENTAS</td>
                                <td>EFICIENCIA VENDEDORES</td>
                                <td id="tdAcciones"><a href="seller.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>
                            <tr>
                                <td>COMISIONES VENDEDORES</td>
                                <td>COMISIONES VENDEDORES</td>
                                <td id="tdAcciones"><a href="comisiones_vendedores.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>
                            <tr>
                                <td>RECAUDOS</td>
                                <td>RECIBOS DE CAJA</td>
                                <td id="tdAcciones"><a href="recaudos.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>
                            <tr>
                                <td> 
                                GASTOS
                                </td>
                                <td>GASTOS</td>
                                <td id="tdAcciones"><a href="gastos.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>
<!--                            <tr>
                                <td>CODIGO DE BARRAS</td>
                                <td>IMPRESION MASIVA DE CODIGOS DE BARRAS</td>
                                <td id="tdAcciones"><a href="codebars.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>-->
<!--                            <tr>
                                <td>ESTADO DE CUENTA</td>
                                <td>ESTADO DE CUENTA X CLIENTE</td>
                                <td id="tdAcciones"><a href="state_account.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>
                            <tr>
                                <td>ESTADO DE CUENTA GENERAL</td>
                                <td>ESTADO DE CUENTA GENERAL</td>
                                <td id="tdAcciones"><a href="state_account_general.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>
                            <tr>
                                <td>GASTOS</td>
                                <td>GASTOS DE LA DISTRIBUIDORA</td>
                                <td id="tdAcciones"><a href="spend.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>-->
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
    echo '<script>document.location.href = "http://'.$ip.'/tp/login.php"; </script>';    
}
?>