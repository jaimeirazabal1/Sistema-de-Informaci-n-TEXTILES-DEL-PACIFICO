<?php
session_start();

if(isset($_POST)){
    require_once '../models/Client.php';
    require_once '../models/ClientImpl.php';
    $objClientImpl = new ClientImpl();    
    
    require_once '../models/SystemImpl.php';
    $objSystemImpl = new SystemImpl();    
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $num_rows = $objClientImpl->checkCode($_POST['txbCodeClient']);
    
    //echo 'es : '.$num_rows;
    
    if($num_rows == 0)//debe registrar el cliente
    {
//      echo 'B';
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/clients/add_client.php?r&id=' . $_POST['txbCodeClient'] . '"; </script>';
    } 
    else
    {
        require_once '../models/Bill.php';
        require_once '../models/BillImpl.php';
        $objBillImpl = new BillImpl();
            
        
        $name = $_POST['txbName'];
    
        $objBill = new Bill();    
        $objBill->setClient($_POST['txbCodeClient']);
        $objBill->setGenerationDate($_POST['txbDateGeneration']);
        $objBill->setValueSale(0);        
        $objBill->setValueIVA(0);
        $objBill->setUser($_SESSION['userCode']);       
        $objBill->setPayment($_POST['selectPayment']);
        $objBillImpl->insert($objBill);
        
        
        $date = date_create($_POST['txbDateGeneration']);
        $f = strtoupper(date_format($date, 'd-M-y H:i:s'));
        $objBill->setGenerationDate($f);
        //obtengo el id de la factura recien ingresada
        $idRegister = $objBillImpl->getId($objBill); 
          

        //CREACION DEL CREDITO 
        if(strcmp($_POST['selectPayment'], "CR") == 0)
        {
            //echo 'es credito';
            require_once '../models/Credit.php';
            require_once '../models/CreditImpl.php';
            $objCredit = new Credit();
            $objCreditImpl = new CreditImpl();
            
            $num_rows_credit = $objCreditImpl->checkCodeBillInCredit($idRegister);
            
            //si existe el credito ingresa
            if($num_rows_credit>0)
            {
                //echo 'mayor a cero';
            }
            else//si no existe el credito
            {
                //echo 'menor a cero';
                $objCredit->setCodeClient($_POST['txbCodeClient']);
                $objCredit->setCodeBill($idRegister);
                $objCredit->setRegistrationDate(date("Y/m/d H:i:s"));
                $objCredit->setCodeConcept(1);
                $objCredit->setValue(0);
                $objCredit->setSaldo(0);
                $objCredit->setState('AC');
                $objCredit->setCancelDate("");
                $objCredit->setUser($_SESSION['userCode']);     
                $objCredit->setType('FA');
                $objCreditImpl->insert($objCredit);
            }
        }
        else{
            //echo 'no es credito';     
        }
            
            
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/bill/edit_bill.php?id='.$idRegister.'&cj=0"; </script>';
       
        

        
        
    }
    
    
    
    
    
    
}
?>