<?php
session_start();

if(isset($_POST)){
//    echo $_POST['hiddenCodeCxp'].'<br>';
//    echo $_POST['txbObservations'].'<br>';
//    echo $_POST['txbValue'].'<br>';
//    echo $_POST['selectTypeNote'].'<br>';
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    require_once '../models/Note.php';
    require_once '../models/NoteImpl.php';
    $objNote = new Note();
    $objNoteImpl = new NoteImpl();

    $objNote->setCodeBill($_POST['txbCodeCxp']);
    $objNote->setRegistrationDate(date("Y/m/d H:i:s"));
    $objNote->setTypeNote($_POST['selectTypeNote']);
    
    $objNote->setValue(0);
    $objNote->setValueIva(0);
    
    $objNote->setObservation('');
    $objNote->setUser($_SESSION['userCode']);
    
    //echo $objNote->getCode().'<br>';
//    echo $objNote->getCodeBill().'<br>';
//    echo $objNote->getObservation().'<br>';
//    echo $objNote->getRegistrationDate().'<br>';
//    echo $objNote->getTypeNote().'<br>';
//    echo $objNote->getUser().'<br>';
//    echo $objNote->getValue().'<br>';
//    echo $objNote->getValueIva().'<br>';
    
    require_once '../models/DetailCxp.php';
    require_once '../models/DetailCxpImpl.php';
    $objDetailCxp = new DetailCxp();
    $objDetailCxpImpl = new DetailCxpImpl();
    
    $objDetailCxp->setCodeCxp($objNote->getCodeBill());
    
    if($objDetailCxpImpl->getCountMovimientoD($objDetailCxp) > 0){     
        $objNoteImpl->insert($objNote);

        //obtengo el id de la nota recien ingresada
        $date = date_create($objNote->getRegistrationDate());
        $f = strtoupper(date_format($date, 'd-M-y H:i:s'));
        $objNote->setRegistrationDate($f);
        $idRegister = $objNoteImpl->getId($objNote);
    }
    else{
        echo '<script>document.location.href = "http://'.$ip.'/tp/views/notes/?e"; </script>';   
    }
    
    
                          
   echo '<script>document.location.href = "http://'.$ip.'/tp/views/notes/note_debito.php?idf='.$_POST['txbCodeCxp'].'&idn='.$idRegister.'"; </script>';   
}
?>