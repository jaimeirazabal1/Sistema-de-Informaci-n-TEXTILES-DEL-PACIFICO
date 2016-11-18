<?php
session_start();

//echo 'Vendedor'.$_POST['selectEmployees'].'<br>';


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
    
    require_once '../models/Seller.php';
    require_once '../models/SellerImpl.php';
    $objSellerImpl = new SellerImpl();
    $objSeller = new Seller();
    
    //echo 'es : '.$num_rows;
    
    if($num_rows == 0)//debe registrar el cliente
    {
//      echo 'B';
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/clients/add_client.php?r&id=' . $_POST['txbCodeClient'] . '"; </script>';
    } 
    else
    {
        require_once '../models/Remision.php';
        require_once '../models/RemisionImpl.php';
        $objRemisionImpl = new RemisionImpl();
            
        
        $name = $_POST['txbName'];
    
        $objRemision = new Remision();    
        $objRemision->setClient($_POST['txbCodeClient']);
        $objRemision->setGenerationDate($_POST['txbDateGeneration']);
        $objRemision->setValueSale(0);        
        $objRemision->setValueIVA(0);
        $objRemision->setUser($_SESSION['userCode']);       
        $objRemision->setPayment($_POST['selectPayment']);
        $objRemisionImpl->insertHowRemision($objRemision);
        
        
        $date = date_create($_POST['txbDateGeneration']);
        $f = strtoupper(date_format($date, 'd-M-y H:i:s'));
        $objRemision->setGenerationDate($f);
        //obtengo el id de la factura recien ingresada
        $idRegister = $objRemisionImpl->getId($objRemision); 
          

        //CREACION DEL CREDITO 
        if(strcmp($_POST['selectPayment'], "CR") == 0)
        {
            //echo 'es credito';
            require_once '../models/Credit.php';
            require_once '../models/CreditImpl.php';
            $objCredit = new Credit();
            $objCreditImpl = new CreditImpl();
            
            $num_rows_credit = $objCreditImpl->checkCodeRemisionInCredit($idRegister);
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
                $objCredit->setType('RE');
                $objCreditImpl->insert($objCredit);
            }
        }
        else{
            //echo 'no es credito';     
        }
            
        //ingreso la venta para el vendedor
        $objSeller->setCodeSeller($_POST['selectEmployees']);
        $objSeller->setBillRemision($idRegister);
        $objSeller->setRegistrationDate($_POST['txbDateGeneration']);
        $objSellerImpl->insert($objSeller);
            
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/remision/edit_remision.php?id='.$idRegister.'&cj=0"; </script>';
       
        

        
        
    }
    
    
    
    
    
    
}
?>