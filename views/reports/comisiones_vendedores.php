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
        <script src="../../js/forms.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <script type="text/javascript" src="../../js/jsPDF-master/dist/jspdf.debug.js"></script>
        <script type="text/javascript" src="../../js/jsPDF-master/examples/js/basic.js"></script>
        <title>Reporte Vendedoras</title>
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
            
            <section class="contenido" id="contenidoGeneral2">
            <br>
            <br>
                <h1>COMISIONES VENDEDORES</h1>
                   <?php require_once("../../models/ClientImpl.php") ?>    
                   <?php $client = new ClientImpl() ?>     
                   <?php $vendedores = $client->get_vededores() ?>
                   <?php  ?>
                <?php
                if($_POST)
                {?>
                    <form id="comisiones_vendedores" action="" method="post">
                        <?php 
                        echo '<input id="txbFechaInicio"  name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$_POST['txbFechaInicio'].'">'; 
                        echo '<input id="txbFechaFin" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$_POST['txbFechaFin'].'">';                        
                        ?> 
                        <select name="codigo_vendedor" id="">
                            <option value="">Seleccione</option>
                            <?php foreach ($vendedores as $key => $value): ?>
                                <?php if ($_POST['codigo_vendedor'] == $value['VENTCCODIG']): ?>
                                <option value="<?php echo $value['VENTCCODIG'] ?>" selected><?php echo $value['VENTCCODIG'] ?> - <?php echo $value['VENTCNOMBR'] ?></option>

                                <?php else: ?>
                                <option value="<?php echo $value['VENTCCODIG'] ?>"><?php echo $value['VENTCCODIG'] ?> - <?php echo $value['VENTCNOMBR'] ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>                        
                        <input id="btnConsultarSeller" type="submit" value="Consultar">
                        <input id="btnConsultarPDF" type="submit"  value="Generar PDF">
                    </form>    
                <?php
                }
                else
                {?>
                    <form id="comisiones_vendedores" action="" method="post">
                        <?php 
                        $dateNow = date("Y-m-d");
                        echo '<input id="txbFechaInicio" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$dateNow.'">'; 
                        echo '<input id="txbFechaFin"  name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$dateNow.'">';
                        
                        ?>                
                        <select name="codigo_vendedor" id="">
                            <option value="">Seleccione</option>
                            <?php foreach ($vendedores as $key => $value): ?>
                                <option value="<?php echo $value['VENTCCODIG'] ?>"><?php echo $value['VENTCCODIG'] ?> - <?php echo $value['VENTCNOMBR'] ?></option>
                            <?php endforeach ?>
                        </select>        
                        <input id="btnConsultarSeller" type="submit" value="Consultar">
                        <input id="btnConsultarPDF" type="submit"  value="Generar PDF">
                    </form>
                <?php
                }
                ?>
                
            </section>
      
            <section class="contenido" id="contenidoGeneral2">                
                <div class="listado">                                      
                   <table id="table_to_pdf">
                       <thead>
                           <th>CÓDIGO VENDEDOR</th>
                           <th>NOMBRE VENDEDOR</th>
                           <th>FECHA GENERACIÓN DEL CRÉDITO</th>
                           <th>FECHA CANCELACIÓN DEL CRÉDITO</th>
                           <th>CÓDIGO REMISIÓN</th>
                           <th>NOMBRE DEL CLIENTE</th>
                           <th>VALOR DEL CRÉDITO</th>
                           <th>VALOR COMISIÓN</th>
                       </thead>
                       <?php $comisiones = $client->get_comisiones_vendedores() ?>
                       <?php $credivalor = 0; ?>
                       <?php $comision = 0; ?>
                      <?php foreach ($comisiones as $key => $value): ?>
                        <tr>
                          <td><?php echo $value["VENDECODIG"] ?></td>
                          <td><?php echo $value["VENTCNOMBR"] ?></td>
                          <td><?php echo $value["VENDEFECGE"] ?></td>
                          <td><?php echo $value["CREDIFECCA"] ?></td>
                          <td><?php echo $value["VENDEFACTU"] ?></td>
                          <td><?php echo $value["CLIENNOMBR"] ?></td>
                          <td><?php echo number_format($value["CREDIVALOR"],2) ?></td>
                          <td><?php echo number_format($value["COMISION"],2) ?></td>
                        </tr>
                        <?php 
                          $credivalor+=$value["CREDIVALOR"];
                          $comision+=$value["COMISION"];
                         ?>
                      <?php endforeach ?>
                      <?php if (isset($_POST['codigo_vendedor']) and !empty($_POST['codigo_vendedor'])): ?>
                        <tr>
                          <td colspan="5"></td>
                          <td><b>Total:</b></td>
                          <td><b><?php echo $credivalor ?></b></td>
                          <td><b><?php echo $comision ?></b></td>
                        </tr>
                      <?php endif ?>
                   </table>
                             
                         
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