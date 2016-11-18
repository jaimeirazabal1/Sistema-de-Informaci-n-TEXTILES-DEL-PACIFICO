<?php
session_start();
$data = json_decode($_POST['datas']);
//print_r($data);
require_once '../models/Stock.php';
require_once '../models/StockImpl.php';
require '../models/SystemImpl.php';
$objSystemImpl = new SystemImpl();
$iva = $objSystemImpl->getValue(1);
$objStockImpl = new StockImpl();
$cont = 0;
$valCanjeable = 0;

foreach($data as $valor) {
    if($cont > 0){ //evito ingresar el encabezado de la tabla que es vacio
        //INSERT INTO STOCK
        $objStock = new Stock();    
        $objStock->setCode($valor[0]);
        $objStock->setName($valor[1]);
        $objStock->setMove("E");
        $objStock->setQuantity($valor[2]);
        $objStock->setPriceBuy($objStockImpl->getLastPriceSold($valor[0], $valor[5]));
        $objStock->setPriceSold($valor[3]);
        $objStock->setMoveDate(date("Y/m/d H:i:s"));
        $objStock->setUser($_SESSION['userCode']);    
        $objStock->setColor($valor[5]);
        
        $objStockImpl->insert($objStock);        
        $valCanjeable += $valor[4];
    }        
    $cont++; 
    //$objStockImpl->insert($objStock);   
    
    /*echo 'Codigo: ' . $valor[0] . ' - ';
    echo 'Nombre: ' . $valor[1] . ' - ';
    echo 'Cantidad: ' . $valor[2] . ' - ';
    echo 'Unitario: ' . $valor[3] . ' - ';
    echo 'Total: ' . $valor[4] . ' - '; 
    echo 'Color: ' . $valor[5] . ' - '; */
    
    
    
}

//$valCanjeable = round($valCanjeable + ($valCanjeable*$iva/100), -3);
$valCanjeable = $valCanjeable + ($valCanjeable*$iva/100);
echo $valCanjeable;

?>