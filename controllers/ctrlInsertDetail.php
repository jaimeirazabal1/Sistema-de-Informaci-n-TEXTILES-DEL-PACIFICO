<?php
session_start();

if(isset($_POST)){
    
//    echo $_POST['txbQuantityBuyDetail'];
//    echo $_POST['txbPriceSaleDetail'];
    
    require_once '../models/Detail.php';
    require_once '../models/DetailImpl.php';
    require_once '../models/Stock.php';
    require_once '../models/StockImpl.php';
    
    require_once '../models/SystemImpl.php';
    $objSystemImpl = new SystemImpl();    

    $objDetail = new Detail(); 
    $objDetailImpl = new DetailImpl();
    
    require_once '../models/BillImpl.php';
    $objBillImpl = new BillImpl();
    
    $objStockImpl = new StockImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
       
    $objDetail->setCodeBill($_POST['hiddenCodeBill']);
    $objDetail->setCodeArticle($_POST['hiddenCodeArticle']);
    $objDetail->setQuantity($_POST['txbQuantityBuy']);
    $objDetail->setColor($_POST['hiddenColor']);
    
//    $variableA1 = $objDetail->getQuantity();
//    $sig[] = '.';
//    $sig[] = ',';
//    $cantidadComprada = str_replace($sig, '', $variableA1);
//    $objDetail->setQuantity($cantidadComprada); 
    
    /*$variableA = $_POST['txbPriceSale'];
    $sig[] = '.';
    $sig[] = ',';
    $valueSaleUnit = str_replace($sig, '', $variableA);    
    $objDetail->setValueUnit($valueSaleUnit);*/
    
    //echo 'color: '.$_POST['hiddenColor'];
    
    $valueSaleUnit = $objStockImpl->getLastPriceVenta($_POST['hiddenCodeArticle'], $_POST['hiddenColor']);
    $objDetail->setValueUnit($valueSaleUnit);
    
    //$valueSaleUnit = round($valT, -3);
    
    /*echo 'VALOR: '.$valueSaleUnit."<br>";
    echo 'VALOR: '.round($valueSaleUnit, -3)."<br>";*/
            
    
    //verificar existencia del detalle segun la remision     
    if($objDetailImpl->checkDetailExistencia($objDetail) > 0){
        //como existe el articulo en el detalle, ahora se obtiene la cantidad ingresada
        $quantityInDetail = $objDetailImpl->getQuantityInDetailByBill($objDetail);
        //cantidad a actualizar 
        $objDetail->setQuantity($objDetail->getQuantity()+$quantityInDetail);        
    
        $total = $objDetail->getQuantity() * $valueSaleUnit;  
        $objDetail->setTotal($total);
        
        //actualizar el detail con los nuevos valores
        $objDetailImpl->updateQuantityValUnitValTotal($objDetail);       
    }
    else{    
        $total = $objDetail->getQuantity() * $valueSaleUnit;  
        $objDetail->setTotal($total);

        $objDetail->setMoveDate(date("Y/m/d H:i:s"));
        $objDetailImpl->insert($objDetail);
    }
    
    
    
    //INSERT TO STOCK TABLE
       
    
    $name = $_POST['hiddenName'];
    
    $objStock = new Stock();    
    $objStock->setCode($_POST['hiddenCodeArticle']);
    $objStock->setName($name);
    $objStock->setMove('S');
    $objStock->setQuantity($objDetail->getQuantity());
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
    require_once '../models/Bill.php';
    require_once '../models/BillImpl.php';
    require_once '../models/SystemImpl.php';
    
    $objBill = new Bill();
    $objBill->setCode($_POST['hiddenCodeBill']);
    $objSystemImpl = new SystemImpl();
        
    $totalBill = $objDetailImpl->getTotalDetailBill($objDetail);
        
    $totalIva = ($totalBill * $objSystemImpl->getValue(1)) / 100;
    $totalVenta = $totalBill + $totalIva - $_POST['hiddenCanjeable'];
    
    if($totalVenta < 0)
        $totalVenta = 0;
    
    $objBill->setValueSale(round($totalVenta, -3));
    $objBill->setValueIVA($totalIva);
    
    $objBillImpl = new BillImpl();
    $objBillImpl->updateTotal($objBill);
        
   
    
    
    echo '<script>document.location.href = "http://'.$ip.'/tp/views/bill/edit_bill.php?id='.$_POST['hiddenCodeBill'].'&cj='.$_POST['hiddenCanjeable'].'"; </script>';
  
}
?>