<?php
session_start();

if(isset($_GET)){    
    require_once '../models/DetailCxp.php';
    require_once '../models/DetailCxpImpl.php';   
   
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    
    require_once '../models/Stock.php';
    require_once '../models/StockImpl.php';   
    
    $objDetailCxp = new DetailCxp();
    $objStock = new Stock();
    $objDetailCxpImpl = new DetailCxpImpl();
    $objDetailCxp->setCodeCxp($_GET['idcxp']);    
    $objDetailCxp->setCodeArticle($_GET['ida']);
    $objDetailCxp->setColor($_GET['cl']);
    
    
    
    //INSERT IN STOCK
    $objStockImpl = new StockImpl();
    foreach($objDetailCxpImpl->getByCxpArticleColor($_GET['idcxp'], $_GET['ida'], $_GET['cl']) as $valInDetailCxp){
        $objStock->setCode($valInDetailCxp->getCodeArticle());
        $name = $objStockImpl->getNameArticle($valInDetailCxp->getCodeArticle());
        $objStock->setName($name);
        $objStock->setMove('A');
        $objStock->setQuantity($valInDetailCxp->getCantidad());
        $objStock->setPriceBuy($objStockImpl->getLastPriceSold($valInDetailCxp->getCodeArticle(), $valInDetailCxp->getColor()));
        $objStock->setPriceSold($objStockImpl->getLastPriceVenta($valInDetailCxp->getCodeArticle(), $valInDetailCxp->getColor()));
        $objStock->setColor($valInDetailCxp->getColor());
        $objStock->setMoveDate(date("Y/m/d H:i:s"));
        $objStock->setUser($_SESSION['userCode']);
        $objStockImpl->insert($objStock);        
    }
    

    //DELETE DEL DETALLE
    
    $objDetailCxpImpl->delete($objDetailCxp);
    
    
    //UPDATE TOTAL PRICE IN BILL
    //UPDATE TOTAL PRICE AND IVA IN BILL
    require_once '../models/Cxp.php';
    require_once '../models/CxpImpl.php';
    require_once '../models/SystemImpl.php';
    
    $objCxp = new Cxp();
    $objCxp->setCode($_GET['idcxp']);
    $objSystemImpl = new SystemImpl();
        
    $totalCxp = $objDetailCxpImpl->getTotalDetailCxp($objDetailCxp);
        
    $totalIva = ($totalCxp * $objSystemImpl->getValue(1)) / 100;
    $totalVenta = $totalCxp + $totalIva;
    
    $objCxp->setTotalCuenta($totalVenta);
    $objCxp->setIva($totalIva);
    
    $objCxpImpl = new CxpImpl();
    $objCxpImpl->updateTotal($objCxp);
    


    echo '<script>document.location.href = "http://'.$ip.'/tp/views/cxp/edit_cxp.php?id='.$_GET['idcxp'].'"; </script>';    
}
?>
