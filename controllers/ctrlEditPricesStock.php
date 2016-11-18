<?php

if(isset($_GET)){
    
    require_once '../models/Stock.php';
    require_once '../models/StockImpl.php';
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $objStock = new Stock();    
    $objStock->setCode($_POST['txbCode']);
    $objStock->setColor($_POST['txbColorHidden']);
    
    $objStock->setPriceBuy($_POST['txbPC']);
    $variableC = $objStock->getPriceBuy(); 
    $sigC[] = '.';
    $sigC[] = ',';
    $objStock->setPriceBuy(str_replace($sigC, '', $variableC)); 
    
    
    $objStock->setPriceSold($_POST['txbPV']);
    $variableV = $objStock->getPriceSold();
    $sigV[] = '.';
    $sigV[] = ',';
    $objStock->setPriceSold(str_replace($sigV, '', $variableV)); 
        
    $objStockImpl = new StockImpl();
    $objStockImpl->updatePrices($objStock);
    
    echo '<script>document.location.href = "http://'.$ip.'/tp/views/stock/"; </script>';
}
?>