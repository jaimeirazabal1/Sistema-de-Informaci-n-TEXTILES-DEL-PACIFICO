<?php
session_start();

if(isset($_POST)){    
    require_once '../models/DetailCxp.php';
    require_once '../models/DetailCxpImpl.php';   
   
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    //UPDATE REGRESADO EN EL DETALLE
    $objDetailCxp = new DetailCxp();
    $objDetailCxp->setCodeCxp($_POST['hiddenIdf']);    
    $objDetailCxp->setCodeArticle($_POST['hiddenIda']);
    $objDetailCxp->setColor($_POST['hiddenCl']);
    
    $objDetailCxpImpl = new DetailCxpImpl();
    $objDetailCxp->setDevolucion($_POST['txbRegresar'] + $objDetailCxpImpl->getDevolucion($objDetailCxp));
    $objDetailCxpImpl->updateDevolucion($objDetailCxp);
    $verificar = $objDetailCxpImpl->verificarDevolucion($objDetailCxp);
    
    
    if($verificar == 0)
        $objDetailCxpImpl->updateMovimiento($objDetailCxp);
    
    //INSERT ARTICULOS ELIMINADOS EN STOCK
    require_once '../models/Stock.php';
    require_once '../models/StockImpl.php';
      
    require_once '../models/NoteDetailImpl.php';
    require_once '../models/NoteDetailImpl.php';  
    
    $objStockImpl = new StockImpl();
    $objStock = new Stock();    
    
    $objNoteDetailImpl = new NoteDetailImpl();
    $objNoteDetail = new NoteDetail();  
   
    foreach ($objDetailCxpImpl->getByCxpArticleDate($_POST['hiddenIdf'], $_POST['hiddenIda'], $_POST['hiddenFc']) as $valor) {
        $objStock->setCode($valor->getCodeArticle());
        $name = $objStockImpl->getNameArticle($valor->getCodeArticle());
        $objStock->setName($name);
        $objStock->setMove('P');
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
    
    
    require_once '../models/Note.php';
    require_once '../models/NoteImpl.php';
    require_once '../models/SystemImpl.php';
    
    $objNoteImpl = new NoteImpl();
    $objNote = new Note();
    $objNote->setCode($_POST['hiddenIdn']);
    $objSystemImpl = new SystemImpl();
    
    //UPDATE TOTAL CXP
    require_once '../models/Cxp.php';
    require_once '../models/CxpImpl.php';

    $objCxpImpl = new CxpImpl();
    $idCxp = $_POST['hiddenIdf'];

    $valCxpActual = $objCxpImpl->getValue($idCxp);
    $valCxp = $valCxpActual - $objNoteDetail->getValorTotal();
    $valSaldoActual = $objCxpImpl->getSaldo($idCxp);
    $valSaldo = $valSaldoActual - $objNoteDetail->getValorTotal();
    $totalIvaCxp = $valCxp * $objSystemImpl->getValue(1) / 100;
    $totalCxp = $valCxp + $totalIvaCxp;
    
    
    $objCxp = new Cxp();
    $objCxp->setCode($idCxp);
    $objCxp->setTotalCuenta($totalCxp);
    $objCxp->setSaldoCuenta($valSaldo);
    $objCxp->setIva($totalIvaCxp);    
    
//    echo 'Code Cxp'.$objCxp->getCode().'<br>';
//        echo 'Valor Cxp'.$objCxp->getTotalCuenta().'<br>';
//        echo 'Saldo Cxp'.$objCxp->getSaldoCuenta().'<br>';
//        echo 'Iva Cxp'.$objCxp->getIva().'<br>';
    
    
    $objCxp->setSaldoCuenta($valSaldo);
    $objCxpImpl->updateTotal($objCxp);
    $objCxpImpl->updateSaldo($objCxp);

        
    
    
    
    //UPDATE TOTAL PRICE AND IVA IN NOTE   
        
//    $totalN = $objNoteImpl->getValueByCode($_POST['hiddenIdn']);        
//    $totalIva = ($objDetailCxpImpl->getValue($objDetailCxp) * $objSystemImpl->getValue(1)) / 100;
//    $totalNote = $totalN + $objDetailCxpImpl->getValue($objDetailCxp) + $totalIva;
    
    $valUnitario = $objDetailCxpImpl->getValueUnitario($objDetailCxp);    
    //$totalN = ($objDetailCxpImpl->getDevolucion($objDetailCxp) * $valUnitario) + $objNoteImpl->getValueByCode($objNote->getCode());   
    $totalN = ($objNoteDetail->getValorTotal()) + $objNoteImpl->getValueByCode($objNote->getCode());   
    $totalIva = $totalN * $objSystemImpl->getValue(1) / 100;
    $totalNote = $totalN + $totalIva;
    
    $objNote->setValue($totalNote);
    $objNote->setValueIva($totalIva);
    
//    echo $_POST['idn'].'<br>';
//    echo $objNote->getCode().'<br>';
//    echo $objNote->getValue().'<br>';
//    echo $objNote->getValueIva().'<br>';
    
    $objNoteImpl->updateTotalIva($objNote);

    echo '<script>document.location.href = "http://'.$ip.'/tp/views/notes/note_debito.php?idf='.$_POST['hiddenIdf'].'&idn='.$_POST['hiddenIdn'].'"; </script>';    
}
?>
