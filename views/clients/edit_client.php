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
            
            <section class="contenido" id="contenidoGeneral">
                <h1>Editar Cliente</h1>
                <form method="post" action="../../controllers/ctrlEditClient.php">
                    <?php 
                    if(isset($_GET))
                    {
                        include_once '../../models/Client.php';
                        include_once '../../models/ClientImpl.php';
                        $objClientImpl = new ClientImpl();

                        foreach ($objClientImpl->getByCode($_GET[id]) as $valor) {                           
                            
                            echo '<input type="hidden" value="'.$valor->getCode().'" name="txbCodeHidden">';
                            echo '<input type="number" value="'.$valor->getCode().'" name="txbCode" placeholder="Código" maxlength="12" required>';
                            echo '<input type="text" value="'.$valor->getName().'" name="txbName" placeholder="Nombres" maxlength="60" required>';
                            echo '<input type="text" value="'.$valor->getRegistrationDate().'" disabled>';
                            
                            echo '<select name="selectType" id="selectType">';
                                include_once '../../models/TypeClientImpl.php';
                                include_once '../../models/TypeClient.php';
                                $objTypeClientImpl = new TypeClientImpl();

                                foreach ($objTypeClientImpl->getAll() as $valorTypeClient) {
                                    if($valor->getTipo() == $valorTypeClient->getCode())
                                        echo '<option value="' . $valorTypeClient->getCode() . '" selected="selected">' . $valorTypeClient->getName() . '</option>';
                                    else
                                        echo '<option value="' . $valorTypeClient->getCode() . '">' . $valorTypeClient->getName() . '</option>';
                                }                                
                            echo '</select>';
                            
                            echo '<select name = "selectDepartment" id = "selectDepartment">';                                
                                include_once '../../models/DepartmentImpl.php';
                                include_once '../../models/Department.php';
                                $objDepartmentImpl = new DepartmentImpl();

                                foreach ($objDepartmentImpl->getAll() as $valorDepartment) {
                                    if($valor->getCodeDepartment() == $valorDepartment->getCode())
                                        echo '<option value="' . $valorDepartment->getCode() . '" selected="selected">' . $valorDepartment->getName() . '</option>';
                                    else
                                        echo '<option value="' . $valorDepartment->getCode() . '">' . $valorDepartment->getName() . '</option>';
                                }
                            echo '</select>'; 
                            
                            echo '<select name="selectLocality" id="selectLocality">';
                                include_once '../../models/LocalityImpl.php';
                                include_once '../../models/Locality.php';
                                $objLocalityImpl = new LocalityImpl();

                                foreach ($objLocalityImpl->getAll() as $valorlocality) {
                                    if($valor->getCodeLocality() == $valorlocality->getCode())
                                        echo '<option value="' . $valorlocality->getCode() . '" selected="selected">' . $valorlocality->getName() . '</option>';
                                    else
                                        echo '<option value="' . $valorlocality->getCode() . '">' . $valorlocality->getName() . '</option>';
                                }                                
                            echo '</select>';
                            
                            echo '<input type="text" value="'.$valor->getDirection().'" name="txbDirection" placeholder="Dirección" maxlength="100" required>';

                            echo '<input type="text" value="'.$valor->getDespacho().'" name="txbDespacho" placeholder="Despacho" maxlength="100" required>';

                            echo '<input type="number" value="'.$valor->getMobile().'" name="txbMobile" placeholder="Celular" maxlength="12">';
                            
                            echo '<select name="selectState" id="selectState">';                        
                                if(strcmp($valor->getState(), "AC") == 0  || strcmp($valor->getState(), "ac") == 0  || strcmp($valor->getState(), "") == 0)
                                {
                                    echo '<option value="AC" selected="selected">ACTIVO</option>';                                                                                            
                                    echo '<option value="IN">INACTIVO</option>';                                                        
                                }
                                else {
                                    echo '<option value="AC">ACTIVO</option>';                                                                                            
                                    echo '<option value="IN" selected="selected">INACTIVO</option>';                                                        
                                }
                            echo '</select>';
                                                       
                            //include_once '../../models/Client.php';
                            include_once '../../models/UserImpl.php';
                            $objUserImpl = new UserImpl();
                            $user = $objUserImpl->getNameUser($valor->getUser());
                            
                            echo '<input type="text" value="'.$user.'" disabled>';
                            echo '<textarea placeholder="Observaciones" name="txaObservation" id="txa-lg">'.$valor->getObservation().'</textarea>';
                           
                        }
                        
                        echo '<input type="submit" value="Guardar">';
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
    echo '<script>document.location.href = "http://'.$ip.'/tp/login.php"; </script>';    
}
?>