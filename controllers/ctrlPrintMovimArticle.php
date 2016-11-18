<?php
ob_start();
require ('../templates/fpdf17/fpdf.php');
require '../models/DetailImpl.php';
require '../models/StockImpl.php';


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

        $this->Cell(-80, 10, 'Tel: XXX XX XX', 0, 0, 'C');
        $this->Ln(15);
        $this->SetFont('Times', 'B', 12);

        $this->SetFont('Times', '', 9);
        $this->Cell(110, 6, utf8_decode('Movimientos X Artículo X Rango de Fechas: '), 0, 0, 'L');
        //$this->Cell(110);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, 'MOVIMIENTOS X ARTICULO', 1, 0, 'C');

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
        $this->Cell(192, 0, '', 1);
        $this->Ln();

        $cont = 0;
        foreach ($header as $col)
        {
            if($cont == 0)
                $this->Cell(25, 7, $col, 0);
            else if($cont == 1)
                $this->Cell(27, 7, $col, 0);
            else if($cont == 2)
                $this->Cell(55, 7, $col, 0);
            else if($cont == 3)
                $this->Cell(25, 7, $col, 0);
            else if($cont == 4)
                $this->Cell(25, 7, $col, 0);
            else if($cont == 5)
                $this->Cell(32, 7, $col, 0);
            $cont++;
        }
        $this->Ln();
        $this->Cell(192, 0, '', 1);
        $this->Ln(3);
        $this->SetFont('Times', '', 8);
        $this->SetTextColor(102,102,102);

        $objStockImpl = new StockImpl();
        
        foreach ($objStockImpl->getByArticleMovimBetweenDate($_POST['txbFechaInicio'],$_POST['txbFechaFin'], $_POST['txbReferencia']) as $valorStock) {            
            
            $this->Cell(25, 5, utf8_decode($valorStock->getRemision()), 0);
            $this->Cell(27, 5, utf8_decode($valorStock->getCliente()), 0);
            $this->Cell(55, 5, utf8_decode($valorStock->getName()), 0);
            $this->Cell(25, 5, utf8_decode($valorStock->getQuantity()), 0, 0);
            $this->Cell(25, 5, number_format($valorStock->getValorUnit()), 0, 0);
            $this->Cell(32, 5, number_format($valorStock->getValorTotal()), 0, 0);
            $this->Ln(5);                
        }        

        $kilos = $objStockImpl->getCountKilos($_POST['txbFechaInicio'], $_POST['txbFechaFin'], strtoupper($_POST['txbReferencia']));
        $total = $objStockImpl->getCountValorTotal($_POST['txbFechaInicio'], $_POST['txbFechaFin'], strtoupper($_POST['txbReferencia']));

        $this->Ln(12);
        $this->Cell(110);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 5, 'TOTAL KILOS:           '.($kilos), 0);   
        $this->Ln(7);
        $this->Cell(110);
        $this->Cell(0, 5, 'VALOR TOTAL:      '.number_format($total), 0, 0);

        $this->Ln(7);
        $this->Cell(110);
        
    }

}   
$pdf = new PDF();
//Títulos de las columnas
$header = array('Remision', 'Cliente', 'Nombre',                        'Cantidad', 'Valor Unitario', 'Valor Total');
$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(55);
$pdf->TablaSimple($header);
$pdf->Output();
?>