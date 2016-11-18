<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Desrcdiption of CollectImpl
 *
 * @author JuliánAndrés
 */

if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/Collect.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Collect.php');
}

class CollectImpl
{
	
	public function CollectImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT rcd.RECAUCODIG, rcd.RECAUCREDI, rcd.RECAUCONCE, rcd.RECAUVALOR, rcd.RECAUFECHA, rcd.RECAUOBSER, rcd.RECAUTIPO  
			FROM recaudo rcd 
			ORDER BY rcd.RECAUCODIG DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCollect = new Collect();
                $objCollect->setCode($row[0]);
                $objCollect->setCodeCredit($row[1]);                
                $objCollect->setCodeConcept($row[2]);                
                $objCollect->setValue($row[3]);                
                $objCollect->setRegistrationDate($row[4]);                
                $objCollect->setObservation($row[5]);                
                //$objCollect->setUser($row[6]);                
                $objCollect->setTypePay($row[6]);
                $foo[] = $objCollect;
            }
            return $foo;
        }

        
        public function getByCode($idCollect)
	{
            $sql = "SELECT rcd.RECAUCODIG, rcd.RECAUCREDI, rcd.RECAUCONCE, rcd.RECAUVALOR, rcd.RECAUFECHA, 
			rcd.RECAUOBSER, rcd.RECAUUSUAR, rcd.RECAUTIPO 
			FROM recaudo rcd 
			WHERE rcd.RECAUCODIG = ".$idCollect;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCollect = new Collect();
                $objCollect->setCode($row[0]);
                $objCollect->setCodeCredit($row[1]);                
                $objCollect->setCodeConcept($row[2]);                
                $objCollect->setValue($row[3]);                
                $objCollect->setRegistrationDate($row[4]);                
                $objCollect->setObservation($row[5]);                 
                $objCollect->setUser($row[6]);  
                $objCollect->setTypePay($row[7]);
                $foo[] = $objCollect;
            }
            return $foo;
        }

        
        public function getCollectByClientA($idc)
	{            
            $sql = "SELECT DISTINCT rcd.RECAUCODIG "
                    . "FROM recaudo rcd, credito cr, cliente clnt 
					WHERE rcd.RECAUCREDI = cr.CREDICODIG 
					and cr.CREDICLIEN = clnt.CLIENCODIG 
					and clnt.CLIENCODIG = ".$idc." "
                    . "ORDER BY rcd.RECAUCODIG DESC";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCollect = new Collect();
                $objCollect->setCode($row[0]);
                $foo[] = $objCollect;
            }
            return $foo;
        }


        public function getCollectByClientB($idcr)
	{            
            $sql = "SELECT rcd.RECAUCREDI "
                    . "FROM recaudo rcd 
					WHERE rcd.RECAUCODIG =  ".$idcr." "
                    . "ORDER BY rcd.RECAUCREDI ASC";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCollect = new Collect();
                $objCollect->setCodeCredit($row[0]);
                $foo[] = $objCollect;
            }
            return $foo;
        }


        public function getCollectByClientC($id)
	{
            $sql = "SELECT SUM(rcd.RECAUVALOR) FROM recaudo rcd WHERE rcd.RECAUCODIG = ".$id;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }


        public function getCollectByClientD($id)
	{
            $sql = "SELECT rcd.RECAUFECHA, rcd.RECAUTIPO, rcd.RECAUUSUAR, rcd.RECAUOBSER 
			FROM recaudo rcd 
			WHERE rcd.RECAUCODIG = ".$id." 
			AND ROWNUM < 2";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCollect = new Collect();
                $objCollect->setRegistrationDate($row[0]);
                $objCollect->setTypePay($row[1]);
                $objCollect->setUser($row[2]);
                $objCollect->setObservation($row[3]);
                $foo[] = $objCollect;
            }
            return $foo;
        }        
        
        
        public function insert(Collect $objCollect){
            //$sql = "INSERT INTO recaudo (RECAUCODIG, RECAUCREDI, RECAUCONCE, RECAUVALOR, RECAUFECHA, RECAUOBSER, RECAUUSUAR, RECAUTIPO) VALUES (SEQ_RECAUDO.CURRVAL,".$objCollect->getCodeCredit().",".$objCollect->getCodeConcept().",".$objCollect->getValue().",TO_DATE('".$objCollect->getRegistrationDate()."', 'yyyy/mm/dd hh24:mi:ss'),'".$objCollect->getObservation()."',".$objCollect->getUser().",'".$objCollect->getTypePay()."')";                                                
            $sql = "INSERT INTO recaudo (RECAUCODIG, RECAUCREDI, RECAUCONCE, RECAUVALOR, RECAUFECHA, RECAUOBSER, RECAUUSUAR, RECAUTIPO) 
			VALUES (".$objCollect->getCode().",".$objCollect->getCodeCredit().",".$objCollect->getCodeConcept().",".$objCollect->getValue().",TO_DATE('".$objCollect->getRegistrationDate()."', 'yyyy/mm/dd hh24:mi:ss'),'".$objCollect->getObservation()."',".$objCollect->getUser().",'".$objCollect->getTypePay()."')";                                                
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        

        
        public function update(Collect $objCollect){   
            $sql = "UPDATE recaudo rcd 
			SET rcd.RECAUVALOR = ".$objCollect->getValue().", rcd.RECAUOBSER = '".$objCollect->getObservation()."', RECAUTIPO = '".$objCollect->getTypePay()."' WHERE rcd.RECAUCODIG = ".$objCollect->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }
//        
//        public function updateState(Collect $objCollect){   
//            $sql = "UPDATE recaudo rcd SET rcd.CREDIESTAD = '".$objCollect->getState()."' WHERE rcd.CREDIFACTU = ".$objCollect->getCodeBill();
//            $conex = Conexion::getInstancia();
//            $stid = oci_parse($conex, $sql);
//            oci_execute($stid);            
//        } 
//        
//        
//        public function updateValue(Collect $objCollect){   
//            $sql = "UPDATE recaudo rcd SET rcd.CREDIVALOR = '".$objCollect->getValue()."' WHERE rcd.CREDIFACTU = ".$objCollect->getCodeBill();
//            $conex = Conexion::getInstancia();
//            $stid = oci_parse($conex, $sql);
//            oci_execute($stid);            
//        } 
                
        public function delete($objCollect){
            $sql = "DELETE FROM recaudo rcd WHERE rcd.RECAUCODIG = ".$objCollect->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        

        
        public function getCount() {
            $sql = "SELECT  COUNT(*) FROM recaudo";
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
            $sql = "select LAST_NUMBER from user_sequences where SEQUENCE_NAME = 'SEQ_RECAUDO'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }     

        
        public function nextSequence(){
            $sql = "select SEQ_RECAUDO.nextval from dual";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 

        
        public function getValueByCode($code) {
            $sql = "SELECT rcd.RECAUVALOR FROM recaudo rcd WHERE rcd.RECAUCODIG = ".$code;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function sumValueByBiil($codeCredit) {            
            $sql  = "SELECT SUM(rcd.RECAUVALOR) FROM recaudo rcd WHERE rcd.RECAUCREDI = ".$codeCredit;            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function sumValueByRemision($codeCredit) {            
            $sql  = "SELECT SUM(rcd.RECAUVALOR) FROM recaudo rcd WHERE rcd.RECAUCREDI = ".$codeCredit;            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        
        public function getCountConceptFromCollect(Collect $objCollect) {
            $sql = "SELECT COUNT(*) FROM recaudo rcd WHERE rcd.RECAUCONCE = ".$objCollect->getCodeConcept();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getCountCollectBetweenDate($dateA, $dateB, $client, $credit, $bill)
	{
            if(strcmp($client, "") != 0 && strcmp($credit, "") == 0 && strcmp($bill, "") == 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM recaudo rcd, credito cr "
                . "WHERE rcd.RECAUCREDI = cr.CREDICODIG 
				AND cr.CREDICLIEN = ".$client." 
				AND rcd.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            }
            else if(strcmp($client, "") == 0 && strcmp($credit, "") != 0 && strcmp($bill, "") == 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM recaudo rcd "
                . "WHERE rcd.RECAUCREDI = ".$credit." 
				AND rcd.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            }
            else if(strcmp($client, "") == 0 && strcmp($credit, "") == 0 && strcmp($bill, "") != 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM recaudo rcd, credito cr "
                . "WHERE rcd.RECAUCREDI = cr.CREDICODIG 
				AND cr.CREDIFACTU = ".$bill." 
				AND rcd.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            }            
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = 0;
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo = $row[0];
            }
            return $foo;
        } 

        
        public function getCollectBetweenDate($dateA, $dateB, $client, $credit, $bill)
	{
            $foo = array();
            
            if(strcmp($client, "") == 0 && strcmp($credit, "") == 0 && strcmp($bill, "") == 0 ) 
            {
//                $sql = "SELECT * FROM credito cr "
//                . "WHERE cr.CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
//                . "ORDER BY cr.CREDICODIG";
            }   
            if(strcmp($client, "") != 0 && strcmp($credit, "") == 0 && strcmp($bill, "") == 0 ) 
            {
                $sql = "SELECT * 
				FROM recaudo rcd, credito cr "
                . "WHERE rcd.RECAUCREDI = cr.CREDICODIG 
				AND cr.CREDICLIEN = ".$client." 
				AND rcd.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				ORDER BY rcd.RECAUFECHA";
                
                $conex = Conexion::getInstancia();
                $stid = oci_parse($conex, $sql);
                oci_execute($stid);
                
                               
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                    $objCollect = new Collect();
                    $objCollect->setCode($row[0]);
                    $objCollect->setCodeCredit($row[1]);
                    $objCollect->setRegistrationDate($row[4]);
                    $objCollect->setValue($row[3]);
                    $foo[] = $objCollect;
                }
                
            }
            else if(strcmp($client, "") == 0 && strcmp($credit, "") != 0 && strcmp($bill, "") == 0 ) 
            {
                $sql = "SELECT * FROM recaudo rcd "
                . "WHERE rcd.RECAUCREDI = ".$credit." 
				AND rcd.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				ORDER BY rcd.RECAUFECHA";
                
                $conex = Conexion::getInstancia();
                $stid = oci_parse($conex, $sql);
                oci_execute($stid);
                
                               
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                    $objCollect = new Collect();
                    $objCollect->setCode($row[0]);
                    $objCollect->setCodeCredit($row[1]);
                    $objCollect->setRegistrationDate($row[4]);
                    $objCollect->setValue($row[3]);
                    $foo[] = $objCollect;
                }
            }
            else if(strcmp($client, "") == 0 && strcmp($credit, "") == 0 && strcmp($bill, "") != 0 ) 
            {
                $sql = "SELECT * FROM recaudo rcd, credito cr "
                . "WHERE rcd.RECAUCREDI = cr.CREDICODIG 
				AND cr.CREDIFACTU = ".$bill." 
				AND rcd.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				ORDER BY rcd.RECAUFECHA";
                
                
                $conex = Conexion::getInstancia();
                $stid = oci_parse($conex, $sql);
                oci_execute($stid);
                
                               
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                    $objCollect = new Collect();
                    $objCollect->setCode($row[0]);
                    $objCollect->setCodeCredit($row[1]);
                    $objCollect->setRegistrationDate($row[4]);
                    $objCollect->setValue($row[3]);
                    $foo[] = $objCollect;
                }
            }               
            
            
            return $foo;
        }

		
        public function getPagosAnterioresFecha($dateA, $credit)
	{            
            $sql = "SELECT SUM(rcd.RECAUVALOR) 
			FROM recaudo rcd "
            . "WHERE rcd.RECAUCREDI = ".$credit." 
			AND rcd.RECAUFECHA <= '".$dateA."'";

            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;


            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo = $row[0];
            }     
            
            return $foo;      
        }     
        
}