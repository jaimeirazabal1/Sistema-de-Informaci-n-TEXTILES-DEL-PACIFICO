<?php
session_start();

if(isset($_GET)){    
    require_once '../models/DetailRemision.php';
    require_once '../models/DetailRemisionImpl.php';   
   
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    //DELETE DEL DETALLE
    $objDetailRemision = new DetailRemision();
    $objDetailRemision->setCodeRemision($_GET['idf']);    
    $objDetailRemision->setCodeArticle($_GET['ida']);
    $objDetailRemision->setColor($_GET['cl']);
    
    $objDetailRemisionImpl = new DetailRemisionImpl();
    $objDetailRemisionImpl->delete($objDetailRemision);
    
    //INSERT ARTICULOS ELIMINADOS EN STOCK
    require_once '../models/Stock.php';
    require_once '../models/StockImpl.php';   
   
    $objStockImpl = new StockImpl();
    $objStock = new Stock();
    
    $objStock->setCode($_GET['ida']);
    $name = $objStockImpl->getNameArticle($_GET['ida']);
    $objStock->setName($name);
    $objStock->setMove('E');
    //$objStock->setQuantity($_GET['q']);
    
    
    
    $objStock->setQuantity($_GET['q']);
    
    $objStock->setPriceBuy($objStockImpl->getLastPriceSold($_GET['ida'], $_GET['cl']));
    $objStock->setPriceSold($objStockImpl->getLastPriceVenta($_GET['ida'], $_GET['cl']));
    $objStock->setColor($_GET['cl']);
    $objStock->setMoveDate(date("Y/m/d H:i:s"));
    $objStock->setUser($_SESSION['userCode']);
    
    
    //*****
 
    //****
    
    
    
    
    
    
    
//    echo $objStock->getCode().'<br>';    
//    echo $objStock->getName().'<br>';
//    echo $objStock->getMove().'<br>';
//    echo $objStock->getQuantity().'<br>';
//    echo $objStock->getPriceBuy().'<br>';
//    echo $objStock->getPriceSold().'<br>';
//    echo $objStock->getUbication().'<br>';
//    echo $objStock->getMoveDate().'<br>';
//    echo $objStock->getUser().'<br>';
    
    $objStockImpl->insert($objStock);
    
    
    //UPDATE TOTAL PRICE IN BILL
    //UPDATE TOTAL PRICE AND IVA IN BILL
    require_once '../models/Remision.php';
    require_once '../models/RemisionImpl.php';
    require_once '../models/SystemImpl.php';
    
    $objRemision = new Remision();
    $objRemision->setCode($_GET['idf']);
    $objSystemImpl = new SystemImpl();
        
    $totalRemision = $objDetailRemisionImpl->getTotalDetailRemision($objDetailRemision);
        
    $totalIva = ($totalRemision * $objSystemImpl->getValue(1)) / 100;
    $totalVenta = $totalRemision + $totalIva - $_GET['cj'];
    
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
    
    
    
    /*require_once '../models/Remision.php';
    require_once '../models/RemisionImpl.php';
    require_once '../models/DetailRemisionImpl.php';
    require_once '../models/DetailRemision.php';

    $objDetailRemisionImplUV = new DetailRemisionImpl();
    $objDetailRemisionUV = new DetailRemision();
    $objRemisionImplUV = new RemisionImpl();
    $objRemisionUV = new Remision();

    $objRemisionUV->setCode($_GET['idf']);
    $objDetailRemisionUV->setCodeRemision($_GET['idf']);

    $totalRemisionUV = $objDetailRemisionImplUV->getTotalDetailRemisionRemision($objDetailRemisionUV);
    
    if($totalRemisionUV > 0)
        $objRemisionUV->setValueSale($totalRemisionUV);
    else
        $objRemisionUV->setValueSale(0);

    $objRemisionImplUV->updateTotal($objRemisionUV);*/
    //-------------------------




    echo '<script>document.location.href = "http://'.$ip.'/tp/views/remision/edit_remision.php?id='.$_GET['idf'].'&cj='.$_GET['cj'].'"; </script>';    
}
?>
