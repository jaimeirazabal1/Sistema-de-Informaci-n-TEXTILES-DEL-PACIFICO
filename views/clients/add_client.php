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
        <script src="../../js/select.js"></script>  
        <script src="../../js/check_client.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>Clientes</title>
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
                        Clientes
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
            if($_GET)
            {
                if(isset($_GET['r']))
                {?>
                    <section class="contenido" id="contenidoGeneral">
                        <h1>Agregar Cliente</h1>
                        <form method="post" action="../../controllers/ctrlInsertClient.php">
                            <?php
                            echo '<input type="number" name="txbCode" id="txbCode" value="'.$_GET['id'].'" placeholder="Código" maxlength="12" required>';
                            ?>
                            <input type="hidden" name="hiddenGotoBill">        
                            <input type="text" name="txbName" placeholder="Nombres" maxlength="60" required>
 
                            <select name="selectTipo" id="selectTipo">
                            <?php
                            include_once '../../models/TypeClient.php';
                            include_once '../../models/TypeClientImpl.php';
                            $objTypeClientImpl = new TypeClientImpl();

                            foreach ($objTypeClientImpl->getAll() as $valor) {
                                echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';                        
                            }                    
                            ?>
                            </select> 
                            
                            <select name="selectDepartment" id="selectDepartment">
                            <?php
                            include_once '../../models/DepartmentImpl.php';
                            include_once '../../models/Department.php';
                            $objDepartmentImpl = new DepartmentImpl();

                            foreach ($objDepartmentImpl->getAll() as $valor) {
                                echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';                        
                            }                    
                            ?>
                            </select>                   

                            <select name="selectLocality" id="selectLocality">

                            </select>                    

                            <input type="text" name="txbDirection" placeholder="Dirección" maxlength="100" required>
                            <input type="text" name="txbDespacho" placeholder="Despacho" maxlength="100" required>
							
                            <input type="number" name="txbMobile" placeholder="Celular" maxlength="12">
                            
                            <textarea placeholder="Observaciones" name="txaObservation" id="txa-lg"></textarea>
                            
                            <input type="submit" value="Guardar">
                        </form>

                        <div class="listado"></div>
                    </section>
                <?php
                }
                
                else// si no hay r
                {
                ?> 

                <section class="contenido" id="contenidoGeneral">
                    <h1>Agregar Cliente</h1>
                    <form method="post" action="../../controllers/ctrlInsertClient.php">
                        <?php 
                        echo '<input type="number" name="txbCode" id="txbCode" value="'.$_GET['id'].'" placeholder="Código" maxlength="12" required>';
                        echo '<input type="text" name="txbName" value="'.$_GET['n'].'" placeholder="Nombres" maxlength="60" required>';
                       
                        echo '<select name="selectTipo" id="selectTipo">';
                        include_once '../../models/TypeClient.php';
                        include_once '../../models/TypeClientImpl.php';
                        $objTypeClientImpl = new TypeClientImpl();

                        foreach ($objTypeClientImpl->getAll() as $valor) {
                            echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';                        
                        }                    
                        echo '</select>'; 
                        
                        echo '<select name="selectDepartment" id="selectDepartment">';

                        include_once '../../models/DepartmentImpl.php';
                        include_once '../../models/Department.php';
                        $objDepartmentImpl = new DepartmentImpl();

                        foreach ($objDepartmentImpl->getAll() as $valor) {
                            if(strcmp ($valor->getCode(), $_GET['d']) == 0)
                                echo '<option value="'.$valor->getCode().'" selected="selected">'.$valor->getName().'</option>';
                            else{
                                echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';
                            }
                        }                    

                        echo '</select>';

                        echo '<select name="selectLocality" id="selectLocality"></select>';                    

                        echo '<input type="text" name="txbDirection" value="'.$_GET['dir'].'" placeholder="Dirección" maxlength="100" required>';

                        echo '<input type="text" name="txbDespacho" value="'.$_GET['dir'].'" placeholder="Despacho" maxlength="100" required>';

                        echo '<input type="number" name="txbMobile" placeholder="Celular" value="'.$_GET['c'].'" maxlength="12">';

                        echo '<textarea placeholder="Observaciones" name="txaObservation" id="txa-lg"></textarea>';
                            
                        echo '<input type="submit" value="Guardar">';

                        ?>
                    </form>

                    <div class="listado"></div>
                </section>
                <?php
                }
            }
            else
            {
            ?>
            
                <section class="contenido" id="contenidoGeneral">
                    <h1>Agregar Cliente</h1>
                    <form method="post" action="../../controllers/ctrlInsertClient.php">
                        <input type="number" name="txbCode" id="txbCode" placeholder="Código" maxlength="12" required>
                        <input type="text" name="txbName" placeholder="Nombres" maxlength="60" required>

                        <select name="selectTipo" id="selectTipo">
                        <?php
                        include_once '../../models/TypeClient.php';
                        include_once '../../models/TypeClientImpl.php';
                        $objTypeClientImpl = new TypeClientImpl();

                        foreach ($objTypeClientImpl->getAll() as $valor) {
                            echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';                        
                        }                    
                        ?>
                        </select>
                        
                        <select name="selectDepartment" id="selectDepartment">
                        <?php
                        include_once '../../models/DepartmentImpl.php';
                        include_once '../../models/Department.php';
                        $objDepartmentImpl = new DepartmentImpl();

                        foreach ($objDepartmentImpl->getAll() as $valor) {
                            echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';                        
                        }                    
                        ?>
                        </select>                   

                        <select name="selectLocality" id="selectLocality">

                        </select>                    

                        <input type="text" name="txbDirection" placeholder="Dirección" maxlength="100" required>
                        <input type="text" name="txbDespacho" placeholder="Despacho" maxlength="100" required>

                        <input type="number" name="txbMobile" placeholder="Celular" maxlength="12" > 
                        <textarea placeholder="Observaciones" name="txaObservation" id="txa-lg"></textarea>
                                                
                        <input type="submit" value="Guardar">
                    </form>

                    <div class="listado"></div>
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
    if(isset($_GET))
        if(isset($_GET['e']))
        {
            echo '<script>alertify.error("El código del cliente ya existe");</script>';                            
        }
        else if(isset($_GET['r']))
        {
            echo '<script>alertify.error("Se debe registrar el cliente");</script>';            
        }
    ?>
</html>

<?php
}
else
{
    echo '<script>document.location.href = "http://'.$ip.'/tp/login.php"; </script>';    
}
?>