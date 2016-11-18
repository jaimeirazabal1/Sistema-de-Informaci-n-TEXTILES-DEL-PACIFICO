<?php
session_start();

if(isset($_POST)){
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
    
    echo '<script>document.location.href = "http://'.$ip.'/tp/views/stock/"; </script>';       
  
}
?>