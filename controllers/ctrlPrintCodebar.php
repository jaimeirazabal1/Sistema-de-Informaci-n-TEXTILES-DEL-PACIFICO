<?php
ob_start();
  include('../templates/barcode/php-barcode.php');
  require ('../templates/fpdf17/fpdf.php');
  require ('../models/StockImpl.php');
  
  // -------------------------------------------------- //
  //                      USEFUL
  // -------------------------------------------------- //
  
  class eFPDF extends FPDF{
    function TextWithRotation($x, $y, $txt, $txt_angle, $font_angle=0)
    {
        $font_angle+=90+$txt_angle;
        $txt_angle*=M_PI/180;
        $font_angle*=M_PI/180;
    
        $txt_dx=cos($txt_angle);
        $txt_dy=sin($txt_angle);
        $font_dx=cos($font_angle);
        $font_dy=sin($font_angle);
    
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',$txt_dx,$txt_dy,$font_dx,$font_dy,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
        if ($this->ColorFlag)
            $s='q '.$this->TextColor.' '.$s.' Q';
        $this->_out($s);
    }
  }

  // -------------------------------------------------- //
  //                  PROPERTIES
  // -------------------------------------------------- //
  
  $fontSize = 16;
  $marge    = 2;   // between barcode and hri in pixel
  $x        = 40;  // barcode center
  $y        = 120;  // barcode center
  $height   = 50;   // barcode height in 1D ; module size in 2D
  $width    = 1;    // barcode height in 1D ; not use in 2D
  $angle    = 90;   // rotation in degrees
  
  
  $objStockImpl = new StockImpl();
  
  
  $quantityAvailable = $objStockImpl->getQuantityAvailable($_POST['txbReferencia'],$_POST['selectColor']);
  $quantitySale = $objStockImpl->getQuantitySale($_POST['txbReferencia'],$_POST['selectColor']);
  $totalCantidad = $quantityAvailable - $quantitySale; 
  
  
  //$stringCodebar = $_POST['txbReferencia'].' '.$objStockImpl->getColor($_POST['txbReferencia']).' '.$totalCantidad;
  $stringCodebar = $_POST['txbReferencia'];
  //$code     = $_POST['hiddenCodeArticle']; // barcode, of course ;)
  $code     = $stringCodebar; // barcode, of course ;)
  $type     = 'code128';
  $black    = '000000'; // color in hexa
  
  
  // -------------------------------------------------- //
  //            ALLOCATE FPDF RESSOURCE
  // -------------------------------------------------- //
    
  //$pdf = new eFPDF('P', 'pt');
  //$pdf=new eFPDF('L','mm','a10');
  $pdf = new eFPDF('P','mm',array(250,100));
  
  // -------------------------------------------------- //
  //                      BARCODE
  // -------------------------------------------------- //
 
  
  $pdf->SetFont('Arial','B',$fontSize);
  $pdf->SetTextColor(0, 0, 0);
  
  for($pos=0; $pos<$totalCantidad; $pos++)
  {
      $pdf->AddPage();
      $data = Barcode::fpdf($pdf, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);
      $len = $pdf->GetStringWidth($data['hri']);
      Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
      $pdf->TextWithRotation($x + $xt, $y + $yt, $data['hri'], $angle);
  }
  
  
  /*$contCol = 1;
  $contFila = 1;
  
  for($pos=1; $pos<$totalCantidad; $pos++)
  {
    if($contCol <= 7)
    {
        $x = 70*$contCol;  // barcode center
        $data = Barcode::fpdf($pdf, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);
        $len = $pdf->GetStringWidth($data['hri']);
        Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
        $pdf->TextWithRotation($x + $xt, $y + $yt, $data['hri'], $angle);
        $contCol++;
    }
    else
    {
        $contCol = 1;
        $contFila++;
        $y = 190*$contFila;  // barcode center 
        
    } 
  }*/
  
  
  // -------------------------------------------------- //
  //                      HRI
  // -------------------------------------------------- //
  
 
  
  
  $pdf->Output();
?>