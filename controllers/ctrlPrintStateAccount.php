<?php
ob_start();
require ('../templates/fpdf17/fpdf.php');
require '../models/CreditImpl.php';      
require '../models/DepartmentImpl.php';
require '../models/LocalityImpl.php';

class PDF extends FPDF {
   
//Cabecera de página
    function Header() {      
        //Logo
        //$this->Image("../res/logo.jpg", 10, 8, 90, 12, "JPG");
        //Arial bold 15
        $this->SetFont('Times', '', 12);
        $this->SetTextColor(48,131,155);
        //Movernos a la derecha
        $this->Cell(80);
        //Título
        $this->Cell(0, 10, 'Calle 20 No. 1 - 25', 0, 0, 'C');
        //Salto de línea
        $this->Ln(6);
        $this->Cell(80);
        $this->SetFont('Times', '', 12);
		
        $this->Cell(0, 10, 'Santiago de Cali - Valle del Cauca', 0, 0, 'C');

        $this->Cell(-120, 20, 'Tel: XXX XX XX', 0, 0, 'C');
        $this->Ln(16);
        $this->SetFont('Times', 'B', 12);

        $this->SetFont('Times', '', 9);
        $this->Cell(110, 10, 'Consulta Estado de Cuenta: ', 0, 0, 'L');
        //$this->Cell(110);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 10, 'ESTADO DE CUENTA X CLIENTE', 0, 0, 'R');        

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
                $this->Cell(12, 7, $col, 0);
            else if($cont == 1)
                $this->Cell(14, 7, $col, 0);
            else if($cont == 2)
                $this->Cell(55, 7, $col, 0);
            else if($cont == 3)
                $this->Cell(31, 7, $col, 0);
            else if($cont == 4)
                $this->Cell(25, 7, $col, 0);
            else if($cont == 5)
                $this->Cell(20, 7, $col, 0);
            else if($cont == 6)
                $this->Cell(17, 7, $col, 0); 
            else if($cont == 7)
                $this->Cell(21, 7, $col, 0); 
           
                    
            $cont++;
        }
        $this->Ln();
        $this->Cell(0, 0, '', 1);
        $this->Ln(3);
        $this->SetFont('Times', '', 8);
        $this->SetTextColor(102,102,102);

        require_once '../models/ClientImpl.php';
        require_once '../models/CollectImpl.php';
        $objCreditImpl = new CreditImpl();
        $objClientImpl = new ClientImpl();
        $objCollectImpl = new CollectImpl();
        
        $valorTotalCreditos = 0;
        $valorTotalAbonos = 0;
        $valorTotalSaldos = 0;
        
        
        if ($objCreditImpl->getCountCreditBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbCliente'], $_POST['txbCredito'],  $_POST['txbRemision']) > 0)
        {
            foreach ($objCreditImpl->getCreditBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbCliente'], $_POST['txbCredito'],  $_POST['txbRemision']) as $valorCredit)
            {     
                $this->Cell(12, 5, $valorCredit->getCode(), 0, 0, 'C');
                $this->Cell(14, 5, $valorCredit->getCodeBill(), 0, 0, 'C');                
                $this->Cell(55, 5, $valorCredit->getCodeClient().' - '.$objClientImpl->getNameClient($valorCredit->getCodeClient()), 0);

                $this->SetFont('Times', '', 7);
                $this->Cell(31, 5, $valorCredit->getRegistrationDate(), 0); 
                $this->SetFont('Times', '', 8);

                $this->Cell(25, 5, number_format($valorCredit->getValue()), 0, 0, 'R');            
                $this->Cell(20, 5, 0, 0, 0, 'R');
                $this->Cell(17, 5, number_format($valorCredit->getValue()), 0, 0, 'R');
                $this->Cell(21, 5, floor($objCreditImpl->getDaysMora($valorCredit->getCode())), 0, 0, 'R');

                $this->Ln(6);
                
                $valorTotalCreditos += $valorCredit->getValue();
                
                foreach ($objCollectImpl->getByCredit($valorCredit->getCode()) as $valorCollect)
                {                                                                       
                    $numBill = $objCreditImpl->getBill($valorCollect->getCodeCredit());
                    $idClient = $objCreditImpl->getClient($valorCollect->getCodeCredit());
                    $nameClient = $objClientImpl->getNameClient($idClient);
                    $valueCredit = $objCreditImpl->getValue($valorCollect->getCodeCredit());
                    $pagosAnteriores = $objCollectImpl->getPagosAnterioresFecha($valorCollect->getRegistrationDate(), $valorCollect->getCodeCredit());

                    $this->Cell(12, 5, $valorCollect->getCodeCredit(), 0, 0, 'C');
                    $this->Cell(14, 5, $numBill, 0, 0, 'C');                
                    $this->Cell(55, 5, $idClient.' - '.$nameClient, 0);

                    $this->SetFont('Times', '', 7);
                    $this->Cell(31, 5, $valorCollect->getRegistrationDate(), 0); 
                    $this->SetFont('Times', '', 8);

                    $this->Cell(25, 5, number_format($valueCredit), 0, 0, 'R');            
                    $this->Cell(20, 5, number_format($valorCollect->getValue()), 0, 0, 'R');
                    $this->Cell(17, 5, number_format($valueCredit-$pagosAnteriores), 0, 0, 'R');
                    
                    if( ($valueCredit-$pagosAnteriores) == 0)
                        $this->Cell(21, 5, 0, 0, 0, 'R');
                    else
                        $this->Cell(21, 5, floor($objCreditImpl->getDaysMora($valorCollect->getCodeCredit())), 0, 0, 'R');

                    $this->Ln(6);
                    
                    $valorTotalAbonos += $valorCollect->getValue();

                }                
                
            }
            
            $valorTotalSaldos = $valorTotalCreditos - $valorTotalAbonos;
            
            $this->Cell(12, 5, '', 'C');
            $this->Cell(14, 5, '', 'C');
            $this->Cell(55, 5, '', 'C');
            $this->Cell(31, 5, '', 'C');
            $this->Cell(25, 5, number_format($valorTotalCreditos), 0, 0, 'R');            
            $this->Cell(20, 5, number_format($valorTotalAbonos), 0, 0, 'R');
            $this->Cell(17, 5, number_format($valorTotalSaldos), 0, 0, 'R');
            $this->Cell(21, 5, '', 'C');

        }
        
    }
}

//$pdf = new PDF();
$pdf=new PDF('P','mm','Letter'); 
//Títulos de las columnas
$header = array(utf8_decode('Crédito'), utf8_decode('Remisión'), '          Cliente',  '       Fecha', '      Valor', 'Abono',
 'Saldo', 'Dias Mora');
$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(50);
$pdf->TablaSimple($header);
$pdf->Output();
?>