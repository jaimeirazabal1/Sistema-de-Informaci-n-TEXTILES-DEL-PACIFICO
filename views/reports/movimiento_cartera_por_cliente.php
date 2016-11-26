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
            <br>
                <h1>MOVIMIENTO CARTERA X CLIENTE</h1>
                    <?php require_once("../../models/ClientImpl.php") ?>    
                   <?php $client = new ClientImpl() ?>     
                   <?php $clientes = $client->get_clientes() ?> 
                   <?php $data = $client->movimiento_cartera_por_cliente() ?> 
                 	
                <?php
                if($_POST)
                {?>
                    <form action="" method="post" id="formMovimientoCarteraCliente">
                        <?php 
                        echo '<input id="txbFechaInicio"  name="txbFechaInicio" type="date" placeholder="DESDE"  value="'.$_POST['txbFechaInicio'].'">'; 
                        echo '<input id="txbFechaFin" name="txbFechaFin" type="date" placeholder="HASTA"  value="'.$_POST['txbFechaFin'].'">';                        
                        ?> 
                        <select name="codigo_cliente" id="" required>
                            <option value="">Seleccione</option>
                            <?php foreach ($clientes as $key => $value): ?>
                                <?php if ($_POST['codigo_cliente'] == $value['CLIENCODIG']): ?>
                                <option value="<?php echo $value['CLIENCODIG'] ?>" selected><?php echo $value['CLIENCODIG'] ?> - <?php echo $value['CLIENNOMBR'] ?></option>

                                <?php else: ?>
                                <option value="<?php echo $value['CLIENCODIG'] ?>"><?php echo $value['CLIENCODIG'] ?> - <?php echo $value['CLIENNOMBR'] ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>                        
                        <input id="btnConsultaMovimientoCarteraCliente" type="submit" value="Consultar">
                        <input id="btnGenerarPdfMovimientoCarteraCliente" type="submit" value="Generar PDF">
                    </form>    
                <?php
                }
                else
                {?>
                    <form action="" method="post" id="formMovimientoCarteraCliente">
                        <?php 
                        $dateNow = date("Y-m-d");
                        echo '<input id="txbFechaInicio" name="txbFechaInicio" type="date" placeholder="DESDE"  value="'.$dateNow.'">'; 
                        echo '<input id="txbFechaFin"  name="txbFechaFin" type="date" placeholder="HASTA"  value="'.$dateNow.'">';
                        
                        ?>                
                        <select name="codigo_cliente" id="" required>
                            <option value="">Seleccione</option>
                            <?php foreach ($clientes as $key => $value): ?>
                                <option value="<?php echo $value['CLIENCODIG'] ?>"><?php echo $value['CLIENCODIG'] ?> - <?php echo $value['CLIENNOMBR'] ?></option>
                            <?php endforeach ?>
                        </select>        
                        <input id="btnConsultaMovimientoCarteraCliente" type="submit" value="Consultar">
                        <input id="btnGenerarPdfMovimientoCarteraCliente" type="submit" value="Generar PDF">
                    </form>
                <?php
                }
                ?>
                
                
                
            </section>
          
            <section class="contenido" id="contenidoGeneral2">                
                <div class="listado">   
                <?php $saldo = 0;
                 $debito = 0;
                 $credito = 0; ?>    
                <?php foreach ($data as $key => $value): ?>
                        <?php if (isset($value['DEBITO'])): ?>
                            <?php $saldo += $value['DEBITO']  ?>
                            <?php $debito += $value['DEBITO']  ?>
                        <?php else: ?>
                          <?php $saldo -= $value['CREDITO']  ?>
                          <?php $credito += $value['CREDITO']  ?>
                        <?php endif ?>
                      <?php endforeach ?>   
                <?php if (isset($_POST['codigo_cliente'])): ?>
                <?php $cliente = $client->get_cliente_by_id($_POST['codigo_cliente']) ?>  
              
                <?php echo "<div style='font-size:12px'><b >CÓDIGO DEL CLIENTE:</b> ".$cliente[0]['CLIENCODIG']." 
                <br> 
                <b >NOMBRE DEL CLIENTE:</b> ".$cliente[0]['CLIENNOMBR']." 
                <br> 
                <b >SALDO INICIAL DE CARTERA DEL CLIENTE:</b> ".number_format($debito-$credito,2)."</div><br>" ?>          	
                <?php endif ?>                          
                  <table class="table">
                  	<thead>
                  		<th>DOCUMENTO-NÚMERO DEL DOCUMENTO</th>
                  		<th>FECHA GENERACIÓN DOCUMENTO</th>
                  		<th>VALOR DÉBITO</th>
                  		<th>VALOR CRÉDITO</th>
                  		<th>SALDO DE CARTERA</th>
                  	</thead>
                  	<?php $saldo = 0; ?>
                  	<?php $debito = 0; ?>
                  	<?php $credito = 0; ?>
                    <?php if ($data): ?>
                      
                    	<?php foreach ($data as $key => $value): ?>
                    		<?php if (isset($value['DEBITO'])): ?>
  	                  		<tr>
  	                  			<?php $saldo += $value['DEBITO']  ?>
  	                  			<?php $debito += $value['DEBITO']  ?>
  	                  			<td><?php echo "REM-".$value['REMISCODIG'] ?></td>
  	                  			<td><?php echo $value['FECHA'] ?></td>
  	                  			<td style="text-align: right;"><?php echo number_format($value['DEBITO'],2) ?></td>
  	                  			<td style="text-align: right;"><?php echo "0,00" ?></td>
  	                  			<td style="text-align: right;"><?php echo number_format($saldo,2) ?></td>
  	                  		</tr>
                    			
                    		<?php else: ?>
                    			<?php $saldo -= $value['CREDITO']  ?>
                    			<?php $credito += $value['CREDITO']  ?>
  	                  		<tr>
  	                  			<td><?php echo "RC-".$value['RECAUCODIG'] ?></td>
  	                  			<td><?php echo $value['FECHA'] ?></td>
  	                  			<td style="text-align: right;"><?php echo "0,00" ?></td>
  	                  			<td style="text-align: right;"><?php echo number_format($value['CREDITO'],2) ?></td>
  	                  			<td style="text-align: right;"><?php echo number_format($saldo,2) ?></td>
  	                  		</tr>
                    		<?php endif ?>
                    	<?php endforeach ?>
                    <?php endif ?>
                  	<tr>
                  		<td></td>
                  		<td></td>
                  		<td style="text-align: right;"><b><?php echo number_format($debito,2) ?></b></td>
                  		<td style="text-align: right;"><b><?php echo number_format($credito,2) ?></b></td>
                  		<td style="text-align: right;"><b><?php echo number_format($debito-$credito,2) ?></b></td>
                  	</tr>
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