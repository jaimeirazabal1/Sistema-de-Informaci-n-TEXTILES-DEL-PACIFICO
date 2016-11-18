<?php
ob_start();
require ('../templates/fpdf17/fpdf.php');
require '../models/BillImpl.php';      
require '../models/ClientImpl.php';
require '../models/DetailImpl.php';
require '../models/StockImpl.php';
require '../models/DepartmentImpl.php';
require '../models/LocalityImpl.php';
require '../models/UserImpl.php';
require '../models/SystemImpl.php';
require '../models/ColorImpl.php';

class PDF extends FPDF {
   
//Cabecera de página
    function Header() {      
        //Logo
        $this->Image("../res/logo.jpg", 10, 8, 60, 14, "JPG");
        //Arial bold 15
        $this->SetFont('Times', '', 10);
        $this->SetTextColor(48,131,155);
        //Movernos a la derecha
        $this->Cell(110);
        //Título
        $this->Cell(0, 0, 'Calle 4 No. 11 - 86 - Santander de Quilichao - Cauca', 0, 0, 'C');
        //Salto de línea
        $this->Ln(6);
        $this->Cell(110);
        $this->SetFont('Times', '', 10);
        $this->Cell(0, 0, 'NIT. 900 592 048 - 7', 0, 0, 'C');

        $this->Cell(-80, 10, 'Tel: 829 20 77', 0, 0, 'C');        
		
        

        $this->Ln(15);
        $this->SetFont('Times', 'B', 12);
        
        
        $objBillImpl = new BillImpl();
        
        foreach ($objBillImpl->getByCode($_GET['id']) as $valorBill) {
            $objClientImpl = new ClientImpl();
            $objDepartmentImpl = new DepartmentImpl();
            $objlocalityImpl = new LocalityImpl();
            $objUserImpl = new UserImpl();
            
            foreach ($objClientImpl->getByCode($valorBill->getClient()) as $valor) {
                $nameClient = $valor->getName();
                $cc = $valor->getCode();
                $dir = $valor->getDirection();
                $tel = $valor->getMobile();
                $deptoName = $objDepartmentImpl->getNameDepartment($valor->getCodeDepartment());
                $localityName = $objlocalityImpl->getNameLocality($valor->getCodeLocality());
            }
            $this->SetFont('Times', '', 9);
            $this->Cell(110, 6, 'Cliente: '.$nameClient, 0, 0, 'L');
            //$this->Cell(110); 
            $this->SetFont('Times', 'B', 12);
            $this->SetTextColor(48,131,155);
            $this->Cell(0, 6, 'FACTURA No. '.$_GET['id'], 1, 0, 'C');
        
            $this->SetFont('Times', '', 9);
            $this->Ln();
            $this->Cell(110, 6, utf8_decode('Identificación: '.$cc), 0, 0, 'L');
            $this->Cell(0, 6, utf8_decode('Fecha de Remisión: '.$valorBill->getGenerationDate()), 0, 0, 'L');
            $this->Ln();
            $this->Cell(110, 6, utf8_decode('Dirección: '.$dir), 0, 0, 'L');            
            
            $nameUser = $objUserImpl->getNameUser($valorBill->getUser());
            $this->Cell(0, 6, utf8_decode('Vendedor: '.$nameUser), 0, 0, 'L');            
            
            $this->Ln();
            $this->Cell(110, 6, utf8_decode('Teléfono: '.$tel), 0, 0, 'L');            
            $this->Ln();    
            $this->Cell(110, 6, utf8_decode('Depto/Ciudad: '.$deptoName.', '.$localityName), 0, 0, 'L');   
            $this->Ln(10);
        }        
    }

//    Pie de página
    function Footer() {
        //Posición: a 1,5 cm del final
        $this->SetY(-40);
        //Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        //Número de página
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
        $this->Cell(0, 6, utf8_decode('Resolución DIAN No.'.$objSystemImpl->getValue(2).' del '.date_format($date, 'd-m-Y').' - Numeración Habilitada desde el No. '.$objSystemImpl->getValue(3).' hasta el No. '.$objSystemImpl->getValue(4).''), 0, 0, 'C');
    }

    //Tabla simple
    function TablaSimple($header) {
        $objBillImpl = new BillImpl();  
        $objDetailImpl = new DetailImpl();
        
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
        
            
            foreach ($objDetailImpl->getByCode($_GET['id']) as $valorDetail) {            
                
                
                $this->Cell(25, 5, utf8_decode($valorDetail->getCodeArticle()), 0);
                
                $nameArticle = $objStockImpl->getNameArticle($valorDetail->getCodeArticle()); 
                $this->Cell(85, 5, utf8_decode($nameArticle), 0);
                $this->Cell(20, 5, utf8_decode($objColorImpl->getNameColor($valorDetail->getColor())), 0);
                $this->Cell(21, 5, number_format($valorDetail->getValueUnit(),0), 0, 0, 'R');
                $this->Cell(21, 5, number_format($valorDetail->getQuantity(),0), 0, 0, 'R');
                $this->Cell(21, 5, number_format($valorDetail->getTotal()), 0, 0, 'R');                
                $this->Ln(5);                
            }
            
//            CREACION DEL TOTAL
            $this->Ln(5);            
            $this->Cell(110);            
            
        foreach ($objBillImpl->getByCode($_GET['id']) as $valorBill) {
            $totalBill = $valorBill->getValueSale();
            $totalIva = $valorBill->getValueIVA();
            
            $objDetail = new Detail();
            $objDetail->setCodeBill($_GET['id']);
            //$total = $totalBill - $totalIva;
            $total = $objDetailImpl->getTotalDetailBill($objDetail);
            
            
            
            $this->SetFont('Times', '', 9);
            $this->SetTextColor(102,102,102);
            $this->Cell(0, 6, 'VALOR $ '.number_format($total), 0, 0, 'R');
            $this->Ln();
            $this->Cell(110);            
            $this->Cell(0, 6, 'IVA $ '.number_format($totalIva), 0, 0, 'R');
            $this->Ln(8);
            $this->Cell(110);
            $this->SetFont('Times', 'B', 12);
            $this->SetTextColor(48,131,155);
            $this->Cell(0, 6, 'TOTAL $ '.number_format($totalBill), 1, 0, 'C');
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
$header = array('Referencia', utf8_decode('Descripción'),'Color', '            Vr. Unit', '       Cantidad', '       Vr. Total');

$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(65);
//$pdf->AddPage();
$pdf->TablaSimple($header);
//Segunda página
//$pdf->AddPage();
//$pdf->SetY(65);
//$pdf->TablaColores($header);
$pdf->Output();
?>