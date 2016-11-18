<?php
session_start();

if(isset($_POST)){
    require_once '../models/System.php';
    require_once '../models/SystemImpl.php';
    $objSystemImpl = new SystemImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $name = $_POST['txbName'];
    $objSystem = new System();    
    $objSystem->setCode($_POST['txbCode']);
    $objSystem->setName($name);
    $objSystem->setValue($_POST['txbValue']);
    $objSystem->setStartDate($_POST['txbStartDate']);
    $objSystem->setFinishDate($_POST['txbFinishDate']);

    $objSystemImpl->update ($objSystem, $_POST['txbCodeHidden']);
    
    //echo '<script>document.location.href = "http://'.$ip.'/tp/views/config/system.php"; </script>';
        
    
    
    
    
    
    
    
    
}
?>