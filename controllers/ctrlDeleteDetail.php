<?php
session_start();

if(isset($_GET)){    
    require_once '../models/Detail.php';
    require_once '../models/DetailImpl.php';   
   
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    //DELETE DEL DETALLE
    $objDetail = new Detail();
    $objDetail->setCodeBill($_GET['idf']);    
    $objDetail->setCodeArticle($_GET['ida']);
    $objDetail->setColor($_GET['cl']);
    
    $objDetailImpl = new DetailImpl();
    $objDetailImpl->delete($objDetail);
    
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
    
//    $variable = $_GET['q'];
//    $sig[] = '.';
//    $sig[] = ',';
//    $objStock->setQuantity(str_replace($sig, '', $variable));
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
//    //echo $objStock->getUbication().'<br>';
//    echo $objStock->getMoveDate().'<br>';
//    echo $objStock->getUser().'<br>';
    
    $objStockImpl->insert($objStock);
    
    
    //UPDATE TOTAL PRICE IN BILL
    //UPDATE TOTAL PRICE AND IVA IN BILL
    require_once '../models/Bill.php';
    require_once '../models/BillImpl.php';
    require_once '../models/SystemImpl.php';
    
    $objBill = new Bill();
    $objBill->setCode($_GET['idf']);
    $objSystemImpl = new SystemImpl();
        
    $totalBill = $objDetailImpl->getTotalDetailBill($objDetail);
        
    $totalIva = ($totalBill * $objSystemImpl->getValue(1)) / 100;
    $totalVenta = $totalBill + $totalIva - $_GET['cj'];
    
    if($totalVenta < 0)
        $totalVenta = 0;
    
    $objBill->setValueSale(round($totalVenta, -3));
    $objBill->setValueIVA($totalIva);
    
    $objBillImpl = new BillImpl();
    $objBillImpl->updateTotal($objBill);
    
    
//    //TOP CHECK
//    //echo 'Tope es: '.$objSystemImpl->getValue(5);
//    $topValue = $objSystemImpl->getTop();
//    $auxMonth = date("Y-m");
//    $initialDay = $auxMonth.'-01';
//    $finishDay = $auxMonth.'-'.date("t");
//    //echo 'Inicial: '.$initialDay.' ----  Final: '.$finishDay;        
//    $sumTotalTop = $objBillImpl->getSumTop($initialDay, $finishDay);
//    //echo 'Total antes del tope: '.$sumTotalTop.' --- Dias son: '.  date("t");
//    
//    if($sumTotalTop > $topValue)
//        $objBillImpl->updateType($objBill);
    
    
    
    /*require_once '../models/Bill.php';
    require_once '../models/BillImpl.php';
    require_once '../models/DetailImpl.php';
    require_once '../models/Detail.php';

    $objDetailImplUV = new DetailImpl();
    $objDetailUV = new Detail();
    $objBillImplUV = new BillImpl();
    $objBillUV = new Bill();

    $objBillUV->setCode($_GET['idf']);
    $objDetailUV->setCodeBill($_GET['idf']);

    $totalBillUV = $objDetailImplUV->getTotalDetailBill($objDetailUV);
    
    if($totalBillUV > 0)
        $objBillUV->setValueSale($totalBillUV);
    else
        $objBillUV->setValueSale(0);

    $objBillImplUV->updateTotal($objBillUV);*/
    //-------------------------




    echo '<script>document.location.href = "http://'.$ip.'/tp/views/bill/edit_bill.php?id='.$_GET['idf'].'&cj='.$_GET['cj'].'"; </script>';    
}
?>
