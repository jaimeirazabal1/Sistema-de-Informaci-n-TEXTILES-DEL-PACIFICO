<?php
session_start();

if(isset($_POST)){
    require_once '../models/Color.php';
    require_once '../models/ColorImpl.php';
    $objColorImpl = new ColorImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $num_rows = $objColorImpl->checkCode($_POST['txbCode']);
    
    //echo 'es : '.$num_rows;
    
    if($num_rows == 0)//ENABLE CODE
    {
        //echo '1';
        $name = $_POST['txbName'];
        $objColor = new Color();    
        $objColor->setCode($_POST['txbCode']);
        $objColor->setName($name);
        
        $objColorImpl->insert($objColor);
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/config/colors.php"; </script>';
        
    }
    else // DISABLE CODE
    {
        //echo '2';
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/config/add_color.php?e&id='.$_POST['txbCode'].'&n='.$_POST['txbName'].'"; </script>';        
    }
    
    
    
    
    
    
    
    
}
?>