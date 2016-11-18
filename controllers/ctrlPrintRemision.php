<?php
ob_start();
require ('../templates/fpdf17/fpdf.php');
require '../models/RemisionImpl.php';      
//require '../models/ClientImpl.php';
//require '../models/DetailImpl.php';
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
        $this->Cell(110, 6, 'Remisiones X Rango de Fechas: ', 0, 0, 'L');
        //$this->Cell(110);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, 'REMISIONES X FECHA', 1, 0, 'C');

        $this->SetFont('Times', '', 9);
        $this->Ln();

        $this->Cell(110, 6, utf8_decode('Desde: '.$_POST['txbFechaInicio'].'    Hasta: '.$_POST['txbFechaFin']), 0, 0, 'L');
        
        if(strcmp($_POST['txbReferencia'], "") == 0)
            $this->Cell(0, 6, utf8_decode('Referencia: TODOS'), 0, 0, 'L');
        else
            $this->Cell(0, 6, utf8_decode('Referencia: '.strtoupper($_POST['txbReferencia'])), 0, 0, 'L');
        
        $this->Ln();
        $this->Cell(110, 6, utf8_decode('Fecha de Generación: '.date("Y/m/d H:i:s")), 0, 0, 'L');
        
        if(strcmp($_POST['txbReferencia'], "") != 0)
        {
            $objStckImpl = new StockImpl();        
            $this->Cell(0, 6, utf8_decode('Artículo: '.$objStckImpl->getNameArticle($_POST['txbReferencia'])), 0, 0, 'L');
        }
        else if(strcmp($_POST['txbArticulo'], "") != 0)
        {        
            $this->Cell(0, 6, utf8_decode('Artículo: '.strtoupper($_POST['txbArticulo'])), 0, 0, 'L');
        }
        else{
            $this->Cell(0, 6, utf8_decode('Artículo: N/A'), 0, 0, 'L');
        }
        $this->Ln();
        
        $this->Cell(110, 6, '', 0, 0, 'L');
        if(strcmp($_POST['txbCliente'], "") == 0)
            $this->Cell(0, 6, utf8_decode('Cliente: TODOS'), 0, 0, 'L');
        else
            $this->Cell(0, 6, utf8_decode('Cliente: '.$_POST['txbCliente']), 0, 0, 'L');
        
        $this->Ln();
        $this->Cell(110, 6, '', 0, 0, 'L');
        
        /*if(strcmp($_POST['comboPayment'], "TODOS") == 0)
            $this->Cell(0, 6, utf8_decode('Forma de Pago: TODOS'), 0, 0, 'L');
        else if(strcmp($_POST['comboPayment'], "CONTADO") == 0)
            $this->Cell(0, 6, utf8_decode('Forma de Pago: CONTADO'), 0, 0, 'L');
        else if(strcmp($_POST['comboPayment'], "CREDITO") == 0)
            $this->Cell(0, 6, utf8_decode('Forma de Pago: CREDITO'), 0, 0, 'L');*/
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
                $this->Cell(35, 7, $col, 0);
            else if($cont == 1)
                $this->Cell(21, 7, $col, 0);
            else if($cont == 2)
                $this->Cell(31, 7, $col, 0);
            else if($cont == 3)
                $this->Cell(70, 7, $col, 0);
            else if($cont == 4)
                $this->Cell(35, 7, $col, 0);
            $cont++;
        }
        $this->Ln();
        $this->Cell(192, 0, '', 1);
        $this->Ln(3);
        $this->SetFont('Times', '', 8);
        $this->SetTextColor(102,102,102);

        $objRemisionImpl = new RemisionImpl();
        
        require_once '../models/ClientImpl.php';
        $objClientImpl = new ClientImpl();
        
        foreach ($objRemisionImpl->getByReport($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia'],  $_POST['txbArticulo'], $_POST['txbCliente'], $_POST['comboPayment']) as $valorRemision) {            
            //$this->Cell(25, 5, utf8_decode($valorStock->getCode()), 0);
            $this->Cell(35, 5, $valorRemision->getGenerationDate(), 0);
            $this->Cell(21, 5, $valorRemision->getCode(), 0);
            $this->Cell(31, 5, $valorRemision->getClient(), 0);
            $this->Cell(70, 5, $objClientImpl->getNameClient($valorRemision->getClient()), 0);

            $this->Cell(35, 5, number_format($valorRemision->getValueSale()), 0, 0, 'R');            
            $this->Ln(6);
        }
        
        if(strcmp($_POST['txbCliente'], "") != 0)
        {
            $this->Ln(12);
            $this->Cell(110);
            $this->SetFont('Times', 'B', 12);
            $this->Cell(0, 5, "TOTAL REMISIONES CLIENTE: $ ".number_format ($objRemisionImpl->getSumByClient($_POST['txbCliente'], $_POST['txbFechaInicio'], $_POST['txbFechaFin'], strtoupper($_POST['txbReferencia']), $_POST['comboPayment'])), 0);            
        }

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

$pdf = new PDF();
//Títulos de las columnas
$header = array('Fecha', 'Factura', 'NIT/CC', 'Cliente', 'Valor Factura');
$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(63);
//$pdf->AddPage();
$pdf->TablaSimple($header);
//Segunda página
//$pdf->AddPage();
//$pdf->SetY(65);
//$pdf->TablaColores($header);
$pdf->Output();
?>