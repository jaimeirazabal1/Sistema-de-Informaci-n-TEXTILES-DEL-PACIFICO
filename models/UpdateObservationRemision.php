<?php
      $sql = $_POST['b'];                  
       
      if(!empty($sql)) {
            comprobar($sql);
      }      
       
      function comprobar($sql) {
        require_once './Conexion.php';
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
      }      
      
?>
