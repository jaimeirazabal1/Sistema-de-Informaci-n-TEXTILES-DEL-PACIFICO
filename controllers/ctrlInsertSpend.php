<?php
session_start();

if(isset($_POST)){
    
    if(strcmp($_POST['txbNameClient'], "") !=0)
    {
        require_once '../models/Spend.php';
        require_once '../models/SpendImpl.php';
        $objSpendImpl = new SpendImpl();

        include '../com/server.php';
        $server = new SimpleXMLElement($xmlstr);
        $ip = $server->server[0]->ip;
        
        $objSpend = new Spend();
        $objSpend->setCodeClient($_POST['txbCodeClient']);
        $objSpend->setCodeConcept($_POST['selectClient']);
        $objSpend->setValue($_POST['txbValue']);
        $objSpend->setUser($_SESSION['userCode']);
        $objSpend->setGenerationDate(date("Y/m/d H:i:s"));

        $variableA1 = $objSpend->getValue();
        $sig[] = '.';
        $sig[] = ',';
        $valor = str_replace($sig, '', $variableA1);
        $objSpend->setValue($valor); 

        $objSpendImpl->insert($objSpend);
        echo '<script>document.location.href = "http://'.$ip.'/fabian/views/spend/"; </script>'; 
    }
    else
        echo '<script>document.location.href = "http://'.$ip.'/fabian/views/spend/add_spend.php?ece"; </script>'; 
    
        
    
    
    
    
    
    
    
    
    
}
?>