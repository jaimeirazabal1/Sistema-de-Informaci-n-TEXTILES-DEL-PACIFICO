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
        <script src="js/jquery/jquery.js"></script>
        <script src="js/alertify/alertify.js"></script>
        <link href="css/alertify/alertify.css" rel="stylesheet">
        <link href="css/alertify/themes/default.css" rel="stylesheet">
        <link rel="icon" href="res/favicon.png" type="image/png" sizes="16x16">
        <title>Login</title>
        
        
    </head>
    <body>
        <section class="contenedor">
            <header>
                <div class="menuImg"></div><div class="logoEmpresa">
                    </div><div class="sesion">                        
                    </div>                    
                <div class="contenedorRutaApp">
                    <div class="nombreAplicacion">
                        Sistema de Información TEXTILES DEL PACIFICO 
                    </div><div class="arrowImgRight">
                        <img src="res/arrow-25-16.png">
                    </div><div class="opcionSeleccionada">
                        Login
                    </div>
                </div>
            </header>
            <nav id="menu">
                <ul>
                    <li></li>                    
                </ul>
            </nav>
            
            <section class="contenido" id="contenidoGeneral">
                <h1>Iniciar sesión</h1>
                <?php
                    if(isset($_GET['error']))
                    {
                        echo '<script>alertify.error("Datos de sesión incorrectos");</script>';
                    }
                ?>
                <form method="post" action="controllers/ctrlLogin.php">
                    <input type="text" name="txbUser" placeholder="Usuario" id="imputUpNone" required>
                    <input type="password" placeholder="Password" name="txbPassword" id="imputUpNone" required>                    
                    <input type="submit" value="Ingresar">
                </form>
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
