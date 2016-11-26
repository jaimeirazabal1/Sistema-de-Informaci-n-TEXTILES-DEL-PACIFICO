<?php
ob_start();
require ('../templates/fpdf17/fpdf.php');
require '../models/DetailImpl.php';
require '../models/StockImpl.php';
require_once '../models/SystemImpl.php';


class PDF extends FPDF {
   
//Cabecera de página
    function Header() {      
        // Logo
        //$this->Image("../res/logo.jpg", 10, 8, 60, 14, "JPG");
        // Arial bold 15
        $this->SetFont('Times', '', 10);
        $this->SetTextColor(48,131,155);
        // Movernos a la derecha
        $this->Cell(110);
        // Título
        $this->Cell(0, 0, 'Calle 20 No. 1 - 25', 0, 0, 'C');
        // Salto de línea
        $this->Ln(6);
        $this->Cell(110);
        $this->SetFont('Times', '', 10);
        $this->Cell(0, 0, 'Santiago de Cali - Valle del Cauca', 0, 0, 'C');

        $this->Cell(-150, 10, 'Tel: XXX XX XX', 0, 0, 'C');     
		
        $this->Ln(15);
        $this->SetFont('Times', 'B', 12);

        $this->SetFont('Times', '', 9);
        $this->Cell(110, 6, 'Inventario por Rango de Fechas: ', 0, 0, 'L');
        //$this->Cell(110);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, strtoupper('Reporte de Movimientos Kardex'), 1, 0, 'C');

        $this->SetFont('Times', '', 9);
        $this->Ln();

        $this->Cell(110, 6, utf8_decode('Desde: '.$_POST['txbFechaInicio'].'    Hasta: '.$_POST['txbFechaFin']), 0, 0, 'L');
        
        if(strcmp($_POST['txbReferencia'], "") == 0)
            $this->Cell(0, 6, utf8_decode('Referencia: TODOS'), 0, 0, 'L');
        else
            $this->Cell(0, 6, utf8_decode('Referencia: '.strtoupper($_POST['txbReferencia'])), 0, 0, 'L');
        
        
        $this->Ln();
        $this->Cell(110, 6, '', 0, 0, 'L');                        
        $this->Cell(110, 6, utf8_decode('Fecha de Generación: '.date("Y/m/d H:i:s")), 0, 0, 'L');
        $this->Ln(10);
    }

//    Pie de página
    function Footer() {
//        //Posición: a 1,5 cm del final
//        $this->SetY(-15);
//        //Arial italic 8
//        $this->SetFont('Arial', 'I', 8);
//        //Número de página
//        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    //Tabla simple
    function TablaSimple($header) {        
        //Cabecera
        $this->SetFont('Times', 'B', 9);
        $this->SetTextColor(48,131,155);
        $this->Cell(0, 0, '', 1);
        $this->Ln();

        $cont = 0;
        foreach ($header as $col)
        {
            if($cont == 0)
                $this->Cell(25, 7, $col, 0);
            else if($cont == 1)
                $this->Cell(40, 7, $col, 0);
            else if($cont == 2)
                $this->Cell(25, 7, $col, 0);
            else if($cont == 3)
                $this->Cell(25, 7, $col, 0, 0, 'C');
            else if($cont == 4)
                $this->Cell(25, 7, $col, 0, 0, 'C');            
            else if($cont == 5)
                $this->Cell(25, 7, $col, 0, 0, 'C');
            else if($cont == 6)
                $this->Cell(25, 7, $col, 0);
            else if($cont == 7)
                $this->Cell(25, 7, $col, 0);
            else if($cont == 8)
                $this->Cell(25, 7, $col, 0);
            $cont++;
        }
        $this->Ln();
        $this->Cell(0, 0, '', 1);
        $this->Ln(3);
        $this->SetFont('Times', '', 8);
        $this->SetTextColor(102,102,102);

        $objStockImpl = new StockImpl();
        $totalCostoInventario = 0;
        
        $objSystemImpl = new SystemImpl();
        $data = $objStockImpl->reporte_de_movimientos_kardex_comprimido();
        foreach ($data[0] as $valorStock) {            
      
        
            $this->Cell(25, 5, $valorStock['DOCUMENTO'], 0, 0, 'L');
            $this->Cell(25, 5, $valorStock['FECHA'], 0, 0, 'R');
            $this->Cell(25, 5, number_format($valorStock['ENTRADA'],2), 0, 0, 'R');
            $this->Cell(25, 5, number_format($valorStock['SALIDA'],2), 0, 0, 'R');
            $this->Cell(25, 5, number_format($valorStock['SALDO KGS'],2), 0, 0, 'R');
            $this->Cell(25, 5, $valorStock['COSTO UNITARIO'], 0, 0, 'R');
            $this->Cell(25, 5, $valorStock['COSTO ENTRADA'], 0, 0, 'R');
            $this->Cell(25, 5, $valorStock['COSTO SALIDA'], 0, 0, 'R');
            $this->Cell(25, 5, $valorStock['SALDO EN PESOS'], 0, 0, 'R');
            $this->Ln(5);                
            
        }  
         
        $this->Ln(5); 
        $this->Cell(25, 5, '', 0);
        $this->Cell(25, 5, '', 0);
        $this->Cell(25, 5, number_format($data[1]['totalEntradas'],2), 0, 0, 'R');
        $this->Cell(25, 5, number_format($data[1]['totalSalidas'],2), 0, 0, 'R');
        $this->Cell(25, 5, number_format($data[1]['totalEntradas']-$data[1]['totalSalidas'],2), 0, 0, 'R');
        $this->Cell(25, 5, '', 0, 0, 'R');
        $this->Cell(25, 5, number_format($data[1]['totalCostoEntradas'],2), 0, 0, 'R');
        $this->Cell(25, 5, number_format($data[1]['totalCostoSalidas'],2), 0, 0, 'R');
        $this->Cell(25, 5, number_format($data[1]['totalCostoEntradas']-$data[1]['totalCostoSalidas'],2), 0, 0, 'R');
        $this->Ln(5); 

    }

    //Tabla coloreada
    function TablaColores($header) {
//Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
//Cabecera

        for ($i = 0; $i < count($header); $i++)
            $this->Cell(40, 7, $header[$i], 1, 0, 'C', 1);
        $this->Ln();
//Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
//Datos
        $fill = false;
        $this->Cell(40, 6, "hola", 'LR', 0, 'L', $fill);
        $this->Cell(40, 6, "hola2", 'LR', 0, 'L', $fill);
        $this->Cell(40, 6, "hola3", 'LR', 0, 'R', $fill);
        $this->Cell(40, 6, "hola4", 'LR', 0, 'R', $fill);
        $this->Ln();
        $fill = !$fill;
        $this->Cell(40, 6, "col", 'LR', 0, 'L', $fill);
        $this->Cell(40, 6, "col2", 'LR', 0, 'L', $fill);
        $this->Cell(40, 6, "col3", 'LR', 0, 'R', $fill);
        $this->Cell(40, 6, "col4", 'LR', 0, 'R', $fill);
        $fill = true;
        $this->Ln();
        $this->Cell(160, 0, '', 'T');
    }

}
$pdf=new PDF('L','mm','Letter'); 
//Títulos de las columnas
$header = array('Documento','Fecha', 'Entrada','Salida','Salgo Kgs', 'Costo Unitario', 'Costo Entrada','Costo Salida','Saldo en Pesos');
$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(55);
//$pdf->AddPage();
$pdf->TablaSimple($header);
//Segunda página
//$pdf->AddPage();
//$pdf->SetY(65);
//$pdf->TablaColores($header);
$pdf->Output();
?>