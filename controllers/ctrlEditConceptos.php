<?php
session_start();

if(isset($_POST)){
    require_once '../models/Concept.php';
    require_once '../models/ConceptImpl.php';
    $objConceptImpl = new ConceptImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
        $name = $_POST['txbName'];
        $objConceptos = new Concept();    
        $objConceptos->setCode($_POST['txbCode']);
        $objConceptos->setName($name);
        
        $objConceptImpl->update ($objConceptos, $_POST['txbCodeHidden']);
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/config/type_conceptos.php"; </script>';
        
}
?>