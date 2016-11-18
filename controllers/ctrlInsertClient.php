<?php
session_start();

if(isset($_POST)){
    require_once '../models/Client.php';
    require_once '../models/ClientImpl.php';
    $objClientImpl = new ClientImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $num_rows = $objClientImpl->checkCode($_POST['txbCode']);
    
    //echo 'es : '.$num_rows;
    
    if($num_rows == 0)//ENABLE CODE
    {
        //echo '1';
        $name = $_POST['txbName'];
        $objClient = new Client();    
        $objClient->setCode($_POST['txbCode']);
        $objClient->setName($name);
        $objClient->setRegistrationDate(date("Y/m/d H:i:s"));
        $objClient->setCodeDepartment($_POST['selectDepartment']);
        $objClient->setCodeLocality($_POST['selectLocality']);
        $objClient->setDirection($_POST['txbDirection']);

        $objClient->setDespacho($_POST['txbDespacho']);   

        $objClient->setTipo($_POST['selectTipo']);
        $objClient->setState('AC');
        
        if (strcmp($_POST['txbMobile'], '') == 0)
            $objClient->setMobile(0);
        else 
            $objClient->setMobile($_POST['txbMobile']);
        
        $objClient->setUser($_SESSION['userCode']);
        $objClient->setObservation($_POST['txaObservation']);
        
        $objClientImpl->insert($objClient);
        
        if(isset($_POST['hiddenGotoBill'])){
            echo '<script>document.location.href = "http://'.$ip.'/tp/views/bill/add_bill.php?idc='.$_POST['txbCode'].'"; </script>';
        }
        else{
            echo '<script>document.location.href = "http://'.$ip.'/tp/views/clients/"; </script>';
        }        
    }
    else // DISABLE CODE
    {
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/clients/add_client.php?e&id='.$_POST['txbCode'].'&n='.$_POST['txbName'].'&d='.$_POST['selectDepartment'].'&dir='.$_POST['txbDirection'].'&c='.$_POST['txbMobile'].'"; </script>';        
    }
    
    
    
    
    
    
    
    
}
?>