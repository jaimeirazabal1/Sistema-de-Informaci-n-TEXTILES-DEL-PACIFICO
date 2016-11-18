<?php
ob_start();
require ('../templates/fpdf17/fpdf.php');
require '../models/RemisionImpl.php';      
require '../models/ClientImpl.php';
require '../models/DetailRemisionImpl.php';
require '../models/StockImpl.php';
require '../models/DepartmentImpl.php';
require '../models/LocalityImpl.php';
require '../models/UserImpl.php';
require '../models/SystemImpl.php';
require '../models/ColorImpl.php';
require '../models/SellerImpl.php';

class PDF extends FPDF {
   
// Cabecera de página
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
        
        $objRemisionImpl = new RemisionImpl();
        
        foreach ($objRemisionImpl->getByCode($_GET['id']) as $valorRemision) {
            $objClientImpl = new ClientImpl();
            $objDepartmentImpl = new DepartmentImpl();
            $objlocalityImpl = new LocalityImpl();
            $objUserImpl = new UserImpl();
            $objSeller = new SellerImpl();
           
            foreach ($objClientImpl->getByCode($valorRemision->getClient()) as $valor) {
                $nameClient = $valor->getName();
                $cc = $valor->getCode();
                $dir = $valor->getDirection();
                $des = $valor->getDespacho();
                $tel = $valor->getMobile();
                $deptoName = $objDepartmentImpl->getNameDepartment($valor->getCodeDepartment());
                $localityName = $objlocalityImpl->getNameLocality($valor->getCodeLocality());
            }
            $this->SetFont('Times', '', 9);
            $this->Cell(110, 6, 'Cliente: '.$nameClient, 0, 0, 'L');
            //$this->Cell(110); 
            $this->SetFont('Times', 'B', 12);
            $this->SetTextColor(48,131,155);
            $this->Cell(0, 6, 'REMISION No. '.$_GET['id'], 1, 0, 'C');
        
            $this->SetFont('Times', '', 9);
            $this->Ln();
            $this->Cell(110, 6, utf8_decode('Identificación: '.$cc), 0, 0, 'L');
            $this->Cell(0, 6, utf8_decode('Fecha de Remisión: '.$valorRemision->getGenerationDate()), 0, 0, 'L');

            $this->Ln();            
            $nameUser = $objSeller->getNameVendedor($_GET['id']);
            $this->Cell(0, 6, utf8_decode('Vendedor: '.$nameUser), 0, 0, 'L');            

            $this->Ln();
            $this->Cell(110, 6, utf8_decode('Dirección: '.$dir), 0, 0, 'L');            
            $this->Cell(110, 6, utf8_decode('Dirección Despacho: '.$des), 0, 0, 'L');            
            
            $nameUser = $objUserImpl->getNameUser($valorRemision->getUser());
            
            $this->Ln();
            $this->Cell(110, 6, utf8_decode('Teléfono: '.$tel), 0, 0, 'L');            
            $this->Ln();    
            $this->Cell(110, 6, utf8_decode('Depto/Ciudad: '.$deptoName.', '.$localityName), 0, 0, 'L');   
            $this->Ln(10);
            
        }        
    }

	// Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-40);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(70, 6, utf8_decode('!!! Después de 3 días de recibida Mercancía'), 0, 0, 'C');
        $this->Cell(120, 6, 'Recibido: __________________________________________', 0, 0, 'R');        
        $this->Ln();                
        $this->Cell(70, 6, 'NO se aceptan Reclamos x Faltantes !!!', 0, 0, 'C');
        $this->Cell(120, 6, 'CC / Nit: __________________________________________', 0, 0, 'R');
        $this->Ln(15);         
        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(102,102,102);
        
        $objSystemImpl = new SystemImpl();        
        $date = date_create($objSystemImpl->getDateStart(2));        
        //$this->Cell(0, 6, utf8_decode('Resolución DIAN No.'.$objSystemImpl->getValue(2).' del '.date_format($date, 'd-m-Y').' - Numeración Habilitada desde el No. '.$objSystemImpl->getValue(3).' hasta el No. '.$objSystemImpl->getValue(4).''), 0, 0, 'C');
    }

    // Tabla simple
    function TablaSimple($header) {
        $objRemisionImpl = new RemisionImpl();  
        $objDetailRemisionImpl = new DetailRemisionImpl();
        
            // Cabecera
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
                    $this->Cell(85, 7, $col, 0);
                else if($cont == 2)
                    $this->Cell(20, 7, $col, 0);
                else if($cont == 3)
                    $this->Cell(21, 7, $col, 0);
                else if($cont == 4)
                    $this->Cell(21, 7, $col, 0, 0, 'C');
                else if($cont == 5)
                    $this->Cell(21, 7, $col, 0);
                $cont++;
            }
            $this->Ln();
            $this->Cell(192, 0, '', 1);
            $this->Ln(3);
            $this->SetFont('Times', '', 8);
            $this->SetTextColor(102,102,102);

            $objStockImpl = new StockImpl();
            $objColorImpl = new ColorImpl();
            
            foreach ($objDetailRemisionImpl->getByCode($_GET['id']) as $valorDetailRemision) {            
                
                $this->Cell(25, 5, utf8_decode($valorDetailRemision->getCodeArticle()), 0);
                
                $nameArticle = $objStockImpl->getNameArticle($valorDetailRemision->getCodeArticle()); 
                $this->Cell(85, 5, utf8_decode($nameArticle), 0);
                $this->Cell(20, 5, utf8_decode($objColorImpl->getNameColor($valorDetailRemision->getColor())), 0);
                $this->Cell(21, 5, number_format($valorDetailRemision->getValueUnit(),0), 0, 0, 'R');
                $this->Cell(21, 5, $valorDetailRemision->getQuantity(), 0, 0, 'R');
                $this->Cell(21, 5, number_format($valorDetailRemision->getTotal()), 0, 0, 'R');                
                $this->Ln(5);                
            }
            
	// CREACION DEL TOTAL
            $this->Ln(5);            
            $this->Cell(110);            
            
        foreach ($objRemisionImpl->getByCode($_GET['id']) as $valorRemision) {
            $totalRemision = $valorRemision->getValueSale();
            $totalIva = $valorRemision->getValueIVA();
            
            $objDetailRemision = new DetailRemision();
            $objDetailRemision->setCodeRemision($_GET['id']);
            //$total = $totalRemision - $totalIva;
            $total = $objDetailRemisionImpl->getTotalDetailRemision($objDetailRemision);

            $cantidad = $objDetailRemisionImpl->getCantidadDetailRemision($objDetailRemision);
            
            $this->SetFont('Times', '', 9);
            $this->SetTextColor(102,102,102);
            $this->Cell(0, 6, 'VALOR $ '.number_format($total), 0, 0, 'R');
            $this->Ln();
            $this->Cell(0, 6, 'CANTIDAD KGS: '.($cantidad), 0, 0, 'R');
            $this->Ln();
            $this->Cell(110);            
            
            if($_GET['cj'] > 0){                 
                
                $this->Cell(0, 6, 'TOTAL CANJEABLE $ '.number_format($_GET['cj']), 0, 0, 'R');                
                
            }
            $this->Ln(2); 
            
            
            //$this->Cell(0, 6, 'IVA $ '.number_format($totalIva), 0, 0, 'R');
            $this->Ln(8);
            $this->Cell(110);
            $this->SetFont('Times', 'B', 12);
            $this->SetTextColor(48,131,155);
            $this->Cell(0, 6, 'TOTAL $ '.number_format($totalRemision), 1, 0, 'C');
        }
        
        $this->SetFont('Times', 'B', 9);
        $this->Ln(13);
        $this->Cell(0, 6, 'Observaciones:', 0, 0, 'L');
        
        foreach ($objRemisionImpl->getByCode($_GET['id']) as $valorRemision) {
            $this->SetFont('Times', '', 8);
            $this->SetTextColor(102,102,102);
            $this->Ln();
            $this->Cell(0, 6, $valorRemision->getObservation(), 0, 0, 'L');
        }        
        
    }

    // Tabla coloreada
    function TablaColores($header) {
	// Colores, ancho de línea y fuente en negrita
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
$header = array('Referencia', utf8_decode('Descripción'),'Color', '            Vr. Unit', '       Cantidad', '       Vr. Total');
$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(70);
//$pdf->AddPage();
$pdf->TablaSimple($header);
//Segunda página
//$pdf->AddPage();
//$pdf->SetY(65);
//$pdf->TablaColores($header);
$pdf->Output();
?>