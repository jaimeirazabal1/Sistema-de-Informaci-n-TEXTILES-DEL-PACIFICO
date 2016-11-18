<?php
session_start();

if(isset($_POST)){    
//    echo $_POST['hiddenIdf'].'<br>';
//    echo $_POST['hiddenIdn'].'<br>';
//    echo $_POST['hiddenIda'].'<br>';
//    echo $_POST['hiddenFc'].'<br>';
//    echo $_POST['hiddenCl'].'<br>';
    require_once '../models/DetailRemision.php';
    require_once '../models/DetailRemisionImpl.php';   
   
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    require_once '../models/RemisionImpl.php';
    $objRemisionImpl = new RemisionImpl();
    $typeRemision = $objRemisionImpl->getPayRemision($_POST['hiddenIdf']);

    //UPDATE REGRESADO EN EL DETALLE
    $objDetailRemision = new DetailRemision();
    $objDetailRemision->setCodeRemision($_POST['hiddenIdf']);    
    $objDetailRemision->setCodeArticle($_POST['hiddenIda']);
    $objDetailRemision->setColor($_POST['hiddenCl']);
    
    $objDetailRemisionImpl = new DetailRemisionImpl();    
    $objDetailRemision->setDevolucion($_POST['txbRegresar'] + $objDetailRemisionImpl->getDevolucion($objDetailRemision));    
    $objDetailRemisionImpl->updateDevolucion($objDetailRemision);
    $verificar = $objDetailRemisionImpl->verificarDevolucion($objDetailRemision);
    
    
    if($verificar == 0)
        $objDetailRemisionImpl->updateMovimiento($objDetailRemision);
 
    //INSERT ARTICULOS ELIMINADOS EN STOCK
    require_once '../models/Stock.php';
    require_once '../models/StockImpl.php';   
    require_once '../models/NoteDetailImpl.php';
    require_once '../models/NoteDetailImpl.php';   
    
    $objStockImpl = new StockImpl();
    $objStock = new Stock();   
    
    $objNoteDetailImpl = new NoteDetailImpl();
    $objNoteDetail = new NoteDetail();   
   
    foreach ($objDetailRemisionImpl->getByRemisionArticleDate($_POST['hiddenIdf'], $_POST['hiddenIda'], $_POST['hiddenFc']) as $valor) {
        $objStock->setCode($valor->getCodeArticle());
        $name = $objStockImpl->getNameArticle($valor->getCodeArticle());
        $objStock->setName($name);
        $objStock->setMove('D');
        $objStock->setQuantity($_POST['txbRegresar']);
        $objStock->setPriceBuy($objStockImpl->getLastPriceSold($valor->getCodeArticle(), $valor->getColor()));
        $objStock->setPriceSold($objStockImpl->getLastPriceVenta($valor->getCodeArticle(), $valor->getColor()));
        $objStock->setColor($valor->getColor());
        $objStock->setMoveDate(date("Y/m/d H:i:s"));
        $objStock->setUser($_SESSION['userCode']);        
    }
    
//    echo $objStock->getCode().'<br>';    
//    echo $objStock->getName().'<br>';
//    echo $objStock->getMove().'<br>';
//    echo $objStock->getQuantity().'<br>';
//    echo $objStock->getPriceBuy().'<br>';
//    echo $objStock->getPriceSold().'<br>';
//    echo $objStock->getColor().'<br>';
//    echo $objStock->getMoveDate().'<br>';
//    echo $objStock->getUser().'<br>';
    
    $objStockImpl->insert($objStock);
    
    $objNoteDetail->setCode($_POST['hiddenIdn']);
    $objNoteDetail->setArticle($objStock->getCode());
    $objNoteDetail->setDate(date("Y/m/d H:i:s"));
    $objNoteDetail->setQuantity($objStock->getQuantity());
    
    $variable = $_POST['hiddenValUnit']; 
    $sig[] = '.';
    $sig[] = ',';
    $valUnit = str_replace($sig, '', $variable);
    
    $objNoteDetail->setValorUnit($valUnit);  
    $objNoteDetail->setValorTotal($objStock->getQuantity() * $valUnit);
    $objNoteDetail->setColor($objStock->getColor());
    $objNoteDetail->setMove('D');
    $objNoteDetail->setDevolucion($objStock->getQuantity());
    
//    echo $objNoteDetail->getCode().'<br>';
//    echo $objNoteDetail->getArticle().'<br>';
//    echo $objNoteDetail->getDate().'<br>';
//    echo $objNoteDetail->getQuantity().'<br>';
//    echo $objNoteDetail->getValorUnit().'<br>';
//    echo $objNoteDetail->getValorTotal().'<br>';
//    echo $objNoteDetail->getColor();
//    echo $objNoteDetail->getMove();
//    echo $objNoteDetail->getDevolucion().'<br>';
    
    
    $objNoteDetailImpl->insert($objNoteDetail);
    
    if(strcmp($typeRemision, "CR") == 0){//si es pago CR
        //UPDATE TOTAL CREDIT
        require_once '../models/Credit.php';
        require_once '../models/CreditImpl.php';

        $objCreditImpl = new CreditImpl();
        $idCredit = $objCreditImpl->getId($_POST['hiddenIdf'], 'RE');

        $valCreditActual = $objCreditImpl->getValue($idCredit);
        $valCredit = $valCreditActual - $objNoteDetail->getValorTotal();
        $valSaldoActual = $objCreditImpl->getSaldo($idCredit);
        $valSaldo = $valSaldoActual - $objNoteDetail->getValorTotal();

        $objCredit = new Credit();
        $objCredit->setCode($idCredit);
        $objCredit->setValue($valCredit);
        $objCredit->setCodeBill($_POST['hiddenIdf']);
        $objCredit->setType('RE');            
        $objCredit->setSaldo($valSaldo);
        $objCreditImpl->updateValue($objCredit);
        $objCreditImpl->updateSaldo($objCredit);

        //    echo 'Code Cr'.$objCredit->getCode().'<br>';
        //    echo 'Valor Cr'.$objCredit->getValue().'<br>';
        //    echo 'Remis'.$objCredit->getCodeBill().'<br>';
        //    echo 'Saldo'.$objCredit->getSaldo().'<br>';
    }
    
    
    //UPDATE TOTAL PRICE AND IVA IN NOTE
    require_once '../models/Note.php';
    require_once '../models/NoteImpl.php';
    require_once '../models/SystemImpl.php';
    
    $objNoteImpl = new NoteImpl();
    $objNote = new Note();
    $objNote->setCode($_POST['hiddenIdn']);
    $objSystemImpl = new SystemImpl();
        
//    $totalN = $objNoteImpl->getValueByCode($_POST['hiddenIdn']);        
//    $totalIva = ($objDetailRemisionImpl->getValue($objDetailRemision) * $objSystemImpl->getValue(1)) / 100;
//    $totalNote = $totalN + $objDetailRemisionImpl->getValue($objDetailRemision) + $totalIva;
    
    $valUnitario = $objDetailRemisionImpl->getValueUnitario($objDetailRemision);
    //$totalN = ($objDetailRemisionImpl->getDevolucion($objDetailRemision) * $valUnitario) + $objNoteImpl->getValueByCode($objNote->getCode());    
    $totalN = ($objNoteDetail->getValorTotal()) + $objNoteImpl->getValueByCode($objNote->getCode());    
    $totalIva = $totalN * $objSystemImpl->getValue(1) / 100;
    $totalNote = $totalN + $totalIva;
    
    $objNote->setValue($totalNote);
    $objNote->setValueIva($totalIva);
    
    //echo $_POST['idn'].'<br>';
//    echo $objNote->getCode().'<br>';
//    echo $objNote->getValue().'<br>';
//    echo $objNote->getValueIva().'<br>';
    
    $objNoteImpl->updateTotalIva($objNote);

    echo '<script>document.location.href = "http://'.$ip.'/tp/views/notes/note_credito.php?idf='.$_POST['hiddenIdf'].'&idn='.$_POST['hiddenIdn'].'"; </script>';    
}
?>
