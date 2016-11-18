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
    require_once('../models/Remision.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Remision.php');
}


class RemisionImpl
{	
	public function RemisionImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT rms.REMISCODIG, rms.REMISCLIEN, rms.REMISFECGE, rms.REMISVALOR, rms.REMISVALIV, rms.REMISUSUAR 
			FROM remision rms
			WHERE REMISVALOR > 0
			ORDER BY rms.REMISCODIG DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objRemision = new Remision();
                $objRemision->setCode($row[0]);
                $objRemision->setClient($row[1]);
                $objRemision->setGenerationDate($row[2]);
                $objRemision->setValueSale($row[3]);
                $objRemision->setValueIVA($row[4]);                
                $objRemision->setUser($row[5]);
                $foo[] = $objRemision;
            }
            return $foo;
        }
        
        public function getByCode($idRemision)
	{
            $sql = "SELECT rms.REMISCODIG, rms.REMISCLIEN, rms.REMISFECGE, rms.REMISVALOR, rms.REMISVALIV, rms.REMISUSUAR, REMISFORPA, REMISOBSER 
			FROM remision rms WHERE rms.REMISCODIG = ".$idRemision;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objRemision = new Remision();
                $objRemision->setCode($row[0]);
                $objRemision->setClient($row[1]);
                $objRemision->setGenerationDate($row[2]);
                $objRemision->setValueSale($row[3]);
                $objRemision->setValueIVA($row[4]);                
                $objRemision->setUser($row[5]);
                $objRemision->setPayment($row[6]);                
                $objRemision->setObservation($row[7]);
                $foo[] = $objRemision;
            }
            return $foo;
        }
        
        public function getAllLimit()
	{
            $sql = "SELECT rms.REMISCODIG, rms.REMISCLIEN, rms.REMISFECGE, rms.REMISVALOR, rms.REMISVALIV, rms.REMISUSUAR 
			FROM remision rms WHERE ROWNUM <= 5 ORDER BY rms.REMISCODIG DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objRemision = new Remision();
                $objRemision->setCode($row[0]);
                $objRemision->setClient($row[1]);
                $objRemision->setGenerationDate($row[2]);
                $objRemision->setValueSale($row[3]);
                $objRemision->setValueIVA($row[4]);                
                $objRemision->setUser($row[5]);
                $foo[] = $objRemision;
            }
            return $foo;
        }
        
        public function getValueRemision(Remision $objRemision) {
            $sql = "SELECT rms.REMISVALOR FROM remision rms WHERE rms.REMISCODIG  = ".$objRemision->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getPayRemision($idr) {
            $sql = "SELECT rms.REMISFORPA FROM remision rms WHERE rms.REMISCODIG  = ".$idr;
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
                
        
        public function getId($objRemision) {
            //$sql = "SELECT rms.REMISCODIG FROM remision rms WHERE rms.REMISCLIEN = ".$objRemision->getClient()." AND rms.REMISFECGE = '".$objRemision->getGenerationDate()."'";
            $sql = "SELECT rms.REMISCODIG FROM remision rms WHERE rms.REMISCLIEN = ".$objRemision->getClient()." AND rms.REMISFECGE = TO_DATE('".$objRemision->getGenerationDate()."', 'dd-MM-yy hh24:mi:ss')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getIdRemision($objRemision) {
            $sql = "SELECT rms.REMISCODIG 
			FROM remision rms 
			WHERE rms.REMISCLIEN = ".$objRemision->getClient()." 
			AND rms.REMISFECGE = TO_DATE('".$objRemision->getGenerationDate()."', 'dd-MM-yy hh24:mi:ss')";
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
            $sql = "SELECT SUM(rms.REMISVALOR) 
			FROM remision rms 
			WHERE rms.REMISFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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
        
        public function getSumIva($dateA, $dateB, $pym) {
            $sql = "SELECT SUM(rms.REMISVALIV) 
			FROM remision rms 
			WHERE rms.REMISFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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
            $sql = "SELECT SUM(rms.REMISVALOR) 
			FROM remision rms 
			WHERE rms.REMISFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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
                $sql = "SELECT SUM(rms.REMISVALOR) FROM remision rms WHERE rms.REMISFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND rms.REMISCLIEN = ".$client;
            else if(strcmp($ref, "") != 0 && strcmp($client, "") != 0)//solo cliente y ref 
                $sql = "SELECT SUM(rms.REMISVALOR) FROM remision rms, factudetal dtl WHERE rms.REMISFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND rms.REMISCLIEN = ".$client." AND  rms.REMISCODIG = dtl.FACDECODIG AND UPPER(dtl.FACDEARTIC) = '".$ref."'";                        
            
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
                $sql = "SELECT rms.REMISFECGE, rms.REMISCODIG, rms.REMISCLIEN, rms.REMISVALOR FROM remision rms WHERE  rms.REMISFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ORDER BY rms.REMISCODIG";
            else if(strcmp($ref, "") != 0 && strcmp($client, "") != 0 && strcmp($art, "") == 0)//aplican todos menos art
                $sql = "SELECT rms.REMISFECGE, rms.REMISCODIG, rms.REMISCLIEN, rms.REMISVALOR FROM remision rms, factudetal dtl WHERE  rms.REMISFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND rms.REMISCLIEN = ".$client." AND rms.REMISCODIG = dtl.FACDECODIG AND dtl.FACDEARTIC = UPPER('".$ref."') ORDER BY rms.REMISCODIG";        
            else if(strcmp($ref, "") != 0 && strcmp($client, "") == 0 && strcmp($art, "") == 0)//solo ref
                $sql = "SELECT rms.REMISFECGE, rms.REMISCODIG, rms.REMISCLIEN, rms.REMISVALOR FROM remision rms, factudetal dtl WHERE  rms.REMISFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND rms.REMISCODIG = dtl.FACDECODIG AND dtl.FACDEARTIC = UPPER('".$ref."')  ORDER BY rms.REMISCODIG";                
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($art, "") == 0)//solo cliente
                $sql = "SELECT rms.REMISFECGE, rms.REMISCODIG, rms.REMISCLIEN, rms.REMISVALOR FROM remision rms WHERE  rms.REMISFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND rms.REMISCLIEN = '".$client."' ORDER BY rms.REMISCODIG";    
            else if(strcmp($ref, "") != 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") == 0 && strcmp($art, "") == 0)//ref y cliente
                $sql = "SELECT rms.REMISFECGE, rms.REMISCODIG, rms.REMISCLIEN, rms.REMISVALOR FROM remision rms, factudetal dtl WHERE  rms.REMISFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND rms.REMISCLIEN = ".$client." AND rms.REMISCODIG = dtl.FACDECODIG AND dtl.FACDEARTIC = UPPER('".$ref."') ORDER BY rms.REMISCODIG";        
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($art, "") != 0)//articulo, cliente
            {
                $sql = "SELECT distinct(invencodig), invennombr, rms.REMISFECGE, rms.REMISCODIG, rms.REMISCLIEN, rms.REMISVALOR" 
                        ." FROM remision rms, factudetal dtl, inventario invtr"
                        ." WHERE " 
                        ." rms.REMISFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                        ." AND rms.REMISCODIG = dtl.FACDECODIG"
                        ." AND dtl.FACDEARTIC = invtr.INVENCODIG"
                        ." AND rms.REMISCLIEN = ".$client." AND invtr.INVENNOMBR LIKE UPPER('%".$art."%')"
                        ." ORDER BY rms.REMISCODIG";
                
                $searchByNameArt = 1;
            }            
            else if(strcmp($ref, "") == 0 && strcmp($client, "") == 0 && strcmp($art, "") != 0)//articulo
            {
                $sql = "SELECT distinct(invencodig), invennombr, rms.REMISFECGE, rms.REMISCODIG, rms.REMISCLIEN, rms.REMISVALOR" 
                        ." FROM remision rms, factudetal dtl, inventario invtr"
                        ." WHERE " 
                        ." rms.REMISFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                        ." AND rms.REMISCODIG = dtl.FACDECODIG"
                        ." AND dtl.FACDEARTIC = invtr.INVENCODIG"
                        ." AND invtr.INVENNOMBR LIKE UPPER('%".$art."%')"
                        ." ORDER BY rms.REMISCODIG";
                
                $searchByNameArt = 1;
            }
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            
            
            
            //si es uno es porque necestia hacer una consulta con el nombre de un articulo y esto evita campos perdidos en la consulta
            if($searchByNameArt==1)
            {
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                    $objRemision = new Remision();

                    $objRemision->setGenerationDate($row[2]);
                    $objRemision->setCode($row[3]);
                    $objRemision->setClient($row[4]);
                    //$objRemision->setPayment($row[5]);
                    $objRemision->setValueSale($row[5]);
                    $foo[] = $objRemision;
                }                
            }
            else
            {
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                    $objRemision = new Remision();

                    $objRemision->setGenerationDate($row[0]);
                    $objRemision->setCode($row[1]);
                    $objRemision->setClient($row[2]);
                    //$objRemision->setPayment($row[3]);
                    $objRemision->setValueSale($row[3]);
                    $foo[] = $objRemision;
                }
            }
            
            return $foo;
        }
        
        public function getCountByReport($fi, $ff, $ref, $art, $client)
	{
            if(strcmp($ref, "") == 0 && strcmp($client, "") == 0 && strcmp($art, "") == 0)//no aplican 
                $sql = "SELECT COUNT(*) FROM remision rms WHERE  rms.REMISFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ORDER BY rms.REMISCODIG";
            else if(strcmp($ref, "") != 0 && strcmp($client, "") != 0 && strcmp($art, "") == 0)//aplican todos
                $sql = "SELECT COUNT(*) FROM remision rms, factudetal dtl WHERE  rms.REMISFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND rms.REMISCLIEN = ".$client." AND rms.REMISCODIG = dtl.FACDECODIG AND dtl.FACDEARTIC = UPPER('".$ref."') ORDER BY rms.REMISCODIG";        
            else if(strcmp($ref, "") != 0 && strcmp($client, "") == 0 && strcmp($art, "") == 0)//solo ref
                $sql = "SELECT COUNT(*) FROM remision rms, factudetal dtl WHERE  rms.REMISFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND rms.REMISCODIG = dtl.FACDECODIG AND dtl.FACDEARTIC = UPPER('".$ref."')  ORDER BY rms.REMISCODIG";    
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($art, "") == 0)//solo cliente
                $sql = "SELECT COUNT(*) FROM remision rms WHERE  rms.REMISFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND rms.REMISCLIEN = '".$client."' ORDER BY rms.REMISCODIG";    
            else if(strcmp($ref, "") != 0 && strcmp($client, "") != 0 && strcmp($art, "") == 0)//ref y cliente
                $sql = "SELECT COUNT(*) FROM remision rms, factudetal dtl WHERE  rms.REMISFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND rms.REMISCLIEN = ".$client." AND rms.REMISCODIG = dtl.FACDECODIG AND dtl.FACDEARTIC = UPPER('".$ref."') ORDER BY rms.REMISCODIG";                   
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($art, "") != 0)//articulo, cliente
                $sql = "SELECT  COUNT(distinct(invencodig))" 
                        ." FROM remision rms, factudetal dtl, inventario invtr"
                        ." WHERE " 
                        ." rms.REMISFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                        ." AND rms.REMISCODIG = dtl.FACDECODIG"
                        ." AND dtl.FACDEARTIC = invtr.INVENCODIG"
                        ." AND rms.REMISCLIEN = ".$client." AND invtr.INVENNOMBR LIKE UPPER('%".$art."%')"
                        ." ORDER BY rms.REMISCODIG";
            else if(strcmp($ref, "") == 0 && strcmp($client, "") == 0 && strcmp($art, "") != 0)//articulo
                $sql = "SELECT  COUNT(distinct(invencodig))" 
                        ." FROM remision rms, factudetal dtl, inventario invtr"
                        ." WHERE " 
                        ." rms.REMISFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                        ." AND rms.REMISCODIG = dtl.FACDECODIG"
                        ." AND dtl.FACDEARTIC = invtr.INVENCODIG"
                        ." AND invtr.INVENNOMBR LIKE UPPER('%".$art."%')"
                        ." ORDER BY rms.REMISCODIG";
                    
                    
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = 0;
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo = $row[0];
            }
            return $foo;
        }
        
        public function insert($objRemision){
            $sql = "INSERT INTO remision (REMISCODIG, REMISCLIEN, REMISFECGE, REMISVALOR, REMISVALIV, REMISUSUAR) 
			VALUES (SEQ_REMISION.NextVal,".$objRemision->getClient().",TO_DATE('".$objRemision->getGenerationDate()."', 'yyyy/mm/dd hh24:mi:ss'),".$objRemision->getValueSale().",".$objRemision->getValueIVA().",".$objRemision->getUser().")";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function insertHowRemision(Remision $objRemision){
            $sql = "INSERT INTO remision (REMISCODIG, REMISCLIEN, REMISFECGE, REMISVALOR, REMISVALIV, REMISUSUAR, REMISFORPA) 
			VALUES (SEQ_REMISION.NextVal,".$objRemision->getClient().",TO_DATE('".$objRemision->getGenerationDate()."', 'yyyy/mm/dd hh24:mi:ss'),".$objRemision->getValueSale().",".$objRemision->getValueIVA().",".$objRemision->getUser().",'".$objRemision->getPayment()."')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function update($objRemision, $id){   
            $sql = "UPDATE remision rms 
			SET rms.REMISCLIEN = ".$objClient->getCode().", rms.REMISFECGE = '".$objClient->getGenerationDate()."', rms.REMISVALOR = ".$objClient->getValueSale().", rms.FACTUPRECO = ".$objClient->getValueBuy().", rms.FACTUFORPA = '".$objClient->getPayment()."', rms.REMISUSUAR = ".$objClient->getUser()." WHERE rms.REMISCLIEN = ".$id;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }
        
        public function updateTotal(Remision $objRemision){   
            $sql = "UPDATE remision rms 
			SET rms.REMISVALOR = ".$objRemision->getValueSale().", rms.REMISVALIV = ".$objRemision->getValueIVA()." WHERE rms.REMISCODIG = ".$objRemision->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function updateClientPayment($objRemision){   
            $sql = "UPDATE remision rms 
			SET rms.REMISCLIEN = ".$objRemision->getClient().", rms.FACTUFORPA = '".$objRemision->getPayment()."' WHERE rms.REMISCODIG = ".$objRemision->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function updateState($objRemision){   
            $sql = "UPDATE remision rms SET rms.FACTUESTAD = '".$objRemision->getState()."' WHERE rms.REMISCODIG = ".$objRemision->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function updateType($objRemision){   
            $sql = "UPDATE remision rms SET rms.FACTUTIPO = 'RE' WHERE rms.REMISCODIG = ".$objRemision->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function delete($objRemision){
            $sql = "DELETE FROM remision rms WHERE rms.REMISCODIG = ".$objRemision->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }
        

}