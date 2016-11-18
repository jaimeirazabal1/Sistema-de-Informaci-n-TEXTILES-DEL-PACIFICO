<?php

if(isset($_GET)){
    require_once '../models/Color.php';
    require_once '../models/ColorImpl.php';
    require_once '../models/StockImpl.php';
   
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    $objColor = new Color();
    $objColor->setCode($_GET['id']);    

    $objStockImpl = new StockImpl();
    $objStock = new Stock();
    $objStock->setColor($_GET['id']);
    
    $colorInStock = $objStockImpl->getCountColorFromStock($objStock);
    
    if($colorInStock > 0)
    {
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/config/colors.php?em"; </script>';    
    }
    else
    {
        $objColorImpl = new ColorImpl();
        echo $objColorImpl->delete($objColor);
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/config/colors.php"; </script>';    
    }
    
        
    echo '<script>document.location.href = "http://'.$ip.'/tp/views/config/colors.php"; </script>';    
}
?>

