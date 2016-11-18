<?php
session_start();

if(isset($_GET)){
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    //echo 'IDC= '.$_GET['idc'];
    
    require_once '../models/Remision.php';
    require_once '../models/RemisionImpl.php';
    $objRemisionImpl = new RemisionImpl();
    $objRemision = new Remision();        
    $objRemision->setClient($_GET['idc']);
    
    $strFecha = date("Y/m/d H:i:s");
    $objRemision->setGenerationDate($strFecha);
        
    $objRemision->setValueSale(0);        
    $objRemision->setValueIVA(0);
    $objRemision->setUser($_SESSION['userCode']);         

    $objRemisionImpl->insert($objRemision);
    
    $date = date_create($strFecha);
    $f = strtoupper(date_format($date, 'd-M-y H:i:s'));
    $objRemision->setGenerationDate($f);

    //obtengo el id de la factura recien ingresada
    $idRegister = $objRemisionImpl->getId($objRemision);
    
    echo '<script>document.location.href = "http://'.$ip.'/tp/views/remision/edit_remision.php?id='.$idRegister.'&cj='.$_GET['cj'].'"; </script>';
    
}
?>