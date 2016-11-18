<?php
session_start();

if(isset($_GET)){
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    //echo 'IDC= '.$_GET['idc'];
    
    require_once '../models/Bill.php';
    require_once '../models/BillImpl.php';
    $objBillImpl = new BillImpl();
    $objBill = new Bill();        
    $objBill->setClient($_GET['idc']);
    
    $strFecha = date("Y/m/d H:i:s");
    $objBill->setGenerationDate($strFecha);
        
    $objBill->setValueSale(0);        
    $objBill->setValueIVA(0);
    $objBill->setUser($_SESSION['userCode']);         

    $objBillImpl->insert($objBill);
    
    $date = date_create($strFecha);
    $f = strtoupper(date_format($date, 'd-M-y H:i:s'));
    $objBill->setGenerationDate($f);

    //obtengo el id de la factura recien ingresada
    $idRegister = $objBillImpl->getId($objBill);
    
    echo '<script>document.location.href = "http://'.$ip.'/tp/views/bill/edit_bill.php?id='.$idRegister.'&cj='.$_GET['cj'].'"; </script>';
    
}
?>