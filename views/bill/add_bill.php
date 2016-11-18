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
        <script src="../../js/check_get_client.js"></script>
        <!--<script src="../../js/check_get_employee.js"></script>-->
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>Facturación</title>
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
                        Facturación
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
            
            <?php
            if($_GET)
            {
            ?>
            <section class="contenido" id="contenidoGeneral">
                <h1>Crear Factura</h1>
                
                <form method="post" action="../../controllers/ctrlInsertBill.php">
                    <input type="number" name="txbCode" disabled>
                    <?php echo '<input type="number" name="txbCodeClient" id="txbCodeClient" value="'.$_GET['idc'].'" placeholder="Codigo Cliente" maxlength="12" required>'; ?>
                    <?php echo '<input type="text" name="txbNameClient" id="txbNameClient" placeholder="Cliente" readonly>'; ?>
                    <?php echo '<input type="text" name="txbDateGeneration" value="'.date("Y/m/d H:i:s").'" readonly>'; ?>
                    
                    <select name="selectPayment" id="selectDepartment">
                        <option value="CO">CONTADO</option>
                        <option value="CR">CREDITO</option>                    
                    </select>      
                    
                    
                 
                    
                    <input type="submit" value="Crear">
                </form>
            </section>
            <?php            
            }
            else
            {
            ?>
            
            <section class="contenido" id="contenidoGeneral">
                <h1>Crear Factura</h1>
                
                <form method="post" action="../../controllers/ctrlInsertBill.php">
                    <input type="number" name="txbCodeClient" id="txbCodeClient" placeholder="Codigo Cliente" maxlength="12" required>
                    <input type="text" name="txbNameClient" id="txbNameClient" placeholder="Cliente" readonly>
                    <?php echo '<input type="text" name="txbDateGeneration" value="'.date("Y/m/d H:i:s").'" readonly>'; ?>
                    
                    <select name="selectPayment" id="selectDepartment">
                        <option value="CO">CONTADO</option>
                        <option value="CR">CREDITO</option>                    
                    </select>                          
                    
                    <input type="submit" value="Crear">
                </form>
            </section>
                
            <?php
            }
            ?>
            
            
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
    <?php
    if(isset($_GET['idc']))
    {
        //echo '<script>alertify.error("Se debe registrar el cliente");</script>';
        echo '<script>alertify.success("Ahora se puede crear la remisión");</script>'; 
    }
    ?>
</html>

<?php
}
else
{
    echo '<script>document.location.href = "http://'.$ip.'/mio/login.php"; </script>';    
}
?>