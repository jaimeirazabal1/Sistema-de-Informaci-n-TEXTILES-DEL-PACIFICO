<?php
session_start();

if(isset($_POST)){
    require_once '../models/TypeConceptos.php';
    require_once '../models/TypeConceptosImpl.php';
    $objTypeConceptosImpl = new TypeConceptosImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $num_rows = $objTypeConceptosImpl->checkCode($_POST['txbCode']);
    
    //echo 'es : '.$num_rows;
    
    if($num_rows == 0)//ENABLE CODE
    {
        //echo '1';
        $name = $_POST['txbName'];
        $objTypeConceptos = new TypeConceptos();    
        $objTypeConceptos->setCode($_POST['txbCode']);
        $objTypeConceptos->setName($name);
        
        $objTypeConceptosImpl->insert($objTypeConceptos);
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/config/type_conceptos.php"; </script>';
        
    }
    else // DISABLE CODE
    {
        //echo '2';
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/config/add_type_conceptos.php?e&id='.$_POST['txbCode'].'&n='.$_POST['txbName'].'"; </script>';        
    }
}
?>