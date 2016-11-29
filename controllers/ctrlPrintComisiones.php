<?php
ob_start();
require ('../templates/fpdf17/fpdf.php');
require '../models/DetailImpl.php';
require '../models/ClientImpl.php';
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
        $this->Cell(0, 0, 'Calle 20 No. 1 - 25', 0, 0, 'C');
        // Salto de línea
        $this->Ln(6);
        $this->Cell(110);
        $this->SetFont('Times', '', 10);
        $this->Cell(0, 0, 'Santiago de Cali - Valle del Cauca', 0, 1, 'C');
        $this->Cell(110);
        $this->Cell(0, 10, 'Tel: XXX XX XX', 0, 0, 'C');
        $this->Ln(15);
        $this->SetFont('Times', 'B', 12);

        $this->Cell(110);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, 'COMISIONES VENDEDORES', 1, 1, 'C');

        $this->SetFont('Times', '', 9);
        $this->Ln();
         require_once("../models/ClientImpl.php"); 
         $client = new ClientImpl();  
         $data = $client->movimiento_cartera_por_cliente();
        // $saldo=0;
        // $debito=0;
        // $credito=0;
        // foreach ($data as $key => $value) {
        //      if (isset($value['DEBITO'])){
        //         $saldo += $value['DEBITO'];  
        //         $debito += $value['DEBITO'];  
        //      }else{ 
        //          $saldo -= $value['CREDITO'];  
        //          $credito += $value['CREDITO']; 
        //      }
        // }
        $this->SetY(36);
        $this->Cell(110, 6, utf8_decode('Desde: '.$_POST['txbFechaInicio'].'    Hasta: '.$_POST['txbFechaFin']), 0, 1, 'L');
        
        // $cliente = new ClientImpl();
        // $cliente_ = $cliente->get_cliente_by_id($_POST['codigo_cliente']);
        $this->SetY(31);
        // $this->Cell(0, 6, utf8_decode('CÓDIGO CLIENTE: '.$cliente_[0]['CLIENCODIG']), 0, 1, 'R');
        // $this->Cell(0, 6, utf8_decode('NOMBRE CLIENTE: '.$cliente_[0]['CLIENNOMBR']), 0, 1, 'R');
        // $this->Cell(0, 6, utf8_decode('SALDO INICIAL DE CARTERA DEL CLIENTE: '.number_format($debito-$credito,2)), 0, 0, 'R');

        $this->Ln();
        $this->Cell(110, 6, '', 0, 0, 'L');                        
        $this->Cell(0, 6, utf8_decode('Fecha de Generación: '.date("Y/m/d H:i:s")), 0, 0, 'R'); 
        $this->Ln();
          
        if (isset($_POST['codigo_vendedor'])) {
            $vendedor = $client->get_vendedor_by_id($_POST['codigo_vendedor']); 
            $this->Cell(0, 6, utf8_decode($_POST['codigo_vendedor']." - ".$vendedor[0]['CLIENNOMBR']), 0, 0, 'R');
        }
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
                $this->Cell(92, 7, $col, 0);
            else if($cont == 2)
                $this->Cell(18, 7, $col, 0);
            else if($cont == 3)
                $this->Cell(25, 7, $col, 0, 0, 'C');
            else if($cont == 4)
                $this->Cell(32, 7, $col, 0);
            $cont++;
        }
        $this->Ln();
        $this->Cell(192, 0, '', 1);
        $this->Ln(3);
        $this->SetFont('Times', '', 8);
        $this->SetTextColor(102,102,102);

        
              
        
    }

}   
$pdf = new PDF("L");
//Títulos de las columnas

require_once("../models/ClientImpl.php"); 
$client = new ClientImpl();  
$data = $client->movimiento_cartera_por_cliente();
$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(50);
$pdf->SetTextColor(48,131,155);
$pdf->SetWidths(array(30,30,40,40,30,45,35,28));
$pdf->SetAligns(array('C','C','C','C','C','C','C','C'));
$pdf->SetFont('Times', 'B', 8);
$pdf->Row(array(
    utf8_decode('CÓDIGO VENDEDOR'),
    utf8_decode('NOMBRE VENDEDOR'),
    utf8_decode('FECHA GENERACIÓN DEL CRÉDITO'),
    utf8_decode('FECHA CANCELACIÓN DEL CRÉDITO'),
    utf8_decode('CÓDIGO REMISIÓN'),
    utf8_decode('NOMBRE DEL CLIENTE'),
    utf8_decode('VALOR DEL CRÉDITO'),
    utf8_decode('VALOR COMISIÓN')
));
$saldo = 0;
$debito = 0;
$credito = 0;
$pdf->SetTextColor(102,102,102);
require_once("../models/ClientImpl.php");  
$client = new ClientImpl();
$comisiones = $client->get_comisiones_vendedores();
$credivalor = 0;
$comision = 0;
foreach ($comisiones as $key => $value) {
	$pdf->Row(array(
	    utf8_decode($value["VENDECODIG"]),
	    utf8_decode($value["VENTCNOMBR"]),
	    utf8_decode($value["VENDEFECGE"]),
	    utf8_decode($value["CREDIFECCA"]),
	    utf8_decode($value["VENDEFACTU"]),
	    utf8_decode(isset($value["CLIENNOMBR"]) ? $value["CLIENNOMBR"] : ""),
	    utf8_decode(number_format($value["CREDIVALOR"],2)),
	    utf8_decode(number_format($value["COMISION"],2))
	));
	$credivalor+=$value["CREDIVALOR"];
    $comision+=$value["COMISION"];
}
if (isset($_POST['codigo_vendedor']) and !empty($_POST['codigo_vendedor'])):
	$pdf->Row(array(
	    utf8_decode(''),
	    utf8_decode(''),
	    utf8_decode(''),
	    utf8_decode(''),
	    utf8_decode(''),
	    utf8_decode('TOTAL:'),
	    utf8_decode(number_format($credivalor,2)),
	    utf8_decode(number_format($comision,2))
	));
endif;
/*foreach ($data as $key => $value) {
     if (isset($value['DEBITO'])){


        $saldo += $value['DEBITO'];  
        $debito += $value['DEBITO'];  
        $pdf->Row(array(
            utf8_decode("REM-".$value['REMISCODIG']),
            utf8_decode($value['FECHA']),
            utf8_decode(number_format($value['DEBITO'],2)),
            utf8_decode("0,00" ),
            utf8_decode(number_format($saldo,2))
        ));
     }else{ 
         $saldo -= $value['CREDITO'];  
         $credito += $value['CREDITO']; 
        $pdf->Row(array(
            utf8_decode("RC-".$value['RECAUCODIG']),
            utf8_decode($value['FECHA']),
            utf8_decode("0,00"),
            utf8_decode(number_format($value['CREDITO'],2)),
            utf8_decode(number_format($saldo,2))
        ));
     }
}
$pdf->Row(array(
    '',
    'TOTALES:',
    utf8_decode(number_format($debito,2)),
    utf8_decode(number_format($credito,2)),
    utf8_decode(number_format($debito-$credito,2))
));*/
$pdf->SetFont('Times', '', 8);
//$pdf->TablaSimple($header);
$pdf->Output();
?>