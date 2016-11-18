<?php
session_start();

if(isset($_POST)){
    require_once '../models/Client.php';
    require_once '../models/ClientImpl.php';
    $objClientImpl = new ClientImpl();    
        
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $name = $_POST['txbName'];

    require_once '../models/Bill.php';
    require_once '../models/BillImpl.php';
    $objBillImpl = new BillImpl();

    //echo 'es credito';
    require_once '../models/Collect.php';
    require_once '../models/CollectImpl.php';    
    $objCollectImpl = new CollectImpl();

    require_once '../models/CreditImpl.php';
    require_once '../models/Credit.php';
    $objCreditImpl = new CreditImpl();
    $objCredit = new Credit();    

    $valueCollect = $_POST['txbValue'];
    $variableA1 = $valueCollect;
    $sig[] = '.';
    $sig[] = ',';
    $valorC = str_replace($sig, '', $variableA1);
    $valueCollect = $valorC;
    
    $valueSequence = $objCollectImpl->getSequence() + 1;
    
    //get records credit-client
    foreach ($objCreditImpl->getByStateAC($_POST['hiddenCodeClient']) as $valor) {
        if($valueCollect > 0){
            $objCollect = new Collect();
            $objCollect->setCode($valueSequence);
            $objCollect->setCodeCredit($valor->getCode());
            $objCollect->setCodeConcept(1);
            
//            echo 'Valor: '.$valor->getValue().'<br>';
//            echo 'Valor Pago: '.$valueCollect.'<br>';
//            echo '-----------EVAL IF---------<br><br>';
            
            if($valor->getSaldo() >= $valueCollect){
//                echo "(1)";
                $objCollect->setValue($valueCollect);
                $valueCollect = 0;
            }
            else if($valor->getSaldo() < $valueCollect){
//                echo "(2)";                
                $objCollect->setValue($valor->getSaldo());
                $valueCollect = $valueCollect - $valor->getSaldo();
            }                      
            
            $objCollect->setRegistrationDate(date("Y/m/d H:i:s"));
            $objCollect->setObservation($_POST['txbObservations']);
            $objCollect->setUser($_SESSION['userCode']);
            $objCollect->setTypePay($_POST['selectTypePay']);
            
            $objCollectImpl->insert($objCollect);            
            
            //actualizar saldo
            $totalCredito = $objCreditImpl->getValue($valor->getCode());
            $totalRecaudado = $objCollectImpl->sumValueByRemision($valor->getCode());
            
            $objCredit->setCode($valor->getCode());
            $objCredit->setSaldo($totalCredito - $totalRecaudado);                    
            
            
//            echo 'Code Cr'.$objCredit->getCode().'<br>';
//            echo 'Total Cr'.$totalCredito.'<br>';            
//            echo 'Total Rcd'.$totalRecaudado.'<br>';
//            echo 'Saldo'.$objCredit->getSaldo().'<br>';            
            
            
            
            
            $objCreditImpl->updateSaldo($objCredit);

            //verifico  si ya se salda la deuda
            if($objCredit->getSaldo()<=0){
                $objCredit->setState('CA');
                $objCredit->setCancelDate(date("Y/m/d H:i:s"));
                $objCreditImpl->updateStateByID($objCredit);
            }
            
            $objCollectImpl->nextSequence();
        }
    }
    
//    echo '<script>document.location.href = "http://'.$ip.'/tp/views/collect/select_credits.php?id='.$valor->getCodeClient().'"; </script>';    
    
}
?>
