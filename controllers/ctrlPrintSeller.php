<?php
ob_start();
require ('../templates/fpdf17/fpdf.php');
require '../models/ClientImpl.php'; 


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
        $this->Cell(110, 10, 'Consulta Eficiencia Vendedoras: ', 0, 0, 'L');
        //$this->Cell(110);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 10, 'EFICIENCIA VENDEDORAS', 0, 0, 'R');        

        $this->SetFont('Times', '', 9);
        $this->Ln();

        $this->Cell(110, 2, utf8_decode('Desde: '.$_POST['txbFechaInicio'].'    Hasta: '.$_POST['txbFechaFin']), 0, 0, 'L');
        $this->Cell(0, 2, utf8_decode('Fecha Reporte: '.  date(("Y/m/d H:i:s"))), 0, 0, 'R');
        $this->Ln(10); 
    }

//    Pie de página
    function Footer() {

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
                $this->Cell(50, 7, $col, 0);
            else if($cont == 1)
                $this->Cell(50, 7, $col, 0);
            else if($cont == 2)
                $this->Cell(90, 7, $col, 0);           
                    
            $cont++;
        }
        $this->Cell(0, 0, '', 1);
        $this->Ln(8);
        $this->SetFont('Times', '', 8);
        $this->SetTextColor(102,102,102);

        $objClientImpl = new ClientImpl();
        
        
            foreach ($objClientImpl->getReportSeller($_POST['txbFechaInicio'], $_POST['txbFechaFin']) as $valorSeller)
            {
                $this->Cell(50, 5, $valorSeller->getCodeDepartment(), 0, 0, 'R');
                $this->Cell(50, 5, $valorSeller->getCode(), 0);                
                $this->Cell(90, 5, $valorSeller->getName(), 0);
                $this->Ln();
            }
        }   
}

$pdf = new PDF();
//$pdf=new PDF('L','mm','Letter'); 
//Títulos de las columnas
$header = array('Cantidad', utf8_decode('Código'), 'Vendedor');
$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(50);
$pdf->TablaSimple($header);
$pdf->Output();
?>