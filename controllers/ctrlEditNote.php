<?php
session_start();

if(isset($_POST)){
    require_once '../models/Note.php';
    require_once '../models/NoteImpl.php';
    $objNoteImpl = new NoteImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    $objNote = new Note();    
    $objNote->setCode($_POST['txbCodeHidden']);  
    $objNote->setObservation($_POST['txaObservation']);

    $objNoteImpl->updateObservations($objNote);
    
    echo '<script>document.location.href = "http://'.$ip.'/tp/views/notes/"; </script>';    
}
?>