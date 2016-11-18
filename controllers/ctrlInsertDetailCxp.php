<?php
session_start();

if(isset($_POST)){
//    echo $_POST['txbQuantityBuyDetailCxp'];
//    echo $_POST['txbPriceSaleDetailCxp'];
    
    require_once '../models/DetailCxp.php';
    require_once '../models/DetailCxpImpl.php';
    
    
    require_once '../models/SystemImpl.php';
    $objSystemImpl = new SystemImpl();    

    $objDetailCxp = new DetailCxp(); 
    $objDetailCxpImpl = new DetailCxpImpl();
    
    require_once '../models/CxpImpl.php';
    $objCxpImpl = new CxpImpl();
    
        
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
       
    $objDetailCxp->setCodeCxp($_POST['hiddenCodeCxp']);
    $objDetailCxp->setCodeArticle(strtoupper($_POST['txbCode']));
    $objDetailCxp->setCantidad($_POST['txbQuantity']);
    $objDetailCxp->setColor($_POST['selectColor']);
    
    
	   
    $variableA = $_POST['txbPriceBuy'];
    $sig[] = '.';
    $sig[] = ',';
    $valueSaleUnit = str_replace($sig, '', $variableA);    
    $objDetailCxp->setValorUnitario($valueSaleUnit);
    
    //echo 'color: '.$_POST['hiddenColor'];
    
    //$valueSaleUnit = $objStockImpl->getLastPriceVenta($_POST['hiddenCodeArticle'], $_POST['hiddenColor']);
//    $objDetailCxp->setValueUnit($valueSaleUnit);
    
    //$valueSaleUnit = round($valT, -3);
    
    /*echo 'VALOR: '.$valueSaleUnit."<br>";
    echo 'VALOR: '.round($valueSaleUnit, -3)."<br>";*/
            
    $quantityInDetailCxp = 0;
    
    //verificar existencia del detalle segun la cxp     
    if($objDetailCxpImpl->checkDetailCxpExistencia($objDetailCxp) > 0){
        //como existe el articulo en el detalle, ahora se obtiene la cantidad ingresada
        $quantityInDetailCxp = $objDetailCxpImpl->getQuantityInDetailCxpByCxp($objDetailCxp);
        //cantidad a actualizar 
        $objDetailCxp->setCantidad($objDetailCxp->getCantidad()+$quantityInDetailCxp);        
    
        $total = $objDetailCxp->getCantidad() * $valueSaleUnit;  
        $objDetailCxp->setTotal($total);
        
        //actualizar el detail con los nuevos valores
        $objDetailCxpImpl->updateQuantityValUnitValTotal($objDetailCxp);    
    }
    else{    
        $total = $objDetailCxp->getCantidad() * $valueSaleUnit;  
        $objDetailCxp->setTotal($total);

        $objDetailCxp->setFechaCreacion(date("Y/m/d H:i:s"));
        $objDetailCxpImpl->insert($objDetailCxp);
    }
    
        
    //UPDATE TOTAL PRICE AND IVA IN CXP
    require_once '../models/Cxp.php';
    require_once '../models/CxpImpl.php';
    require_once '../models/SystemImpl.php';
    
    $objCxp = new Cxp();
    $objCxp->setCode($_POST['hiddenCodeCxp']);
    $objSystemImpl = new SystemImpl();
        
    $totalCxp = $objDetailCxpImpl->getTotalDetailCxp($objDetailCxp);
        
    $totalIva = ($totalCxp * $objSystemImpl->getValue(1)) / 100;
    $totalVenta = $totalCxp + $totalIva;
    
    $objCxp->setTotalCuenta($totalVenta);
    $objCxp->setIva($totalIva);
    
    $objCxpImpl = new CxpImpl();
    $objCxpImpl->updateTotal($objCxp);  
    
    
    
    //INSERT IN STOCK
    require_once '../models/Stock.php';
    require_once '../models/StockImpl.php';
    $objStockImpl = new StockImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $name = $_POST['txbName'];
    $objStock = new Stock();    
    $objStock->setCode($_POST['txbCode']);
    $objStock->setName($name);
    
    $objStock->setMove('E');
    $objStock->setQuantity($_POST['txbQuantity']);
    
    
	/*$variableQ = $objStock->getQuantity(); 
    $sigQ[] = '.';
    $sigQ[] = ',';
    $objStock->setQuantity(str_replace($sigQ, '', $variableQ));   */
    
    
    $objStock->setPriceBuy($_POST['txbPriceBuy']);
    $variable = $objStock->getPriceBuy(); 
    $sig[] = '.';
    $sig[] = ',';
    $objStock->setPriceBuy(str_replace($sig, '', $variable));   
    
    if(strcmp($_POST['txbPriceSold'], "") == 0)
        $objStock->setPriceSold(0);
    else{
        $objStock->setPriceSold($_POST['txbPriceSold']);
        $variableV = $objStock->getPriceSold(); 
        $sig[] = '.';
        $sig[] = ',';
        $objStock->setPriceSold(str_replace($sig, '', $variableV));
    }
    
    $objStock->setColor($_POST['selectColor']);
    $objStock->setMoveDate(date("Y/m/d H:i:s"));
    $objStock->setUser($_SESSION['userCode']);    

    $objStockImpl->insert($objStock);
    
    
    
    require_once '../models/CxpImpl.php';
    $objCxp = new Cxp();
    $objCxpImpl = new CxpImpl();                                              

    $objCxp->setCode($_POST['hiddenCodeCxp']);                    
    $objCxp->setTotalCuenta($objCxpImpl->getValue($_POST['hiddenCodeCxp']));


//    echo 'TOTAL CODE CXP '.$objCxp->getCode().'<br>';
//    echo 'TOTAL CUENTA '.$objCxp->getTotalCuenta().'<br>';
//    echo 'TOTAL CUENTA '.$objCxp->getTotalCuenta().'<br>';
    
    require_once '../models/CollectCxpImpl.php';
    $objCollectCxpImpl = new CollectCxpImpl();
    $totalRecaudado = $objCollectCxpImpl->sumValueByCxp($_POST['hiddenCodeCxp']);

    $objCxp->setSaldoCuenta($objCxp->getTotalCuenta() - $totalRecaudado);                    
    $objCxpImpl->updateSaldo($objCxp);
    
    
    
    
    
    
    
    
    
    
    
    echo '<script>document.location.href = "http://'.$ip.'/tp/views/cxp/edit_cxp.php?id='.$_POST['hiddenCodeCxp'].'"; </script>';
  
}
?>