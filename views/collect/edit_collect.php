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
        <script src="../../js/jquery/jquery.js"></script>
        <script src="../../js/select.js"></script>
        <script type="text/javascript" src="../../js/jquery.price_format.2.0.min.js"></script>
        <script type="text/javascript" src="../../js/price_format.js"></script>
        <title>Recaudos</title>
    </head>
    <body>
        <section class="contenedor">
            <header>
                <div class="logoEmpresa">
                    </div><div class="sesion">
                        Salir<a href="../../controllers/ctrlLogout.php"><img src="../../res/logout-24.png"></a>
                    </div>                    
                <div class="contenedorRutaApp">
                    <div class="nombreAplicacion">
                        <a href="../../">Sistema de Información TEXTILES DEL PACIFICO </a> 
                    </div><div class="arrowImgRight">
                        <img src="../../res/arrow-25-16.png">
                    </div><div class="opcionSeleccionada">
                        Recaudos
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
            <?php
            if(isset($_GET))
            {?>
                <section class="contenido" id="contenidoGeneral">
                    <h1>Editar Recaudo</h1>
                    <form method="post" action="../../controllers/ctrlEditCollect.php">
                        <?php
                        include_once '../../models/Collect.php';
                        include_once '../../models/CollectImpl.php';
                        $objCollectImpl = new CollectImpl();
                        

                        foreach ($objCollectImpl->getByCode($_GET['idr']) as $valor) {   
                            echo '<input type="hidden" value="'.$valor->getCode().'" name="txbCodeHidden">';
                            echo '<input type="hidden" value="'.$valor->getCodeCredit().'" name="txbCodeCreditHidden">';
                            echo '<input type="text" id="example2" value="'.$valor->getValue().'" name="txbValue" placeholder="Value" maxlength="14" required>';
                            echo '<input type="text" value="'.$valor->getObservation().'" name="txbObservations" placeholder="Observaciones" maxlength="200">';                            
                            
                            echo '<select name="selectTypePay">';
                                if(strcmp($valor->getTypePay(), "C") == 0)
                                {
                                    echo '<option value="E">EFECTIVO</option>';
                                    echo '<option value="C" selected>CONSIGNACION</option>';
                                }
                                else if(strcmp($valor->getTypePay(), "E") == 0){
                                    echo '<option value="E" selected>EFECTIVO</option>';
                                    echo '<option value="C">CONSIGNACION</option>';
                                } 
                                    
                            echo '</select>';
                        }
                        
                        
                        
                        echo '<input type="submit" value="Guardar">';

                        ?>  
                    </form>
                </section>
            <?php
            }?>            
            
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