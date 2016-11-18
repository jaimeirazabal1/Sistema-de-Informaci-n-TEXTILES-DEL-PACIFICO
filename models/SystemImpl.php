<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SystemImpl
 *
 * @author JuliánAndrés
 */

if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/System.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/System.php');
}

class SystemImpl
{
	
	public function SystemImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT systm.SISTECODIG, systm.SISTENOMBR, systm.SISTEVALOR, systm.SISTEFECIN, systm.SISTEFECFI 
			FROM sistema systm 
			ORDER BY systm.SISTECODIG ASC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objSystem = new System();
                $objSystem->setCode($row[0]);
                $objSystem->setName($row[1]);                
                $objSystem->setValue($row[2]);        
                $objSystem->setStartDate($row[3]);        
                $objSystem->setFinishDate($row[4]);        
                $foo[] = $objSystem;
            }
            return $foo;
        }
        
        public function getAllOrderByName()
	{
            $sql = "SELECT systm.SISTECODIG, systm.SISTENOMBR, systm.SISTEVALOR, systm.SISTEFECIN, system.SISTEFECFI, systm.SISTEVALOR, 
			systm.SISTEFECIN, system.SISTEFECFI FROM sistema systm ORDER BY systm.SISTENOMBR ASC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objSystem = new System();
                $objSystem->setCode($row[0]);
                $objSystem->setName($row[1]);                
                $objSystem->setValue($row[2]);        
                $objSystem->setStartDate($row[3]);        
                $objSystem->setFinishDate($row[4]);        
                $foo[] = $objSystem;
            }
            return $foo;
        }
        
        public function getNameSystem($idSystem) {
            $sql = "SELECT systm.SISTENOMBR FROM sistema systm WHERE systm.SISTECODIG = ".$idSystem;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getValue($idSystem) {
            $sql = "SELECT systm.SISTEVALOR FROM sistema systm WHERE systm.SISTECODIG = ".$idSystem;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getTop() {
            $sql = 'SELECT msg.MSG_ID FROM SYSTEM.AQ$_SYS$CTRL msg';
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getDateStart($idSystem) {
            $sql = "SELECT systm.SISTEFECIN FROM sistema systm WHERE systm.SISTECODIG = ".$idSystem;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getByCode($idSystem)
	{
            $sql = "SELECT systm.SISTECODIG, systm.SISTENOMBR, systm.SISTEVALOR, systm.SISTEFECIN, systm.SISTEFECFI 
			FROM sistema systm WHERE systm.SISTECODIG = ".$idSystem;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objSystem = new System();
                $objSystem->setCode($row[0]);
                $objSystem->setName($row[1]);                
                $objSystem->setValue($row[2]);        
                $objSystem->setStartDate($row[3]);        
                $objSystem->setFinishDate($row[4]);        
                $foo[] = $objSystem;
            }
            return $foo;
        }
        
        public function insert(System $objSystem){
            $sql = "INSERT INTO sistema (SISTECODIG,SISTENOMBR,SISTEVALOR,SISTEFECIN,SISTEFECFI) 
			VALUES (".$objSystem->getCode().",'".$objSystem->getName()."',".$objSystem->getValue().",'".$objSystem->getStartDate()."','".$objSystem->getFinishDate()."')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);                   
        }        
        
        public function update(System $objSystem, $id){   
            $sql = "UPDATE sistema systm 
			SET systm.SISTECODIG = ".$objSystem->getCode().", systm.SISTENOMBR = '".$objSystem->getName()."', systm.SISTEVALOR = ".$objSystem->getValue().", 
			systm.SISTEFECIN = TO_DATE('".$objSystem->getStartDate()."', 'yyyy/mm/dd'), 
			systm.SISTEFECFI = TO_DATE('".$objSystem->getFinishDate()."', 'yyyy/mm/dd') 
			WHERE systm.SISTECODIG = ".$id;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function delete($objSystem){
            $sql = "DELETE FROM sistema systm WHERE systm.SISTECODIG = ".$objSystem->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function getCount() {
            $sql = "SELECT  COUNT(*) FROM sistema";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function checkCode($code) {            
            $sql  = "SELECT COUNT(*) FROM sistema systm WHERE systm.SISTECODIG = ".$code;            
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