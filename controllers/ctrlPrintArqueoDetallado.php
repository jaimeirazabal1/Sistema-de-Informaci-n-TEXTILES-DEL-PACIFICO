<?php
ob_start();
require ('../templates/fpdf17/fpdf.php');
require '../models/BillImpl.php'; 
require '../models/DetailImpl.php';
require '../models/StockImpl.php';
class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
class PDF extends PDF_MC_Table {
   
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
        $this->Cell(0, 0, 'Calle 20 No. 1 - 25', 0, 0, 'R');
        // Salto de línea
        $this->Ln(6);
        $this->Cell(110);
        $this->SetFont('Times', '', 10);
        $this->Cell(0, 0, 'Santiago de Cali - Valle del Cauca', 0, 0, 'R');

        $this->Cell(0, 10, 'Tel: XXX XX XX', 0, 0, 'R');
        $this->Ln(15);
        $this->SetFont('Times', 'B', 12);

        $this->SetFont('Times', '', 9);
        $this->Cell(110, 6, 'Arqueo Caja entre Rango de Fechas: ', 0, 0, 'L');
        //$this->Cell(110);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, 'ARQUEO DE CAJA DETALLADO', 1, 0, 'C');

        $this->SetFont('Times', '', 9);
        $this->Ln();

        $this->Cell(0, 6, utf8_decode('Desde: '.$_POST['txbFechaInicio'].'    Hasta: '.$_POST['txbFechaFin']), 0, 0, 'L');
        $this->Cell(0, 6, utf8_decode('Fecha de Generación: '.date("Y/m/d H:i:s")), 0, 0, 'R');
        $this->Ln();
        $this->Cell(110, 6, '', 0, 0, 'L');                        
     
        $this->Ln(10);
    }

//    Pie de página
    function Footer() {
//        //Posición: a 1,5 cm del final
//        $this->SetY(-15);
//        //Arial italic 8
//        $this->SetFont('Arial', 'I', 8);
//        //Número de página
        $this->Cell(0, 10, 'Pag ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    //Tabla simple
    function TablaSimple($header) {        
        $objBillImpl = new BillImpl();
        $objStockImpl = new StockImpl();
                
        $sumTotalRecaudos = $objBillImpl->getSumRecaudos($_POST['txbFechaInicio'], $_POST['txbFechaFin'], 'CO');
        $sumTotalContado = $objBillImpl->getSumPaymentCO($_POST['txbFechaInicio'], $_POST['txbFechaFin'], 'CO');
        $sumTotalCredito = $objBillImpl->getSumPaymentCR($_POST['txbFechaInicio'], $_POST['txbFechaFin'], 'CR');
        $sumSaldoCxP = $objBillImpl->getSumSaldoCxP($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
		$sumTotalGastos = $objBillImpl->getSumGastos($_POST['txbFechaInicio'], $_POST['txbFechaFin']);

        $sumTotalIngresos = $sumTotalRecaudos + $sumTotalContado;
        $sumTotalEgresos = $sumSaldoCxP + $sumTotalGastos;

        $sumSaldos = $sumTotalIngresos - $sumTotalEgresos;
        $sumTotalInventario = $objStockImpl->getSumStock($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
        //Cabecera
        $this->SetFont('Times', 'B', 10);
        $this->SetTextColor(48,131,155);

        foreach ($header as $col)
        {
            $this->Cell(93, 7, $col, 1, 0, 'C');
        }
        $this->Ln();
        $this->SetFont('Times', '', 10);
        $this->SetTextColor(102,102,102);

        $objBillImpl = new BillImpl();
        
        $this->Cell(93, 5, 'Recaudos', 1);
        $this->Cell(93, 5, number_format($sumTotalRecaudos,0), 1, 0, 'R');
        $this->Cell(93, 5, '', 1);
        $this->Ln();
        $recaudos=$objBillImpl->getRecaudos();
        $this->Ln();
        if (count($recaudos)) {
            $this->SetTextColor(48,131,155);
            $this->MultiCell(30, 5, utf8_decode('CÓDIGO DE RECAUDO'), 1,'C');
            $this->SetXY(40,$this->getY()-10);
            $this->MultiCell(30, 5, utf8_decode('CÓDIGO DE CRÉDITO'), 1,'C');
            $this->SetXY(70,$this->getY()-10);
            $this->MultiCell(40, 5, utf8_decode('IDENTIFICACIÓN DEL CLIENTE'), 1,'C');
            $this->SetXY(110,$this->getY()-10);
            $this->MultiCell(40, 5, 'NOMBRE DEL CLIENTE', 1,'C');
            $this->SetXY(150,$this->getY()-10);
            $this->MultiCell(30, 5, 'VALOR RECAUDO', 1,'C');
            $this->SetXY(180,$this->getY()-10);
            $this->MultiCell(30, 5, 'FECHA RECAUDO', 1,'C');
            $this->SetXY(210,$this->getY()-10);        
            $this->MultiCell(59, 10, utf8_decode('OBSERVACIÓN'), 1,'C');
            $this->SetXY(269,$this->getY()-10);
            $this->MultiCell(20, 5, 'TIPO RECAUDO', 1,'C');
            

            $this->SetTextColor(102,102,102);
            $this->SetWidths(array(30,30,40,40,30,30,59,20));
            srand(microtime()*1000000);
            for($i=0;$i<count($recaudos);$i++)
                $this->Row(array(utf8_decode($recaudos[$i]['RECAUCODIG']),
                                utf8_decode($recaudos[$i]['RECAUCREDI']),
                                utf8_decode($recaudos[$i]['CREDICLIEN']),
                                utf8_decode($recaudos[$i]['CLIENNOMBR']),
                                utf8_decode($recaudos[$i]['RECAUVALOR']),
                                utf8_decode($recaudos[$i]['RECAUFECHA']),
                                isset($recaudos[$i]['RECAUOBSER']) ? utf8_decode($recaudos[$i]['RECAUOBSER']) : '',
                                isset($recaudos[$i]['RECAUTIPO']) ? utf8_decode($recaudos[$i]['RECAUTIPO']) : ''
                                )
                            );

            
            
            $this->Ln();
        }


        $this->Cell(93, 5, 'Ventas Contado', 1);
        $this->Cell(93, 5, number_format($sumTotalContado,0), 1, 0, 'R');
        $this->Cell(93, 5, '', 1);
        $this->Ln();
        $ventas=$objBillImpl->ventasContado();
        if (count($ventas)) {
            $this->Ln();
            $this->SetTextColor(48,131,155);
            $this->MultiCell(30, 5, utf8_decode('CÓDIGO DE REMISIÓN'), 1,'C');
            $this->SetXY(40,$this->getY()-10);
            $this->MultiCell(50, 5, utf8_decode('IDENTIFICACIÓN DEL CLIENTE'), 1,'C');
            $this->SetXY(90,$this->getY()-10);
            $this->MultiCell(40, 5, utf8_decode('NOMBRE DEL CLIENTE'), 1,'C');
            $this->SetXY(130,$this->getY()-10);
            $this->MultiCell(40, 10, utf8_decode('FECHA DE REMISIÓN'), 1,'C');
            $this->SetXY(170,$this->getY()-10);
            $this->MultiCell(30, 5, utf8_decode('VALOR DE REMISIÓN'), 1,'C');
            $this->SetXY(200,$this->getY()-10);
            $this->MultiCell(89, 10, utf8_decode('OBSERVACIÓN'), 1,'C');
            $this->SetTextColor(102,102,102);
            $this->SetWidths(array(30,50,40,40,30,89));
            srand(microtime()*1000000);
            for($i=0;$i<count($ventas);$i++)
                $this->Row(array(utf8_decode($ventas[$i]['REMISCODIG']),
                                utf8_decode($ventas[$i]['REMISCLIEN']),
                                utf8_decode($ventas[$i]['CLIENNOMBR']),
                                utf8_decode($ventas[$i]['REMISFECGE']),
                                utf8_decode($ventas[$i]['REMISVALOR']),
                                utf8_decode(isset($ventas[$i]['REMISOBSER']) ? $ventas[$i]['REMISOBSER'] : '')
                                )
                            );
            $this->Ln();
            $this->Ln();
            $this->Ln();
        }
        $this->Cell(93, 5, utf8_decode('Comprobantes Egreso'), 1);
        $this->Cell(93, 5, '', 1);
        $this->Cell(93, 5, number_format($sumSaldoCxP,0), 1, 0, 'R');        
        $this->Ln();
        $egresos=$objBillImpl->comprobantesDeEgreso();
        if (count($egresos)) {
            $this->Ln();
            $this->SetTextColor(48,131,155);
            $this->MultiCell(30, 5, utf8_decode('CÓDIGO PAGO'), 1,'C');
            $this->SetXY(40,$this->getY()-10);
            $this->MultiCell(50, 5, utf8_decode('CÓDIGO CUENTA POR PAGAR'), 1,'C');
            $this->SetXY(90,$this->getY()-10);
            $this->MultiCell(40, 5, utf8_decode('VALOR PAGO'), 1,'C');
            $this->SetXY(130,$this->getY()-10);
            $this->MultiCell(40, 10, utf8_decode('FECHA DE GENERACIÓN'), 1,'C');
            $this->SetXY(170,$this->getY()-10);
            $this->MultiCell(89, 5, utf8_decode('OBSERVACIÓN'), 1,'C');
            $this->SetXY(200,$this->getY()-10);
            $this->MultiCell(30, 10, utf8_decode('TIPO DE PAGO'), 1,'C');
            $this->SetTextColor(102,102,102);
            $this->SetWidths(array(30,50,40,40,89,30));
            srand(microtime()*1000000);
            for($i=0;$i<count($egresos);$i++)
                $this->Row(array(utf8_decode($egresos[$i]['CUEPAPAGCO']),
                                utf8_decode($egresos[$i]['CUEPAPAGCP']),
                                utf8_decode($egresos[$i]['CUEPAPAGVA']),
                                utf8_decode($egresos[$i]['CUEPAPAGFG']),
                                utf8_decode($egresos[$i]['CUEPAPAGOB']),
                                utf8_decode($egresos[$i]['CUEPAPAGTI'])
                                )
                            );
            $this->Ln();
            $this->Ln();
            $this->Ln();
        }       
        $this->Ln();
        $this->Cell(93, 5, utf8_decode('Gastos'), 1);
        $this->Cell(93, 5, '', 1);
        $this->Cell(93, 5, number_format($sumTotalGastos,0), 1, 0, 'R');        
        $this->Ln();
        $gastos=$objBillImpl->gastos();
        if (count($gastos)) {
            $this->Ln();
            $this->SetTextColor(48,131,155);
            $this->MultiCell(30, 10, utf8_decode('CÓDIGO RECIBO'), 1,'C');
            $this->SetXY(40,$this->getY()-10);
            $this->MultiCell(32, 10, utf8_decode('CÓDIGO CLIENTE'), 1,'C');
            $this->SetXY(72,$this->getY()-10);
            $this->MultiCell(35, 10, utf8_decode('NOMBRE CLIENTE'), 1,'C');
            $this->SetXY(107,$this->getY()-10);
            $this->MultiCell(43, 10, utf8_decode('CÓDIGO DEL CONCEPTO'), 1,'C');
            $this->SetXY(150,$this->getY()-10);
            $this->MultiCell(45, 10, utf8_decode('NOMBRE DEL CONCEPTO'), 1,'C');
            $this->SetXY(195,$this->getY()-10);
            $this->MultiCell(58, 10, utf8_decode('FECHA GENERACIÓN DEL GASTO'), 1,'C');
            $this->SetXY(253,$this->getY()-10);
            $this->MultiCell(36, 10, utf8_decode('VALOR DEL GASTO'), 1,'C');
            $this->SetTextColor(102,102,102);
            $this->SetWidths(array(30,32,35,43,45,58,36));
            srand(microtime()*1000000);
            for($i=0;$i<count($gastos);$i++)
                $this->Row(array(utf8_decode($gastos[$i]['GASTORECIB']),
                                utf8_decode($gastos[$i]['GASTOCLIEN']),
                                utf8_decode($gastos[$i]['CLIENNOMBR']),
                                utf8_decode($gastos[$i]['GASTOCONCE']),
                                utf8_decode($gastos[$i]['CONCENOMBR']),
                                utf8_decode($gastos[$i]['GASTOFECHA']),
                                utf8_decode($gastos[$i]['GASTOVALOR'])
                                )
                            );
            $this->Ln();
            $this->Ln();
            $this->Ln();
        }              
        $this->Cell(93, 5, 'Subtotales', 1);
        $this->Cell(93, 5, number_format($sumTotalIngresos,0), 1, 0, 'R');        
        $this->Cell(93, 5, number_format($sumTotalEgresos,0), 1, 0, 'R');        
        $this->Ln(13);
        
        $this->Cell(110, 5, '', 0, 0, 'R');        
        $this->SetFont('Times', 'B', 12);
        $this->SetTextColor(48,131,155);
        $this->Cell(0, 5, 'Saldos: '.number_format($sumSaldos,0), 1, 0, 'C'); 
        if (!isset($sumTotalIva)) {
            $sumTotalIva = 0;
        }
        if (!isset($sumTotalRemis)) {
            $sumTotalRemis = 0;
        }    
       
    }
    
    function BarDiagram($w, $h, $data, $format, $color=null, $maxVal=0, $nbDiv=4)
    {
        $this->SetFont('Courier', '', 10);
        $this->SetLegends($data, $format);

        $XPage = $this->GetX();
        $YPage = $this->GetY();
        $margin = 2;
        $YDiag = $YPage + $margin;
        $hDiag = floor($h - $margin * 2);
        $XDiag = $XPage + $margin * 2 + $this->wLegend;
        $lDiag = floor($w - $margin * 3 - $this->wLegend);
        if($color == null)
            $color=array(177, 204, 218);
        if ($maxVal == 0) {
            $maxVal = max($data);
        }
        $valIndRepere = ceil($maxVal / $nbDiv);
        $maxVal = $valIndRepere * $nbDiv;
        $lRepere = floor($lDiag / $nbDiv);
        $lDiag = $lRepere * $nbDiv;
        $unit = $lDiag / $maxVal;
        $hBar = floor($hDiag / ($this->NbVal + 1));
        $hDiag = $hBar * ($this->NbVal + 1);
        $eBaton = floor($hBar * 80 / 100);

        $this->SetLineWidth(0.2);
        $this->Rect($XDiag, $YDiag, $lDiag, $hDiag);

        $this->SetFont('Courier', '', 10);
        $this->SetFillColor(177, 204, 218);
        $i=0;
        foreach($data as $val) {
            //Bar
            $xval = $XDiag;
            $lval = (int)($val * $unit);
            $yval = $YDiag + ($i + 1) * $hBar - $eBaton / 2;
            $hval = $eBaton;
            $this->Rect($xval, $yval, $lval, $hval, 'DF');
            //Legend
            $this->SetXY(0, $yval);
            $this->Cell($xval - $margin, $hval, $this->legends[$i], 0, 0, 'R');
            $i++;
        }

        //Scales
        for ($i = 0; $i <= $nbDiv; $i++) {
            $xpos = $XDiag + $lRepere * $i;
            $this->Line($xpos, $YDiag, $xpos, $YDiag + $hDiag);
            $val = $i * $valIndRepere;
            $xpos = $XDiag + $lRepere * $i - $this->GetStringWidth($val) / 2;
            $ypos = $YDiag + $hDiag - $margin;
            $this->Text($xpos, $ypos, $val);
        }
    }
    
    function SetLegends($data, $format)
    {
        $this->legends=array();
        $this->wLegend=0;
        $this->sum=array_sum($data);
        $this->NbVal=count($data);
        foreach($data as $l=>$val)
        {
            $p=sprintf('%.2f', $val/$this->sum*100).'%';
            $legend=str_replace(array('%l', '%v', '%p'), array($l, number_format($val), $p), $format);
            $this->legends[]=$legend;
            $this->wLegend=max($this->GetStringWidth($legend), $this->wLegend);
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


$pdf = new PDF('L');
//Títulos de las columnas
$header = array('Detalle', 'Ingresos', 'Egresos');
$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(53);
//$pdf->AddPage();
$pdf->TablaSimple($header);
//Segunda página
//$pdf->AddPage();
//$pdf->SetY(65);
//$pdf->TablaColores($header);



$pdf->Output();
?>