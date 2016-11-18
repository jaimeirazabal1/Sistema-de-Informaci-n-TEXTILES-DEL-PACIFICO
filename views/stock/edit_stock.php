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
        <script src="../../js/alertify/alertify.js"></script>
        <script src="../../js/msg_lenght.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>Inventario</title>
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
                        Inventario
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
                <h1>Editar Inventario</h1>
                <form method="post" action="../../controllers/ctrlEditStock.php">
                    <?php 
                    if(isset($_GET))
                    {
                        include_once '../../models/Detail.php';
                        include_once '../../models/DetailImpl.php';
                        $objDetailImpl = new DetailImpl();
                        $objDetail  = new Detail();
                        
                        $objDetail->setCodeArticle($_GET['id']);
                        //echo "es: "+$objDetailImpl->getCountArticleFromDetail($objDetail);
                        if($objDetailImpl->getCountArticleFromDetail($objDetail) > 0)
                        {
                            echo '<input type="hidden" value="'.$_GET['id'].'" name="txbCodeHidden">';
                            echo '<input type="text" value="'.$_GET['id'].'" name="txbCode" id="txbCode" placeholder="Referencia" maxlength="16" readonly required>';
                            echo '<input type="text" value="'.$_GET['n'].'" name="txbName" placeholder="Nombres" maxlength="60" readonly required>';
                            
                            echo '<select name="selectColor" id="selectColor" disabled>';
                            include_once '../../models/ColorImpl.php';
                            $objColorImpl = new ColorImpl();

                            foreach ($objColorImpl->getAllOrderName() as $valor) {
                                if($valor->getCode() == $_GET['c'])
                                    echo '<option value="'.$valor->getCode().'" selected>'.$valor->getName().'</option>';
                                else
                                    echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';
                            }                    
                            echo '</select>';
                            
                            
                            echo '<script>alertify.error("La referencia del artículo no se puede modificar, favor revisar remisiones");</script>';                         
                            echo '<input type="submit" value="Guardar" disabled>';
                            
                            
                        }
                        else
                        {
                            echo '<input type="hidden" value="'.$_GET['id'].'" name="txbCodeHidden">';
                            echo '<input type="text" value="'.$_GET['id'].'" name="txbCode" id="txbCode" placeholder="Referencia" maxlength="16" required>';
                            echo '<input type="text" value="'.$_GET['n'].'" name="txbName" placeholder="Nombres" maxlength="60" required>';
                            
                            echo '<select name="selectColor" id="selectColor">';
                            include_once '../../models/ColorImpl.php';
                            $objColorImpl = new ColorImpl();

                            foreach ($objColorImpl->getAllOrderName() as $valor) {
                                if($valor->getCode() == $_GET['c'])
                                    echo '<option value="'.$valor->getCode().'" selected>'.$valor->getName().'</option>';
                                else
                                    echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';
                            }                    
                            echo '</select>'; 

                                echo '<input type="submit" value="Guardar">';
                            }
                      
                        
                        include_once '../../models/Stock.php';
                        include_once '../../models/StockImpl.php';
                        $objStockImpl = new StockImpl();
                        
                        
                    }
                    else
                    {
                        
                    }                 
                    
                    
                    
                    
                    ?>                 
                    
                    
                </form>
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
    echo '<script>document.location.href = "http://'.$ip.'/mio/login.php"; </script>';    
}
?>