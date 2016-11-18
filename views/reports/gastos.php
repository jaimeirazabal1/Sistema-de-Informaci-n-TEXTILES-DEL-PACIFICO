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
                <h1>GASTOS</h1>
                    <?php require_once("../../models/ClientImpl.php") ?>    
                   <?php $client = new ClientImpl() ?>     
                   <?php $clientes = $client->get_clientes() ?> 
                   <?php $gastos = $client->get_gastos() ?>
                   
                <?php
                if($_POST)
                {?>
                    <form id="" action="" method="post">
                        <?php 
                        echo '<input id="txbFechaInicio"  name="txbFechaInicio" type="date" placeholder="DESDE"  value="'.$_POST['txbFechaInicio'].'">'; 
                        echo '<input id="txbFechaFin" name="txbFechaFin" type="date" placeholder="HASTA"  value="'.$_POST['txbFechaFin'].'">';                        
                        ?> 
                        <select name="codigo_vendedor" id="" >
                            <option value="">Seleccione</option>
                            <?php foreach ($clientes as $key => $value): ?>
                                <?php if ($_POST['codigo_vendedor'] == $value['CLIENCODIG']): ?>
                                <option value="<?php echo $value['CLIENCODIG'] ?>" selected><?php echo $value['CLIENNOMBR'] ?></option>

                                <?php else: ?>
                                <option value="<?php echo $value['CLIENCODIG'] ?>"><?php echo $value['CLIENNOMBR'] ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>                        
                        <input id="btnConsultarSeller" type="submit" value="Consultar">
                        <input id="" type="button" onClick="demoFromHTML()" value="Generar PDF">
                    </form>    
                <?php
                }
                else
                {?>
                    <form id="" action="" method="post">
                        <?php 
                        $dateNow = date("d/m/Y");
                        echo '<input id="txbFechaInicio" name="txbFechaInicio" type="date" placeholder="DESDE"  value="'.$dateNow.'">'; 
                        echo '<input id="txbFechaFin"  name="txbFechaFin" type="date" placeholder="HASTA"  value="'.$dateNow.'">';
                        
                        ?>                
                        <select name="codigo_vendedor" id="" >
                            <option value="">Seleccione</option>
                            <?php foreach ($clientes as $key => $value): ?>
                                <option value="<?php echo $value['CLIENCODIG'] ?>"><?php echo $value['CLIENNOMBR'] ?></option>
                            <?php endforeach ?>
                        </select>        
                        <input id="btnConsultarSeller" type="submit" value="Consultar">
                        <input id="" type="button" onClick="demoFromHTML()" value="Generar PDF">
                    </form>
                <?php
                }
                ?>
                
                
                
            </section>
            
            <script type="text/javascript">
                function demoFromHTML() {
                        $("td:hidden,th:hidden","#customers").show();
                    var pdf = new jsPDF('l', 'pt', 'a4');
                     pdf.cellInitialize();
                    pdf.setFontSize(10);
                    $.each( $('#customers tr'), function (i, row){
                        $.each( $(row).find("td, th"), function(j, cell){
                             var txt = $(cell).text().trim().split(" ").join("\n") || " ";
                             var width = (j==0) ? 70 : 45; //make with column smaller
                             //var height = (i==0) ? 40 : 30;
                             pdf.cell(10, 50, 100, 50, txt, i);
                        });
                    });
                        pdf.save('Test.pdf');

                }
            </script>
            <section class="contenido" id="contenidoGeneral2">                
                <div class="listado">                                      
                 
                   <?php $data = $client->get_comisiones_vendedores() ?> 
                   <?php $inicio = isset($_POST['txbFechaInicio']) ? strtotime(str_replace("/","-",$_POST['txbFechaInicio'])) : '' ?> 
                   <?php $fin = isset($_POST['txbFechaFin']) ? strtotime(str_replace("/","-",$_POST['txbFechaFin'])) : '' ?> 
                   <?php $codigo = isset($_POST['codigo_vendedor']) ? $_POST['codigo_vendedor'] : '' ?>

                   <table id="customers">
                       <thead>
                           <th>Código recibo</th>
                           <th>Código y Nombre cliente</th>
                           <th>Código y Nombre del concepto</th>
                           <th>Fecha generación del gasto</th>
                           <th>Valor del gasto</th>
                       </thead>
                       <?php if ($_POST): ?>
                           <?php $filas=0; ?>
                           <?php $suma_gasto=0 ?>
                       <?php foreach ($gastos as $key => $value): ?>

                            <?php
                                $dt = DateTime::createFromFormat('d/m/y', $value['GASTOFECHA']);
                                $f1 = $dt->format('d-m-Y');
                                $dt = DateTime::createFromFormat('d/m/y', $value['GASTOFECHA']);
                                $f2 = $dt->format('d-m-Y');
                                $strtotime1 = strtotime($f1);
                                $strtotime2 = strtotime($f2);
                            ?>
                  
                          
                        
                              
                                
                                 <tr>
                                     <td><?php echo $value['GASTORECIB'] ?> </td>
                                     <td><?php echo $value['GASTOCLIEN']." ".$value['CLIENNOMBR'] ?></td>

                                     <td><?php echo $value['GASTOCONCE']." ".$value['CONCENOMBR'] ?></td>
                                     <td><?php echo $value['GASTOFECHA'] ?></td>
                                     <td><?php echo $value['GASTOVALOR'] ?></td>
                                 </tr>
                                 <?php $suma_gasto+=$value['GASTOVALOR'] ?>
                                 <?php $filas++ ?>
                      
                        
                       <?php endforeach ?>
                                  <tr>
                                     <td colspan="3"></td>
                                     <td> <b>TOTAL:</b> </td>
                                     <td><b><?php echo $suma_gasto ?></b></td>
                                 </tr>
                        <?php else: ?>
                       <?php $filas=0; ?>
                       <?php foreach ($gastos as $key => $value): ?>
                                
                               <tr>
                                   <td><?php echo $value['GASTORECIB'] ?> </td>
                                   <td><?php echo $value['GASTOCLIEN']." ".$value['CLIENNOMBR'] ?></td>

                                   <td><?php echo $value['GASTOCONCE']." ".$value['CONCENOMBR'] ?></td>
                                   <td><?php echo $value['GASTOFECHA'] ?></td>
                                   <td><?php echo $value['GASTOVALOR'] ?></td>
                               </tr>
                               <?php $filas++ ?>
                       <?php endforeach ?>
                       <?php endif ?>
                   <?php if ($filas == 0): ?>
                       <tr>
                           <td colspan="8">
                               <center>
                                   <h2>La búsqueda no arrojó ningún resultado</h2>
                               </center>
                           </td>
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