<?php
session_start();

if(isset($_POST)){
    
//    echo $_POST['txbQuantityBuyDetailRemision'];
//    echo $_POST['txbPriceSaleDetailRemision'];
    
    require_once '../models/DetailRemision.php';
    require_once '../models/DetailRemisionImpl.php';
    require_once '../models/Stock.php';
    require_once '../models/StockImpl.php';
    
    require_once '../models/SystemImpl.php';
    $objSystemImpl = new SystemImpl();    

    $objDetailRemision = new DetailRemision(); 
    $objDetailRemisionImpl = new DetailRemisionImpl();
    
    require_once '../models/RemisionImpl.php';
    $objRemisionImpl = new RemisionImpl();
    
    $objStockImpl = new StockImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
       
    $objDetailRemision->setCodeRemision($_POST['hiddenCodeRemision']);
    $objDetailRemision->setCodeArticle($_POST['hiddenCodeArticle']);
    $objDetailRemision->setQuantity($_POST['txbQuantityBuy']);
    $objDetailRemision->setColor($_POST['hiddenColor']);
    
    
	   
    $variableA = $_POST['txbPriceSale'];
    $sig[] = '.';
    $sig[] = ',';
    $valueSaleUnit = str_replace($sig, '', $variableA);    
    $objDetailRemision->setValueUnit($valueSaleUnit);
    
    //echo 'color: '.$_POST['hiddenColor'];
    
    //$valueSaleUnit = $objStockImpl->getLastPriceVenta($_POST['hiddenCodeArticle'], $_POST['hiddenColor']);
//    $objDetailRemision->setValueUnit($valueSaleUnit);
    
    //$valueSaleUnit = round($valT, -3);
    
    /*echo 'VALOR: '.$valueSaleUnit."<br>";
    echo 'VALOR: '.round($valueSaleUnit, -3)."<br>";*/
            
    $quantityInDetailRemision = 0;
    
    //verificar existencia del detalle segun la remision     
    if($objDetailRemisionImpl->checkDetailRemisionExistencia($objDetailRemision) > 0){
        //como existe el articulo en el detalle, ahora se obtiene la cantidad ingresada
        $quantityInDetailRemision = $objDetailRemisionImpl->getQuantityInDetailRemisionByRemision($objDetailRemision);
        //cantidad a actualizar 
        $objDetailRemision->setQuantity($objDetailRemision->getQuantity()+$quantityInDetailRemision);        
    
        $total = $objDetailRemision->getQuantity() * $valueSaleUnit;  
        $objDetailRemision->setTotal($total);
        
        //actualizar el detail con los nuevos valores
        $objDetailRemisionImpl->updateQuantityValUnitValTotal($objDetailRemision);       
    }
    else{    
        $total = $objDetailRemision->getQuantity() * $valueSaleUnit;  
        $objDetailRemision->setTotal($total);

        $objDetailRemision->setMoveDate(date("Y/m/d H:i:s"));
        $objDetailRemisionImpl->insert($objDetailRemision);
    }
    
    
    
    //INSERT TO STOCK TABLE
       
    
    $name = $_POST['hiddenName'];
    
    $objStock = new Stock();    
    $objStock->setCode($_POST['hiddenCodeArticle']);
    $objStock->setName($name);
    $objStock->setMove('S');
    $objStock->setQuantity( ($objDetailRemision->getQuantity() - $quantityInDetailRemision ) );
    $objStock->setPriceBuy($_POST['hiddenPriceBuy']);
    $objStock->setPriceSold($valueSaleUnit);
    $objStock->setMoveDate(date("Y/m/d H:i:s"));
    $objStock->setUser($_SESSION['userCode']);    
    $objStock->setColor($_POST['hiddenColor']);
    
    $variable = $objStock->getPriceBuy(); 
    $sig[] = '.';
    $sig[] = ',';
    $objStock->setPriceBuy(str_replace($sig, '', $variable));
        
    
    $objStockImpl->insert($objStock);   
    
    //UPDATE TOTAL PRICE AND IVA IN BILL
    require_once '../models/Remision.php';
    require_once '../models/RemisionImpl.php';
    require_once '../models/SystemImpl.php';
    
    $objRemision = new Remision();
    $objRemision->setCode($_POST['hiddenCodeRemision']);
    $objSystemImpl = new SystemImpl();
        
    $totalRemision = $objDetailRemisionImpl->getTotalDetailRemision($objDetailRemision);
        
    $totalIva = ($totalRemision * $objSystemImpl->getValue(1)) / 100;
    $totalVenta = $totalRemision + $totalIva - $_POST['hiddenCanjeable'];
    
    if($totalVenta < 0)
        $totalVenta = 0;
    
    $objRemision->setValueSale($totalVenta);
    $objRemision->setValueIVA($totalIva);
    
    $objRemisionImpl = new RemisionImpl();
    $objRemisionImpl->updateTotal($objRemision);
    
    
    /*
    //TOP CHECK
    //echo 'Tope es: '.$objSystemImpl->getValue(5);
    $topValue = $objSystemImpl->getTop();
    $auxMonth = date("Y-m");
    $initialDay = $auxMonth.'-01';
    $finishDay = $auxMonth.'-'.date("t");
    //echo 'Inicial: '.$initialDay.' ----  Final: '.$finishDay;        
    $sumTotalTop = $objRemisionImpl->getSumTop($initialDay, $finishDay);
    //echo 'Total antes del tope: '.$sumTotalTop.' --- Dias son: '.  date("t");
    
    if($sumTotalTop > $topValue)
        $objRemisionImpl->updateType($objRemision);*/
    
    
    echo '<script>document.location.href = "http://'.$ip.'/tp/views/remision/edit_remision.php?id='.$_POST['hiddenCodeRemision'].'&cj='.$_POST['hiddenCanjeable'].'"; </script>';
  
}
?>