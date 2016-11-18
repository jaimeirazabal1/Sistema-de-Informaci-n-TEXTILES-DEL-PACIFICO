<?php
ob_start();
require ('../templates/fpdf17/fpdf.php');
require '../models/CreditImpl.php';      
require '../models/DepartmentImpl.php';
require '../models/LocalityImpl.php';
require_once '../models/ClientImpl.php';


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
        $this->Cell(0, 0, 'Calle 20 No. 1 - 25', 0, 0, 'C');

		$this->Cell(-180, 10, 'Santiago de Cali - Valle del Cauca', 0, 0, 'C');

        //Salto de línea
        $this->Ln(6);
        $this->Cell(80);
        $this->SetFont('Times', '', 12);
        $this->Cell(0, 8, 'Tel: XXX XX XX', 0, 0, 'C');
        $this->Ln(15);
        $this->SetFont('Times', 'B', 12);

        $this->SetFont('Times', '', 9);
        $this->Cell(110, 6, 'Estado de Cuenta: ', 0, 0, 'L');
        //$this->Cell(110);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, 'ESTADO DE CUENTA GENERAL', 0, 0, 'R');        

        $this->SetFont('Times', '', 9);
        $this->Ln();

        $this->Cell(110, 6, utf8_decode('Desde: '.$_POST['txbFechaInicio'].'    Hasta: '.$_POST['txbFechaFin']), 0, 0, 'L');
        $this->Cell(0, 6, utf8_decode('Fecha Reporte: '.  date(("Y/m/d H:i:s"))), 0, 0, 'R');
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
                $this->Cell(12, 7, $col, 0);
            else if($cont == 1)
                $this->Cell(14, 7, $col, 0);
            else if($cont == 2)
                $this->Cell(60, 7, $col, 0);
            else if($cont == 3)
                $this->Cell(46, 7, $col, 0);
            else if($cont == 4)
                $this->Cell(21, 7, $col, 0);
            else if($cont == 5)
                $this->Cell(25, 7, $col, 0);
            else if($cont == 6)
                $this->Cell(30, 7, $col, 0);
            else if($cont == 7)
                $this->Cell(21, 7, $col, 0);
            else if($cont == 8)
                $this->Cell(21, 7, $col, 0);            
                    
            $cont++;
        }
        $this->Ln();
        $this->Cell(0, 0, '', 1);
        $this->Ln(3);
        $this->SetFont('Times', '', 7);
        $this->SetTextColor(102,102,102);

        require_once '../models/ClientImpl.php';
        $objCreditImpl = new CreditImpl();
        
        $totalCreditos = 0;
        $totalAbonos = 0;
        $totalSaldos = 0;
        
//        $objDepartmentImpl = new DepartmentImpl();
//        $objLocalityImpl = new LocalityImpl();
        $objClientImpl = new ClientImpl();
        
        foreach ($objCreditImpl->getCreditOnlyBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin']) as $valorCredit) {     
            $addressClient = $objClientImpl->getAddressClient($valorCredit->getCodeClient());
            $mobileClient = $objClientImpl->getMobileClient($valorCredit->getCodeClient());
//            $idDpto = $objClientImpl->getDepartment($valorCredit->getCodeClient());
//            $idLclt = $objClientImpl->getLocality($valorCredit->getCodeClient());
            
            $this->Cell(12, 5, $valorCredit->getCode(), 0, 0, 'C');
            $this->Cell(14, 5, $valorCredit->getCodeBill(), 0, 0, 'C'); 
            
            $objClientImpl = new ClientImpl();
            $this->Cell(60, 5, $valorCredit->getCodeClient().' - '. $objClientImpl->getNameClient($valorCredit->getCodeClient()), 0);
            $this->Cell(46, 5, $addressClient, 0);
            $this->Cell(21, 5, $mobileClient, 0, 0, 'C');
//            $this->Cell(35, 5, $objLocalityImpl->getNameLocality($idLclt), 0);

            $this->SetFont('Times', '', 7);
            $this->Cell(25, 5, $valorCredit->getRegistrationDate(), 0); 
            $this->SetFont('Times', '', 7);
            
            $this->Cell(30, 5, number_format($valorCredit->getValue()), 0, 0, 'R');            
            $this->Cell(21, 5, number_format($valorCredit->getSaldo()), 0, 0, 'R');
            
            $totalCreditos += $valorCredit->getValue();
            $totalAbonos += ($valorCredit->getValue() - $valorCredit->getSaldo());
            $totalSaldos += $valorCredit->getSaldo();

            $this->Cell(21, 5, floor($objCreditImpl->getDaysMora($valorCredit->getCode())), 0, 0, 'R');
			$this->Ln(5);
			$this->Cell(0, 0, '', 1);
			$this->Ln(1);

        }
        
        $this->Cell(12, 5, '', 0);
        $this->Cell(14, 5, '', 0);
        $this->Cell(60, 5, '', 0);
        $this->Cell(46, 5, '', 0);
        $this->Cell(21, 5, '', 0);
        $this->Cell(25, 5, '', 0);
        $this->Cell(30, 5, '', 0);
        $this->Cell(21, 5, number_format($totalCreditos), 0, 0, 'R');
        $this->Cell(21, 5, number_format($totalSaldos), 0, 0, 'R');      

    }
    
}

$pdf=new PDF('L','mm','Letter'); 
//Títulos de las columnas
$header = array(utf8_decode('Crédito'), utf8_decode('Remisión'), 'Cliente', utf8_decode('Dirección'), '     Celular',  
'Fecha', '                    VALOR', '          SALDO', '         DIAS MORA');
$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(50);
$pdf->TablaSimple($header);
$pdf->Output();
?>