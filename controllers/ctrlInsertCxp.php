<?php
session_start();

//echo 'Vendedor'.$_POST['selectEmployees'].'<br>';


if(isset($_POST)){
    require_once '../models/Client.php';
    require_once '../models/ClientImpl.php';
    $objClientImpl = new ClientImpl();    
    
    require_once '../models/SystemImpl.php';
    $objSystemImpl = new SystemImpl();    
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $num_rows = $objClientImpl->checkCode($_POST['txbCodeClient']);
    
    //echo 'es : '.$num_rows;
    
    if($num_rows == 0)//debe registrar el cliente
    {
//      echo 'B';
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/clients/add_client.php?r&id=' . $_POST['txbCodeClient'] . '"; </script>';
    } 
    else
    {
        require_once '../models/Cxp.php';
        require_once '../models/CxpImpl.php';
        $objCxpImpl = new CxpImpl();
            
        
        $name = $_POST['txbNameClient'];
    
        $objCxp = new Cxp();    
        $objCxp->setProveedor($_POST['txbCodeClient']);
        $objCxp->setFechaCreacion($_POST['txbDateCreacion']);
        $objCxp->setFechaVencimiento($_POST['txbDateVencimiento']);
        $objCxp->setEstado('GE');   
        $objCxp->setOrigen($_POST['selectOrigen']);
        $objCxp->setTotalCuenta(0);
        $objCxp->setSaldoCuenta(0);
        $objCxp->setIva(0);
        $objCxp->setSaldoIva(0);
        $objCxp->setValorReteICA(0);
        $objCxp->setSaldoReteICA(0);
        $objCxp->setValorReteTimbre(0);
        $objCxp->setSaldoReteTimbre(0);
        $objCxp->setUsuario($_SESSION['userCode']);       
        $objCxp->setTypePay("E");
        
        
//        echo $objCxp->getProveedor().'<br>';
//        echo $objCxp->getFechaCreacion().'<br>';
//        echo $objCxp->getFechaVencimiento().'<br>';
//        echo $objCxp->getEstado().'<br>';   
//        echo $objCxp->getOrigen().'<br>';
//        echo $objCxp->getTotalCuenta().'<br>';
//        echo $objCxp->getSaldoCuenta().'<br>';
//        echo $objCxp->getIva().'<br>';
//        echo $objCxp->getSaldoIva(0).'<br>';
//        echo $objCxp->getValorReteICA(0).'<br>';
//        echo $objCxp->getSaldoReteICA(0).'<br>';
//        echo $objCxp->getValorReteTimbre(0).'<br>';
//        echo $objCxp->getSaldoReteTimbre(0).'<br>';
//        echo $objCxp->getUsuario($_SESSION['userCode']).'<br>';     
        
        $objCxpImpl->insert($objCxp);
        
        
        $date = date_create($_POST['txbDateCreacion']);
        $f = strtoupper(date_format($date, 'd-M-y H:i:s'));
        $objCxp->setFechaCreacion($f);
        //obtengo el id de la CXP recien ingresada
        $idRegister = $objCxpImpl->getId($objCxp); 
        
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/cxp/edit_cxp.php?id='.$idRegister.'"; </script>';
      
        

        
        
    }
    
    
    
    
    
    
}
?>