<?php

if(isset($_GET)){
    require_once '../models/TypeConceptos.php';
    require_once '../models/TypeConceptosImpl.php';
    require_once '../models/GastoImpl.php';
   
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    $objConcepto = new TypeConceptos();
    $objConcepto->setCode($_GET['id']);    

    $objGastoImpl = new GastoImpl();
    $objGasto = new Gasto();
    $objGasto->setTipo($_GET['id']);
    
    $typeGastoInGasto = $objGastoImpl->getCountTypeGastoFromGasto($objGasto); 
    
    if($typeGastoInGasto > 0)
    {
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/config/type_conceptos.php?em"; </script>';    
    }
    else
    {
        $objConceptosImpl = new TypeConceptosImpl();
        echo $objConceptosImpl->delete($objConcepto);
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/config/type_conceptos.php"; </script>';    
    }
        
    echo '<script>document.location.href = "http://'.$ip.'/tp/views/config/type_conceptos.php"; </script>';    
}
?>

