<?php
ob_start();
require ('../templates/fpdf17/fpdf.php');
require '../models/CollectCxpImpl.php';      
require '../models/ClientImpl.php';
require '../models/DetailImpl.php';
require '../models/StockImpl.php';
require '../models/DepartmentImpl.php';
require '../models/LocalityImpl.php';
require '../models/UserImpl.php';
require '../models/CreditImpl.php';
require '../models/ConceptImpl.php';
require '../models/Letras.php';
require '../models/CxpImpl.php';

class PDF extends FPDF {
   
//Cabecera de página
    function Header() {      
        // Logo
        //$this->Image("../res/logo.jpg", 10, 8, 90, 12, "JPG");
        // Arial bold 15
        $this->SetFont('Times', '', 12);
        $this->SetTextColor(48,131,155);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(0, 0, 'Calle 20 No. 1 - 25', 0, 0, 'C');
        // Salto de línea
        $this->Ln(6);
        $this->Cell(80);
        $this->SetFont('Times', '', 12);
        $this->Cell(0, 0, 'Santiago de Cali - Valle del Cauca', 0, 0, 'C');

        $this->Cell(-110, 12, 'Tel. XXX XX XX', 0, 0, 'C');
	$this->Ln(15);
        $this->SetFont('Times', 'B', 12);	
        
        
        $objCxpImpl= new CxpImpl();
        $objCollectCxp  = new CollectCxpImpl();
        $objCxpImpl = new CxpImpl();
        $objClientImpl = new ClientImpl(); 
        
        foreach ($objCollectCxp->getByCode($_GET['id']) as $valorCollectCxp) {                                  
            foreach ($objCxpImpl->getByCode($valorCollectCxp->getCodeCxp()) as $valorCxp) {
                $nameClient = $objClientImpl->getNameClient($valorCxp->getProveedor());
            }
            
            
            $this->SetFont('Times', '', 9);
            $this->Cell(98, 6, 'A NOMBRE DE: '.$nameClient, 0, 0, 'L');
            //$this->Cell(110);
            $this->SetFont('Times', 'B', 12);
            $this->Cell(0, 6, 'COMPROBANTE DE EGRESO NO. '.$_GET['id'], 1, 0, 'C');
            $this->SetFont('Times', '', 9);
            $this->Ln();            
            $this->Cell(110, 6, utf8_decode('FECHA: '.date('Y-m-d')), 0, 0, 'L');
        }      
    }
    

//    Pie de página
    function Footer() {
        $this->Cell(-110, 500, 'Recibido: _____________________________', 0, 0, 'C');
        $this->Cell(110, 510, 'CC / Nit: _____________________________', 0, 0, 'C');
    }

    // Tabla simple
    function TablaSimple($header) {        
            // Cabecera
            $this->SetFont('Times', 'B', 9);
            $this->SetTextColor(48,131,155);
            $this->Cell(192, 0, '', 1);
            $this->Ln();
            
            $cont = 0;
            foreach ($header as $col)
            {
                if($cont == 0)
                    $this->Cell(21, 7, $col, 0);
                else if($cont == 1)
                    $this->Cell(35, 7, $col, 0);
                else if($cont == 2)
                    $this->Cell(45, 7, $col, 0);
                else if($cont == 3)
                    $this->Cell(35, 7, $col, 0);
                else if($cont == 4)
                    $this->Cell(30, 7, $col, 0);
                else if($cont == 5)
                    $this->Cell(30, 7, $col, 0);
                
                $cont++;
            }
            $this->Ln();
            $this->Cell(192, 0, '', 1);
            $this->Ln(3);
            $this->SetFont('Times', '', 8);
            $this->SetTextColor(102,102,102);
            
            $objCxpImpl= new CxpImpl();
            $objCollectCxp  = new CollectCxpImpl();
            $objClientImpl = new ClientImpl();                       
            
            foreach ($objCollectCxp->getByCode($_GET['id']) as $valorCollectCxp) {
                foreach ($objCxpImpl->getByCode($valorCollectCxp->getCodeCxp()) as $valorCxp) {
                    $nameClient = $objClientImpl->getNameClient($valorCxp->getProveedor());
                }
                
                $this->Cell(21, 5, $valorCollectCxp->getCode(), 0, 0, 'L');
                $this->Cell(35, 5, $valorCollectCxp->getRegistrationDate(), 0, 0, 'L');
                //$nameClient = $objClientImpl->getNameClient($valorCxp->getProveedor());
                $this->Cell(45, 5, $nameClient, 0, 0, 'L');
                $this->Cell(35, 5, $valorCxp->getProveedor(), 0, 0, 'L');
                $this->Cell(30, 5, number_format($valorCollectCxp->getValue()), 0, 0, 'L');
                $this->Cell(30, 5, number_format($valorCollectCxp->getValue()), 0, 0, 'L');
            }
            $this->Ln(25);
            $this->Cell(96, 5, 'PREPARADO', 0, 0, 'L');
            $this->Cell(96, 5, 'RECIBIDO', 0, 0, 'L');
            $this->Ln(11);
            $this->Cell(60, 0, '', 1);
            $this->Cell(36, 0, '', 0);
            $this->Cell(60, 0, '', 1);

    }   

}

$pdf=new PDF('L','mm', array(115, 215));
// Títulos de las columnas
$header = array('CxP', 'Fecha', 'Beneficiario','NIT', utf8_decode('Débito'), utf8_decode('Crédito'));

$pdf->AliasNbPages();
//// Primera página
$pdf->AddPage();
$pdf->SetY(45);
$pdf->TablaSimple($header);
$pdf->Output();
?>