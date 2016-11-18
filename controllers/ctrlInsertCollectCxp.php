<?php
session_start();

if(isset($_POST)){
    require_once '../models/Client.php';
    require_once '../models/ClientImpl.php';
    $objClientImpl = new ClientImpl();    
        
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
//    
//    $name = $_POST['txbName'];
//
    require_once '../models/Bill.php';
    require_once '../models/BillImpl.php';
    $objBillImpl = new BillImpl();

    //echo 'es credito';
    require_once '../models/CollectCxp.php';
    require_once '../models/CollectCxpImpl.php';
    $objCollectCxp = new CollectCxp();
    $objCollectCxpImpl = new CollectCxpImpl();


    //echo 'menor a cero';
    $objCollectCxp->setCodeCxp($_POST['hiddenCodeCxp']);
    $objCollectCxp->setCodeConcept(2);
    
    $objCollectCxp->setValue($_POST['txbValue']);    
    $variableA1 = $objCollectCxp->getValue();
    $sig[] = '.';
    $sig[] = ',';
    $valor = str_replace($sig, '', $variableA1);
    $objCollectCxp->setValue($valor); 
    
    
    $objCollectCxp->setRegistrationDate(date("Y/m/d H:i:s"));
    $objCollectCxp->setObservation($_POST['txbObservations']);
    $objCollectCxp->setUser($_SESSION['userCode']);
    $objCollectCxp->setTypePay($_POST['selectTypePay']);
    
//    echo $objCollectCxp->getCodeCxp().'<br>';
//    echo $objCollectCxp->getCodeConcept().'<br>';
//    echo $objCollectCxp->getValue().'<br>';
//    echo $objCollectCxp->getRegistrationDate().'<br>';
//    echo $objCollectCxp->getObservation().'<br>';
//    echo $objCollectCxp->getTypePay().'<br>';
//    echo $objCollectCxp->getUser().'<br>';
//    
    
    $objCollectCxpImpl->insert($objCollectCxp);
    
    
    //actualizar saldo
    require_once '../models/CxpImpl.php';
    require_once '../models/Cxp.php';
    $objCxpImpl = new CxpImpl();
    $objCxp = new Cxp();
    
    $totalCxpo = $objCxpImpl->getValue($_POST['hiddenCodeCxp']);

    $objCollectCxpImpl = new CollectCxpImpl();

    $idCxp = $_POST['hiddenCodeCxp'];                    
    $totalRecaudado = $objCollectCxpImpl->sumValueByBiil($idCxp);

//    echo 'TotalCxpo: '.$totalCxpo.'<br>';
//    echo 'Total Recaudo: '.$totalRecaudado.'<br>';
    
    
    $objCxp->setCode($idCxp);
    $objCxp->setSaldoCuenta($totalCxpo - $totalRecaudado);                    
    $objCxpImpl->updateSaldo($objCxp);
    
    //verifico  si ya se salda la deuda
    if($objCxp->getSaldoCuenta()<=0){
        $objCxp->setEstado('PA');
        $objCxpImpl->updateStateByID($objCxp);
    }        
                          
    echo '<script>document.location.href = "http://'.$ip.'/tp/views/collectcxp/"; </script>';    
}
?>