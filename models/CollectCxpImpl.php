<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descxppiption of CollectCxpCxpImpl
 *
 * @author JuliánAndrés
 */


if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/CollectCxp.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/CollectCxp.php');
}


class CollectCxpImpl
{
	
	public function CollectCxpImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT cp.* FROM CUENTPAGPA cp ORDER BY cp.CUEPAPAGCO DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCollectCxp = new CollectCxp();
                $objCollectCxp->setCode($row[0]);
                $objCollectCxp->setCodeCxp($row[1]);                
                $objCollectCxp->setCodeConcept($row[2]);                
                $objCollectCxp->setValue($row[3]);                
                $objCollectCxp->setRegistrationDate($row[4]);                
                $objCollectCxp->setObservation($row[5]);                
                $objCollectCxp->setTypePay($row[6]);
                $objCollectCxp->setUser($row[7]);
                $foo[] = $objCollectCxp;
            }
            return $foo;
        }
        
        public function getByCode($idCollectCxp)
	{
            $sql = "SELECT cxpp.* FROM CUENTPAGPA cxpp WHERE cxpp.CUEPAPAGCO = ".$idCollectCxp;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCollectCxp = new CollectCxp();
                $objCollectCxp->setCode($row[0]);
                $objCollectCxp->setCodeCxp($row[1]);                
                $objCollectCxp->setCodeConcept($row[2]);                
                $objCollectCxp->setValue($row[3]);                
                $objCollectCxp->setRegistrationDate($row[4]);                
                $objCollectCxp->setObservation($row[5]);                 
                $objCollectCxp->setUser($row[6]);  
                $objCollectCxp->setTypePay($row[7]);
                $foo[] = $objCollectCxp;
            }
            return $foo;
        }
        
        public function getCollectCxpByClientA($idc)
	{            
            $sql = "SELECT DISTINCT cxpp.CUEPAPAGCO "
                    . "FROM CUENTPAGPA cxpp, credito cr, cliente clnt WHERE cxpp.CUEPAPAGCP = cr.CREDICODIG and cr.CREDICLIEN = clnt.CLIENCODIG and clnt.CLIENCODIG = ".$idc." "
                    . "ORDER BY cxpp.CUEPAPAGCO DESC";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCollectCxp = new CollectCxp();
                $objCollectCxp->setCode($row[0]);
                $foo[] = $objCollectCxp;
            }
            return $foo;
        }
        public function getCollectCxpByClientB($idcr)
	{            
            $sql = "SELECT cxpp.CUEPAPAGCP "
                    . "FROM CUENTPAGPA cxpp WHERE cxpp.CUEPAPAGCO =  ".$idcr." "
                    . "ORDER BY cxpp.CUEPAPAGCP ASC";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCollectCxp = new CollectCxp();
                $objCollectCxp->setCodeCxp($row[0]);
                $foo[] = $objCollectCxp;
            }
            return $foo;
        }
        public function getCollectCxpByClientC($id)
	{
            $sql = "SELECT SUM(cxpp.CUEPAPAGVA) FROM CUENTPAGPA cxpp WHERE cxpp.CUEPAPAGCO = ".$id;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        public function getCollectCxpByClientD($id)
	{
            $sql = "SELECT cxpp.CUEPAPAGFG, cxpp.CUEPAPAGTI, cxpp.RECAUUSUAR, cxpp.CUEPAPAGUS FROM CUENTPAGPA cxpp WHERE cxpp.CUEPAPAGCO = ".$id." AND ROWNUM < 2";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCollectCxp = new CollectCxp();
                $objCollectCxp->setRegistrationDate($row[0]);
                $objCollectCxp->setTypePay($row[1]);
                $objCollectCxp->setUser($row[2]);
                $objCollectCxp->setObservation($row[3]);
                $foo[] = $objCollectCxp;
            }
            return $foo;
        }        
        
         public function sumValueByCxp($codeCxp) {            
            $sql  = "SELECT SUM(cxpp.CUEPAPAGVA) FROM CUENTPAGPA cxpp WHERE cxpp.CUEPAPAGCP = ".$codeCxp;            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        
        
        public function insert(CollectCxp $objCollectCxp){
            //$sql = "INSERT INTO CUENTPAGPA (CUEPAPAGCO, CUEPAPAGCP, CUEPAPAGCN, CUEPAPAGVA, CUEPAPAGFG, CUEPAPAGUS, RECAUUSUAR, CUEPAPAGTI) VALUES (SEQ_RECAUDO.CURRVAL,".$objCollectCxp->getCodeCxp().",".$objCollectCxp->getCodeConcept().",".$objCollectCxp->getValue().",TO_DATE('".$objCollectCxp->getRegistrationDate()."', 'yyyy/mm/dd hh24:mi:ss'),'".$objCollectCxp->getObservation()."',".$objCollectCxp->getUser().",'".$objCollectCxp->getTypePay()."')";                                                
            $sql = "INSERT INTO CUENTPAGPA (CUEPAPAGCO, CUEPAPAGCP, CUEPAPAGCN, CUEPAPAGVA, CUEPAPAGFG, CUEPAPAGOB, CUEPAPAGTI, CUEPAPAGUS) VALUES (SEQ_CXP_PAGOS.NextVal,".$objCollectCxp->getCodeCxp().",".$objCollectCxp->getCodeConcept().",".$objCollectCxp->getValue().",TO_DATE('".$objCollectCxp->getRegistrationDate()."', 'yyyy/mm/dd hh24:mi:ss'),'".$objCollectCxp->getObservation()."','".$objCollectCxp->getTypePay()."',".$objCollectCxp->getUser().")";                                                
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function update(CollectCxp $objCollectCxp){   
            $sql = "UPDATE CUENTPAGPA cxpp SET cxpp.CUEPAPAGVA = ".$objCollectCxp->getValue().", cxpp.CUEPAPAGUS = '".$objCollectCxp->getObservation()."', CUEPAPAGTI = '".$objCollectCxp->getTypePay()."' WHERE cxpp.CUEPAPAGCO = ".$objCollectCxp->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }
//        
//        public function updateState(CollectCxp $objCollectCxp){   
//            $sql = "UPDATE CUENTPAGPA cxpp SET cxpp.CREDIESTAD = '".$objCollectCxp->getState()."' WHERE cxpp.CREDIFACTU = ".$objCollectCxp->getCodeBill();
//            $conex = Conexion::getInstancia();
//            $stid = oci_parse($conex, $sql);
//            oci_execute($stid);            
//        } 
//        
//        
//        public function updateValue(CollectCxp $objCollectCxp){   
//            $sql = "UPDATE CUENTPAGPA cxpp SET cxpp.CREDIVALOR = '".$objCollectCxp->getValue()."' WHERE cxpp.CREDIFACTU = ".$objCollectCxp->getCodeBill();
//            $conex = Conexion::getInstancia();
//            $stid = oci_parse($conex, $sql);
//            oci_execute($stid);            
//        } 
                
        public function delete($objCollectCxp){
            $sql = "DELETE FROM CUENTPAGPA cxpp WHERE cxpp.CUEPAPAGCO = ".$objCollectCxp->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function getCount() {
            $sql = "SELECT  COUNT(*) FROM CUENTPAGPA";
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
            $sql = "SELECT cxpp.CUEPAPAGVA FROM CUENTPAGPA cxpp WHERE cxpp.CUEPAPAGCO = ".$code;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function sumValueByBiil($codeCxp) {            
            $sql  = "SELECT SUM(cxpp.CUEPAPAGVA) FROM CUENTPAGPA cxpp WHERE cxpp.CUEPAPAGCP = ".$codeCxp;            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function sumValueByRemision($codeCxp) {            
            $sql  = "SELECT SUM(cxpp.CUEPAPAGVA) FROM CUENTPAGPA cxpp WHERE cxpp.CUEPAPAGCP = ".$codeCxp;            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        
        public function getCountConceptFromCollectCxp(CollectCxp $objCollectCxp) {
            $sql = "SELECT COUNT(*) FROM CUENTPAGPA cxpp WHERE cxpp.CUEPAPAGCN = ".$objCollectCxp->getCodeConcept();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getCountCollectCxpBetweenDate($dateA, $dateB, $client, $credit, $bill)
	{
            if(strcmp($client, "") != 0 && strcmp($credit, "") == 0 && strcmp($bill, "") == 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM CUENTPAGPA cxpp, credito cr "
                . "WHERE cxpp.CUEPAPAGCP = cr.CREDICODIG AND cr.CREDICLIEN = ".$client." AND cxpp.CUEPAPAGFG BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            }
            else if(strcmp($client, "") == 0 && strcmp($credit, "") != 0 && strcmp($bill, "") == 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM CUENTPAGPA cxpp "
                . "WHERE cxpp.CUEPAPAGCP = ".$credit." AND cxpp.CUEPAPAGFG BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            }
            else if(strcmp($client, "") == 0 && strcmp($credit, "") == 0 && strcmp($bill, "") != 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM CUENTPAGPA cxpp, credito cr "
                . "WHERE cxpp.CUEPAPAGCP = cr.CREDICODIG AND cr.CREDIFACTU = ".$bill." AND cxpp.CUEPAPAGFG BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
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
        
        public function getCollectCxpBetweenDate($dateA, $dateB, $client, $credit, $bill)
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
                $sql = "SELECT * FROM CUENTPAGPA cxpp, credito cr "
                . "WHERE cxpp.CUEPAPAGCP = cr.CREDICODIG 
				AND cr.CREDICLIEN = ".$client." 
				AND cxpp.CUEPAPAGFG BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				ORDER BY cxpp.CUEPAPAGFG";
                
                $conex = Conexion::getInstancia();
                $stid = oci_parse($conex, $sql);
                oci_execute($stid);
                
                               
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                    $objCollectCxp = new CollectCxp();
                    $objCollectCxp->setCode($row[0]);
                    $objCollectCxp->setCodeCxp($row[1]);
                    $objCollectCxp->setRegistrationDate($row[4]);
                    $objCollectCxp->setValue($row[3]);
                    $foo[] = $objCollectCxp;
                }
                
            }
            else if(strcmp($client, "") == 0 && strcmp($credit, "") != 0 && strcmp($bill, "") == 0 ) 
            {
                $sql = "SELECT * FROM CUENTPAGPA cxpp "
                . "WHERE cxpp.CUEPAPAGCP = ".$credit." AND cxpp.CUEPAPAGFG BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ORDER BY cxpp.CUEPAPAGFG";
                
                $conex = Conexion::getInstancia();
                $stid = oci_parse($conex, $sql);
                oci_execute($stid);
                
                               
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                    $objCollectCxp = new CollectCxp();
                    $objCollectCxp->setCode($row[0]);
                    $objCollectCxp->setCodeCxp($row[1]);
                    $objCollectCxp->setRegistrationDate($row[4]);
                    $objCollectCxp->setValue($row[3]);
                    $foo[] = $objCollectCxp;
                }
            }
            else if(strcmp($client, "") == 0 && strcmp($credit, "") == 0 && strcmp($bill, "") != 0 ) 
            {
                $sql = "SELECT * FROM CUENTPAGPA cxpp, credito cr "
                . "WHERE cxpp.CUEPAPAGCP = cr.CREDICODIG AND cr.CREDIFACTU = ".$bill." AND cxpp.CUEPAPAGFG BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ORDER BY cxpp.CUEPAPAGFG";
                
                
                $conex = Conexion::getInstancia();
                $stid = oci_parse($conex, $sql);
                oci_execute($stid);
                
                               
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                    $objCollectCxp = new CollectCxp();
                    $objCollectCxp->setCode($row[0]);
                    $objCollectCxp->setCodeCxp($row[1]);
                    $objCollectCxp->setRegistrationDate($row[4]);
                    $objCollectCxp->setValue($row[3]);
                    $foo[] = $objCollectCxp;
                }
            }               
            
            
            return $foo;
        }

        public function getPagosAnterioresFecha($dateA, $credit)
	{            
            $sql = "SELECT SUM(cxpp.CUEPAPAGVA) FROM CUENTPAGPA cxpp "
            . "WHERE cxpp.CUEPAPAGCP = ".$credit." AND cxpp.CUEPAPAGFG <= '".$dateA."'";

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