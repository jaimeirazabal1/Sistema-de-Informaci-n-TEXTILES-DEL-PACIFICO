<?php
session_start();

if(isset($_POST)){
    require_once '../models/Cxp.php';
    require_once '../models/CxpImpl.php';
    $objCxpImpl = new CxpImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    $objCxp = new Cxp();    
    $objCxp->setCode($_GET['id']);
    $objCxp->setTotalCuenta($_POST['txbValueTotal']);
    $objCxp->setSaldoCuenta($_POST['txbValueSaldoCuenta']);
    $objCxp->setIva($_POST['txbValueIva']);
    $objCxp->setSaldoIva($_POST['txbValueSaldoIva']);
    $objCxp->setValorReteICA($_POST['txbValueReteIca']);
    $objCxp->setSaldoReteICA($_POST['txbValueSaldoReteIca']);
    $objCxp->setValorReteTimbre($_POST['txbValueReteTimbre']);
    $objCxp->setSaldoReteTimbre($_POST['txbValueSaldoReteTimbre']);
    
    $variableA1 = $objCxp->getTotalCuenta();
    $sig[] = '.';
    $sig[] = ',';
    $valor = str_replace($sig, '', $variableA1);
    $objCxp->setTotalCuenta($valor);
    
    $variableA1 = $objCxp->getSaldoCuenta();
    $sig[] = '.';
    $sig[] = ',';
    $valor = str_replace($sig, '', $variableA1);
    $objCxp->setSaldoCuenta($valor);
    
    $variableA1 = $objCxp->getIva();
    $sig[] = '.';
    $sig[] = ',';
    $valor = str_replace($sig, '', $variableA1);
    $objCxp->setIva($valor);
    
    $variableA1 = $objCxp->getSaldoIva();
    $sig[] = '.';
    $sig[] = ',';
    $valor = str_replace($sig, '', $variableA1);
    $objCxp->setSaldoIva($valor);
    
    $variableA1 = $objCxp->getValorReteICA();
    $sig[] = '.';
    $sig[] = ',';
    $valor = str_replace($sig, '', $variableA1);
    $objCxp->setValorReteICA($valor);
    
    $variableA1 = $objCxp->getSaldoReteICA();
    $sig[] = '.';
    $sig[] = ',';
    $valor = str_replace($sig, '', $variableA1);
    $objCxp->setSaldoReteICA($valor);
    
    $variableA1 = $objCxp->getValorReteTimbre();
    $sig[] = '.';
    $sig[] = ',';
    $valor = str_replace($sig, '', $variableA1);
    $objCxp->setValorReteTimbre($valor);
    
    $variableA1 = $objCxp->getSaldoReteTimbre();
    $sig[] = '.';
    $sig[] = ',';
    $valor = str_replace($sig, '', $variableA1);
    $objCxp->setSaldoReteTimbre($valor);
    $objCxp->setTypePay($_POST['selectTypePay']);
    
    
//    echo $objCxp->getCode().'<br>'; 
//    echo $objCxp->getTotalCuenta().'<br>';
//    echo $objCxp->getSaldoCuenta().'<br>';
//    echo $objCxp->getIva().'<br>';
//    echo $objCxp->getSaldoIva().'<br>';
//    echo $objCxp->getValorReteICA().'<br>';
//    echo $objCxp->getSaldoReteICA().'<br>';
//    echo $objCxp->getValorReteTimbre().'<br>';
//    echo $objCxp->getSaldoReteTimbre().'<br>';
    
    
    $objCxpImpl->updateValuesNumeric($objCxp);
    
    
//    //actualizar saldo
//    require_once '../models/CreditImpl.php';
//    require_once '../models/Credit.php';
//    $objCreditImpl = new CreditImpl();
//    $objCredit = new Credit();
//    
//    $totalCredito = $objCreditImpl->getValue($_POST['txbCodeCreditHidden']);
//
//    $objCxpImpl = new CxpImpl();
//
//    $idCredit = $_POST['txbCodeCreditHidden'];                    
//    $totalRecaudado = $objCxpImpl->sumValueByBiil($idCredit);
//
//    $objCredit->setCode($idCredit);
//    $objCredit->setSaldo($totalCredito - $totalRecaudado);                    
//    $objCreditImpl->updateSaldo($objCredit);
//    
//    //verifico  si ya se salda la deuda
//    if($objCredit->getSaldo()<=0){
//        $objCredit->setState('CA');
//        $objCreditImpl->updateStateByID($objCredit);
//    }
//    else{
//        $objCredit->setState('AC');
//        $objCreditImpl->updateStateByID($objCredit);
//    }
    
    echo '<script>document.location.href = "http://'.$ip.'/tp/views/cxp/edit_cxp.php?id='.$objCxp->getCode().'"; </script>';    
}
?>