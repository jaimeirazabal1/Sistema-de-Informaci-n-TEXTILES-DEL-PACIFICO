<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Desnteiption of NoteImpl
 *
 * @author JuliánAndrés
 */

if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/Note.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Note.php');
}

class NoteImpl
{
	
	public function NoteImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT nte.NOTACODIG, nte.NOTAFACTU, nte.NOTAFECGE, nte.NOTATIPNO, nte.NOTAVALOR, 
			nte.NOTAIVA, nte.NOTAOBSER, nte.NOTAUSUAR 
			FROM nota nte 
			WHERE ROWNUM <= 10 
			ORDER BY nte.NOTACODIG DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objNote = new Note();
                $objNote->setCode($row[0]);
                $objNote->setCodeBill($row[1]);                
                $objNote->setRegistrationDate($row[2]);                
                $objNote->setTypeNote($row[3]);                
                $objNote->setValue($row[4]);                
                $objNote->setValueIva($row[5]);                
                $objNote->setObservation($row[6]);                
                $objNote->setUser($row[7]);                
                $foo[] = $objNote;
            }
            return $foo;
        }

        
        public function getId(Note $objNote) {
            $sql = "SELECT nt.NOTACODIG 
			FROM nota nt 
			WHERE nt.NOTAFECGE = TO_DATE('".$objNote->getRegistrationDate()."', 'dd-MM-yy hh24:mi:ss') 
			AND nt.NOTAFACTU = ".$objNote->getCodeBill();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

		
		public function sumNotesByCxp($idcxp) {            
            $sql  = "SELECT SUM(nte.NOTAVALOR) FROM nota nte WHERE nte.NOTAFACTU = '".$idcxp."' AND nte.NOTATIPNO = 'DE'";            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getByCode($idNote)
	{
            $sql = "SELECT nte.NOTACODIG, nte.NOTAFACTU, nte.NOTAFECGE, nte.NOTATIPNO, nte.NOTAVALOR, 
			nte.NOTAIVA, nte.NOTAOBSER, nte.NOTAUSUAR 
			FROM nota nte 
			WHERE nte.NOTACODIG = ".$idNote;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objNote = new Note();
                $objNote->setCode($row[0]);
                $objNote->setCodeBill($row[1]);                
                $objNote->setRegistrationDate($row[2]);                
                $objNote->setTypeNote($row[3]);                
                $objNote->setValue($row[4]);                
                $objNote->setValueIva($row[5]);                
                $objNote->setObservation($row[6]);                
                $objNote->setUser($row[7]);                
                $foo[] = $objNote;
            }
            return $foo;
        }

        
        public function insert(Note $objNote){
            $sql = "INSERT INTO nota (NOTACODIG,NOTAFACTU,NOTAFECGE,NOTATIPNO,NOTAVALOR,NOTAIVA,NOTAOBSER,NOTAUSUAR) 
			VALUES (SEQ_NOTA.NextVal,".$objNote->getCodeBill().",TO_DATE('".$objNote->getRegistrationDate()."', 'yyyy/mm/dd hh24:mi:ss'),'".$objNote->getTypeNote()."',".$objNote->getValue().",".$objNote->getValueIva().",'".$objNote->getObservation()."',".$objNote->getUser().")";                                                
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function update(Note $objNote){   
            $sql = "UPDATE nota nte 
			SET nte.NOTATIPNO = '".$objNote->getTypeNote()."', nte.NOTAVALOR = ".$objNote->getValue().", 
			nte.NOTAIVA = ".$objNote->getValueIva().", nte.NOTAOBSER = '".$objNote->getObservation()."' 
			WHERE nte.NOTACODIG = ".$objNote->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }
        
        public function updateObservations(Note $objNote){   
            $sql = "UPDATE nota nte SET nte.NOTAOBSER = '".$objNote->getObservation()."' WHERE nte.NOTACODIG = ".$objNote->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }
        
        public function updateTotalIva(Note $objNote){   
            $sql = "UPDATE nota nte SET nte.NOTAVALOR = ".$objNote->getValue().", nte.NOTAIVA = ".$objNote->getValueIva()." WHERE nte.NOTACODIG = ".$objNote->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }
//        
//        public function updateState(Note $objNote){   
//            $sql = "UPDATE nota nte SET nte.CREDIESTAD = '".$objNote->getState()."' WHERE nte.CREDIFACTU = ".$objNote->getCodeBill();
//            $conex = Conexion::getInstancia();
//            $stid = oci_parse($conex, $sql);
//            oci_execute($stid);            
//        } 
//        
//        
//        public function updateValue(Note $objNote){   
//            $sql = "UPDATE nota nte SET nte.CREDIVALOR = '".$objNote->getValue()."' WHERE nte.CREDIFACTU = ".$objNote->getCodeBill();
//            $conex = Conexion::getInstancia();
//            $stid = oci_parse($conex, $sql);
//            oci_execute($stid);            
//        } 
                
        public function delete($objNote){
            $sql = "DELETE FROM nota nte WHERE nte.RECAUCODIG = ".$objNote->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function getCount() {
            $sql = "SELECT  COUNT(*) FROM nota";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getValueByCode($code) {
            $sql = "SELECT nte.NOTAVALOR FROM nota nte WHERE nte.NOTACODIG = ".$code;
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
            $sql  = "SELECT SUM(nte.RECAUVALOR) FROM nota nte WHERE nte.RECAUCREDI = ".$codeCredit;            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }


        public function sumNotesByRemision($idRemision) {            
            $sql  = "SELECT SUM(nte.NOTAVALOR) FROM nota nte WHERE nte.NOTAFACTU = '".$idRemision."' AND nte.NOTATIPNO = 'CR'";            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getSumNotesByClient($dateA, $dateB, $client)
	{            
            $sql = "SELECT SUM(nt.NOTAVALOR) 
			FROM nota nt, remision rm "
            . "WHERE nt.NOTAFACTU = rm.REMISCODIG 
			AND rm.REMISCLIEN = '".$client."'  
			AND nt.NOTAFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";

//            $sql = "SELECT SUM(nt.NOTAVALOR) FROM nota nt, remision rm "
//            . "WHERE nt.NOTAFACTU = ".$remis." AND nt.NOTAFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;


            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo = $row[0];
            }     
            
            return $foo;      
        }

        
        public function getCountConceptFromNote(Note $objNote) {
            $sql = "SELECT COUNT(*) FROM nota nte WHERE nte.RECAUCONCE = ".$objNote->getCodeConcept();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getCountNoteBetweenDate($dateA, $dateB, $client, $credit, $bill)
	{
            if(strcmp($client, "") != 0 && strcmp($credit, "") == 0 && strcmp($bill, "") == 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM nota nte, credito cr "
                . "WHERE nte.RECAUCREDI = cr.CREDICODIG 
				AND cr.CREDICLIEN = ".$client." 
				AND nte.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            }
            else if(strcmp($client, "") == 0 && strcmp($credit, "") != 0 && strcmp($bill, "") == 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM nota nte "
                . "WHERE nte.RECAUCREDI = ".$credit." 
				AND nte.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            }
            else if(strcmp($client, "") == 0 && strcmp($credit, "") == 0 && strcmp($bill, "") != 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM nota nte, credito cr "
                . "WHERE nte.RECAUCREDI = cr.CREDICODIG 
				AND cr.CREDIFACTU = ".$bill." 
				AND nte.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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

        
        public function getNoteBetweenDate($dateA, $dateB, $client, $credit, $bill)
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
                $sql = "SELECT * FROM nota nte, credito cr "
                . "WHERE nte.RECAUCREDI = cr.CREDICODIG 
				AND cr.CREDICLIEN = ".$client." 
				AND nte.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				ORDER BY nte.RECAUFECHA";
                
                $conex = Conexion::getInstancia();
                $stid = oci_parse($conex, $sql);
                oci_execute($stid);
                
                               
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                    $objNote = new Note();
                    $objNote->setCode($row[0]);
                    $objNote->setCodeCredit($row[1]);
                    $objNote->setRegistrationDate($row[4]);
                    $objNote->setValue($row[3]);
                    $foo[] = $objNote;
                }
                
            }
            else if(strcmp($client, "") == 0 && strcmp($credit, "") != 0 && strcmp($bill, "") == 0 ) 
            {
                $sql = "SELECT * FROM nota nte "
                . "WHERE nte.RECAUCREDI = ".$credit." 
				AND nte.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				ORDER BY nte.RECAUFECHA";
                
                $conex = Conexion::getInstancia();
                $stid = oci_parse($conex, $sql);
                oci_execute($stid);
                
                               
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                    $objNote = new Note();
                    $objNote->setCode($row[0]);
                    $objNote->setCodeCredit($row[1]);
                    $objNote->setRegistrationDate($row[4]);
                    $objNote->setValue($row[3]);
                    $foo[] = $objNote;
                }
            }
            else if(strcmp($client, "") == 0 && strcmp($credit, "") == 0 && strcmp($bill, "") != 0 ) 
            {
                $sql = "SELECT * FROM nota nte, credito cr "
                . "WHERE nte.RECAUCREDI = cr.CREDICODIG 
				AND cr.CREDIFACTU = ".$bill." 
				AND nte.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				ORDER BY nte.RECAUFECHA";
                
                
                $conex = Conexion::getInstancia();
                $stid = oci_parse($conex, $sql);
                oci_execute($stid);
                
                               
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                    $objNote = new Note();
                    $objNote->setCode($row[0]);
                    $objNote->setCodeCredit($row[1]);
                    $objNote->setRegistrationDate($row[4]);
                    $objNote->setValue($row[3]);
                    $foo[] = $objNote;
                }
            }               
            
            
            return $foo;
        }

		
        public function getPagosAnterioresFecha($dateA, $credit)
	{            
            $sql = "SELECT SUM(nte.RECAUVALOR) FROM nota nte "
            . "WHERE nte.RECAUCREDI = ".$credit." 
			AND nte.RECAUFECHA <= '".$dateA."'";

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