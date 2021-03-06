<?php
session_start();

include 'com/server.php';
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
        <link href="css/style.css" rel="stylesheet">
        <link rel="icon" href="res/favicon.png" type="image/png" sizes="16x16">
        <title></title>
    </head>
    <body>
        <section class="contenedor">
            <header>
                <div class="menuImg"></div><div class="logoEmpresa">
                    </div><div class="sesion">
                        Salir<a href="controllers/ctrlLogout.php"><img src="res/logout-24.png"></a>
                    </div>                    
                <div class="contenedorRutaApp">
                    <div class="nombreAplicacion">
                        <a href="./">Sistema de Información TEXTILES DEL PACIFICO </a>                        
                    </div><div class="arrowImgRight">
                        <img src="res/arrow-25-16.png">
                    </div><div class="opcionSeleccionada">
                        Inicio
                    </div>
                </div>
            </header>
            <nav id="menu">
                <ul>
                    <li><a href="views/config/"><img src="res/settings-4-16.png">Parámetros</a></li>
                    <li><a href="views/clients/"><img src="res/guest-16.png">Clientes</a></li>
                    <li><a href="views/stock/"><img src="res/list-ingredients-16.png">Inventario</a></li>
                    <li><a href="views/remision"><img src="res/invoice-16.png">Remisión</a></li>
                    <li><a href="views/collect/"><img src="res/cash-receiving-16.png">Recaudos</a></li>                                       
                    <li><a href="views/notes/"><img src="res/paper-16.png">Notas</a></li> 
                    <li><a href="views/cxp/"><img src="res/document-2-16.png">Cuentas por Pagar</a></li> 
                    <li><a href="views/spend/"><img src="res/banknotes-16.png">Gastos</a></li> 
                    <li><a href="views/reports/"><img src="res/line-16.png">Reportes</a></li>   
                </ul>
            </nav>
            
            <section class="contenido" id="contenidoInicio">
                
            </section>
            <footer>
                <div class="contenedorRutaSoporte">
                    <div class="opcionSeleccionadaSoporte">
                        TEXTILES DEL PACIFICO
                    </div><div class="arrowImgLeft">
                        <img src="res/arrow-89-16.png">
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
    echo '<script>document.location.href = "http://'.$ip.'/fabian/login.php"; </script>';    
}
?>