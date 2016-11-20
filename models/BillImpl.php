<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClientImpl
 *
 * @author JuliánAndrés
 */

if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/Bill.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Bill.php');
}

class BillImpl
{	
	public function BillImpl()
	{
		 
	}
    public function getRecaudos(){
        if (isset($_POST['txbFechaInicio'])) {
          
            $sql ="select recaucodig, recaucredi, crediclien, cliennombr, recauvalor, recaufecha, recauobser, recautipo from recaudo, credito, cliente where recaucredi = credicodig and crediclien = cliencodig and recaufecha between to_date('".date('d/m/Y',strtotime($_POST['txbFechaInicio']))."' 00:00:00', 'dd/mm/yyyy hh24:mi:ss') and to_date('".date('d/m/Y',strtotime($_POST['txbFechaFin']))."' 23:59:59', 'dd/mm/yyyy hh24:mi:ss') order by recaufecha desc";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            echo $sql.";";
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo[]=$row;
            }
            return $foo; 
        }
    }   
        public function getAll()
	{
            $sql = "SELECT fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFECGE, fctr.FACTUVALOR, fctr.FACTUVALIV, fctr.FACTUUSUAR 
			FROM factura fctr ORDER BY fctr.FACTUCODIG DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objBill = new Bill();
                $objBill->setCode($row[0]);
                $objBill->setClient($row[1]);
                $objBill->setGenerationDate($row[2]);
                $objBill->setValueSale($row[3]);
                $objBill->setValueIVA($row[4]);                
                $objBill->setUser($row[5]);
                $foo[] = $objBill;
            }
            return $foo;
        }

        
        public function getByCode($idBill)
	{
            $sql = "SELECT fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFECGE, fctr.FACTUVALOR, fctr.FACTUVALIV, fctr.FACTUUSUAR, fctr.FACTUFORPA 
			FROM factura fctr WHERE fctr.FACTUCODIG = ".$idBill;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objBill = new Bill();
                $objBill->setCode($row[0]);
                $objBill->setClient($row[1]);
                $objBill->setGenerationDate($row[2]);
                $objBill->setValueSale($row[3]);
                $objBill->setValueIVA($row[4]);                
                $objBill->setUser($row[5]);
                $objBill->setPayment($row[6]);
                $foo[] = $objBill;
            }
            return $foo;
        }

        
        public function getAllLimit()
	{
            $sql = "SELECT fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFECGE, fctr.FACTUVALOR, fctr.FACTUVALIV, fctr.FACTUUSUAR 
			FROM factura fctr WHERE ROWNUM <= 7 ORDER BY fctr.FACTUCODIG DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objBill = new Bill();
                $objBill->setCode($row[0]);
                $objBill->setClient($row[1]);
                $objBill->setGenerationDate($row[2]);
                $objBill->setValueSale($row[3]);
                $objBill->setValueIVA($row[4]);                
                $objBill->setUser($row[5]);
                $foo[] = $objBill;
            }
            return $foo;
        }

        
        public function getValueBill(Bill $objBill) {
            $sql = "SELECT fctr.FACTUVALOR FROM factura fctr WHERE fctr.FACTUCODIG  = ".$objBill->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getSequence() {
            $sql = "select SEQ_REMISION.nextval from dual";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getId($objBill) {
            //$sql = "SELECT fctr.FACTUCODIG FROM factura fctr WHERE fctr.FACTUCLIEN = ".$objBill->getClient()." AND fctr.FACTUFECGE = '".$objBill->getGenerationDate()."'";
            $sql = "SELECT fctr.FACTUCODIG 
			FROM factura fctr 
			WHERE fctr.FACTUCLIEN = ".$objBill->getClient()." 
			AND fctr.FACTUFECGE = TO_DATE('".$objBill->getGenerationDate()."', 'dd-MM-yy hh24:mi:ss')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getIdRemision($objBill) {
            $sql = "SELECT rms.REMISCODIG 
			FROM remision rms 
			WHERE rms.REMISCLIEN = ".$objBill->getClient()." 
			AND rms.REMISFECGE = TO_DATE('".$objBill->getGenerationDate()."', 'dd-MM-yy hh24:mi:ss')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getSumPayment($dateA, $dateB, $pym) {
            $sql = "SELECT SUM(fctr.FACTUVALOR) 
			FROM factura fctr 
			WHERE fctr.FACTUFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        

        public function getSumRecaudos($dateA, $dateB, $pym) {
            $sql = "SELECT SUM(RECAUVALOR) 
			FROM recaudo  
			WHERE RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "; 
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getSumPaymentCO($dateA, $dateB, $pym) {
            $sql = "SELECT SUM(REMISVALOR) 
			FROM remision  
			WHERE REMISFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
			AND REMISFORPA = '".$pym."' ";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getSumPaymentCR($dateA, $dateB, $pym) {
            $sql = "SELECT SUM(REMISVALOR) 
			FROM remision  
			WHERE REMISFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
			AND REMISFORPA = '".$pym."' ";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getSumIva($dateA, $dateB, $pym) {
            $sql = "SELECT SUM(fctr.FACTUVALIV) 
			FROM factura fctr 
			WHERE fctr.FACTUFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

		
        public function getSumSaldoCxP($dateA, $dateB) {
            $sql = "SELECT SUM(CUEPAPAGVA) 
			FROM cuentpagpa 
			WHERE CUEPAPAGFG BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

		
        public function getSumRemis($dateA, $dateB, $pym) {
            $sql = "SELECT SUM(remi.REMISVALOR) 
			FROM remision remi 
			WHERE remi.REMISFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }


        public function getSumGastos($dateA, $dateB) {
            $sql = "SELECT SUM(GASTOVALOR) 
			FROM gasto  
			WHERE GASTOFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
		
		
        //method top 
	public function getSumTop($dateA, $dateB) {
            $sql = "SELECT SUM(fctr.FACTUVALOR) 
			FROM factura fctr 
			WHERE fctr.FACTUFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
		

        public function getSumByClient($client, $fi, $ff, $ref) {
           
            
            if(strcmp($ref, "") == 0 && strcmp($client, "") != 0)//solo cliente 
                $sql = "SELECT SUM(fctr.FACTUVALOR) FROM factura fctr WHERE fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND fctr.FACTUCLIEN = ".$client;
            else if(strcmp($ref, "") != 0 && strcmp($client, "") != 0)//solo cliente y ref 
                $sql = "SELECT SUM(fctr.FACTUVALOR) FROM factura fctr, factudetal dtl WHERE fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND fctr.FACTUCLIEN = ".$client." AND  fctr.FACTUCODIG = dtl.FACDECODIG AND UPPER(dtl.FACDEARTIC) = '".$ref."'";                        
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }        

        
        public function getByReport($fi, $ff, $ref, $art, $client)
	{
            if(strcmp($ref, "") == 0 && strcmp($client, "") == 0 && strcmp($art, "") == 0)//no aplican 
                $sql = "SELECT fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUVALOR FROM factura fctr WHERE  fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ORDER BY fctr.FACTUCODIG";
            else if(strcmp($ref, "") != 0 && strcmp($client, "") != 0 && strcmp($art, "") == 0)//aplican todos menos art
                $sql = "SELECT fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUVALOR FROM factura fctr, factudetal dtl WHERE  fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND fctr.FACTUCLIEN = ".$client." AND fctr.FACTUCODIG = dtl.FACDECODIG AND dtl.FACDEARTIC = UPPER('".$ref."') ORDER BY fctr.FACTUCODIG";        
            else if(strcmp($ref, "") != 0 && strcmp($client, "") == 0 && strcmp($art, "") == 0)//solo ref
                $sql = "SELECT fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUVALOR FROM factura fctr, factudetal dtl WHERE  fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND fctr.FACTUCODIG = dtl.FACDECODIG AND dtl.FACDEARTIC = UPPER('".$ref."')  ORDER BY fctr.FACTUCODIG";                
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($art, "") == 0)//solo cliente
                $sql = "SELECT fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUVALOR FROM factura fctr WHERE  fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND fctr.FACTUCLIEN = '".$client."' ORDER BY fctr.FACTUCODIG";    
            else if(strcmp($ref, "") != 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") == 0 && strcmp($art, "") == 0)//ref y cliente
                $sql = "SELECT fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUVALOR FROM factura fctr, factudetal dtl WHERE  fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND fctr.FACTUCLIEN = ".$client." AND fctr.FACTUCODIG = dtl.FACDECODIG AND dtl.FACDEARTIC = UPPER('".$ref."') ORDER BY fctr.FACTUCODIG";        
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($art, "") != 0)//articulo, cliente
            {
                $sql = "SELECT distinct(invencodig), invennombr, fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUVALOR" 
                        ." FROM factura fctr, factudetal dtl, inventario invtr"
                        ." WHERE " 
                        ." fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                        ." AND fctr.FACTUCODIG = dtl.FACDECODIG"
                        ." AND dtl.FACDEARTIC = invtr.INVENCODIG"
                        ." AND fctr.FACTUCLIEN = ".$client." AND invtr.INVENNOMBR LIKE UPPER('%".$art."%')"
                        ." ORDER BY fctr.FACTUCODIG";
                
                $searchByNameArt = 1;
            }            
            else if(strcmp($ref, "") == 0 && strcmp($client, "") == 0 && strcmp($art, "") != 0)//articulo
            {
                $sql = "SELECT distinct(invencodig), invennombr, fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUVALOR" 
                        ." FROM factura fctr, factudetal dtl, inventario invtr"
                        ." WHERE " 
                        ." fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                        ." AND fctr.FACTUCODIG = dtl.FACDECODIG"
                        ." AND dtl.FACDEARTIC = invtr.INVENCODIG"
                        ." AND invtr.INVENNOMBR LIKE UPPER('%".$art."%')"
                        ." ORDER BY fctr.FACTUCODIG";
                
                $searchByNameArt = 1;
            }
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            
            
            //si es uno es porque necesita hacer una consulta con el nombre de un articulo y esto evita campos perdidos en la consulta
            if($searchByNameArt==1)
            {
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                    $objBill = new Bill();

                    $objBill->setGenerationDate($row[2]);
                    $objBill->setCode($row[3]);
                    $objBill->setClient($row[4]);
                    //$objBill->setPayment($row[5]);
                    $objBill->setValueSale($row[5]);
                    $foo[] = $objBill;
                }                
            }
            else
            {
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                    $objBill = new Bill();

                    $objBill->setGenerationDate($row[0]);
                    $objBill->setCode($row[1]);
                    $objBill->setClient($row[2]);
                    //$objBill->setPayment($row[3]);
                    $objBill->setValueSale($row[3]);
                    $foo[] = $objBill;
                }
            }
            
            return $foo;
        }

        
        public function getCountByReport($fi, $ff, $ref, $art, $client)
	{
            if(strcmp($ref, "") == 0 && strcmp($client, "") == 0 && strcmp($art, "") == 0)//no aplican 
                $sql = "SELECT COUNT(*) FROM factura fctr WHERE  fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ORDER BY fctr.FACTUCODIG";
            else if(strcmp($ref, "") != 0 && strcmp($client, "") != 0 && strcmp($art, "") == 0)//aplican todos
                $sql = "SELECT COUNT(*) FROM factura fctr, factudetal dtl WHERE  fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND fctr.FACTUCLIEN = ".$client." AND fctr.FACTUCODIG = dtl.FACDECODIG AND dtl.FACDEARTIC = UPPER('".$ref."') ORDER BY fctr.FACTUCODIG";        
            else if(strcmp($ref, "") != 0 && strcmp($client, "") == 0 && strcmp($art, "") == 0)//solo ref
                $sql = "SELECT COUNT(*) FROM factura fctr, factudetal dtl WHERE  fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND fctr.FACTUCODIG = dtl.FACDECODIG AND dtl.FACDEARTIC = UPPER('".$ref."')  ORDER BY fctr.FACTUCODIG";    
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($art, "") == 0)//solo cliente
                $sql = "SELECT COUNT(*) FROM factura fctr WHERE  fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND fctr.FACTUCLIEN = '".$client."' ORDER BY fctr.FACTUCODIG";    
            else if(strcmp($ref, "") != 0 && strcmp($client, "") != 0 && strcmp($art, "") == 0)//ref y cliente
                $sql = "SELECT COUNT(*) FROM factura fctr, factudetal dtl WHERE  fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND fctr.FACTUCLIEN = ".$client." AND fctr.FACTUCODIG = dtl.FACDECODIG AND dtl.FACDEARTIC = UPPER('".$ref."') ORDER BY fctr.FACTUCODIG";                   
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($art, "") != 0)//articulo, cliente
                $sql = "SELECT  COUNT(distinct(invencodig))" 
                        ." FROM factura fctr, factudetal dtl, inventario invtr"
                        ." WHERE " 
                        ." fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                        ." AND fctr.FACTUCODIG = dtl.FACDECODIG"
                        ." AND dtl.FACDEARTIC = invtr.INVENCODIG"
                        ." AND fctr.FACTUCLIEN = ".$client." AND invtr.INVENNOMBR LIKE UPPER('%".$art."%')"
                        ." ORDER BY fctr.FACTUCODIG";
            else if(strcmp($ref, "") == 0 && strcmp($client, "") == 0 && strcmp($art, "") != 0)//articulo
                $sql = "SELECT  COUNT(distinct(invencodig))" 
                        ." FROM factura fctr, factudetal dtl, inventario invtr"
                        ." WHERE " 
                        ." fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                        ." AND fctr.FACTUCODIG = dtl.FACDECODIG"
                        ." AND dtl.FACDEARTIC = invtr.INVENCODIG"
                        ." AND invtr.INVENNOMBR LIKE UPPER('%".$art."%')"
                        ." ORDER BY fctr.FACTUCODIG";
                    
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = 0;
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo = $row[0];
            }
            return $foo;
        }

        
        public function insert(Bill $objBill){
            $sql = "INSERT INTO factura (FACTUCODIG, FACTUCLIEN, FACTUFECGE, FACTUVALOR, FACTUVALIV, FACTUUSUAR, FACTUFORPA) 
			VALUES (SEQ_FACTURA.NextVal,".$objBill->getClient().",TO_DATE('".$objBill->getGenerationDate()."', 'yyyy/mm/dd hh24:mi:ss'),".$objBill->getValueSale().",".$objBill->getValueIVA().",".$objBill->getUser().",'".$objBill->getPayment()."')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        

        
        public function insertHowRemision($objBill){
            $sql = "INSERT INTO remision (REMISCODIG, REMISCLIEN, REMISFECGE, REMISVALOR, REMISVALIV, REMISUSUAR) 
			VALUES (SEQ_REMISION.NextVal,".$objBill->getClient().",TO_DATE('".$objBill->getGenerationDate()."', 'yyyy/mm/dd hh24:mi:ss'),".$objBill->getValueSale().",".$objBill->getValueIVA().",".$objBill->getUser().")";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        

        
        public function update($objBill, $id){   
            $sql = "UPDATE factura fctr 
			SET fctr.FACTUCLIEN = ".$objClient->getCode().", fctr.FACTUFECGE = '".$objClient->getGenerationDate()."', fctr.FACTUVALOR = ".$objClient->getValueSale().", fctr.FACTUPRECO = ".$objClient->getValueBuy().", fctr.FACTUFORPA = '".$objClient->getPayment()."', fctr.FACTUUSUAR = ".$objClient->getUser()." WHERE fctr.FACTUCLIEN = ".$id;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }

        
        public function updateTotal(Bill $objBill){   
            $sql = "UPDATE factura fctr 
			SET fctr.FACTUVALOR = ".$objBill->getValueSale().", fctr.FACTUVALIV = ".$objBill->getValueIVA()." 
			WHERE fctr.FACTUCODIG = ".$objBill->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 

        
        public function updateClientPayment($objBill){   
            $sql = "UPDATE factura fctr 
			SET fctr.FACTUCLIEN = ".$objBill->getClient().", fctr.FACTUFORPA = '".$objBill->getPayment()."' 
			WHERE fctr.FACTUCODIG = ".$objBill->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 

        
        public function updateState($objBill){   
            $sql = "UPDATE factura fctr SET fctr.FACTUESTAD = '".$objBill->getState()."' WHERE fctr.FACTUCODIG = ".$objBill->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 

        
        public function updateType($objBill){   
            $sql = "UPDATE factura fctr SET fctr.FACTUTIPO = 'RE' WHERE fctr.FACTUCODIG = ".$objBill->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 

        
        public function delete($objBill){
            $sql = "DELETE FROM factura fctr WHERE fctr.FACTUCODIG = ".$objBill->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }

}