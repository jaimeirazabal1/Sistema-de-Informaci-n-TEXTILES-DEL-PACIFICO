<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TypeConceptosImpl
 *
 * @author JuliánAndrés
 */


if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/TypeConceptos.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/TypeConceptos.php');
}

class TypeConceptosImpl
{
	
	public function TypeConceptosImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT CONCECODIG, CONCENOMBR FROM concepto ORDER BY CONCECODIG ASC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objTypeConceptos = new TypeConceptos();
                $objTypeConceptos->setCode($row[0]);
                $objTypeConceptos->setName($row[1]);                
                $foo[] = $objTypeConceptos;
            }
            return $foo;
        }

        
        public function getNameConcepto($idTypeConceptos) {
            $sql = "SELECT CONCENOMBR FROM concepto WHERE CONCECODIG = ".$idTypeConceptos;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getByCode($idTypeConceptos)
	{
            $sql = "SELECT CONCECODIG, CONCENOMBR FROM concepto WHERE CONCECODIG = ".$idTypeConceptos;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objTypeConceptos = new TypeConceptos();
                $objTypeConceptos->setCode($row[0]);
                $objTypeConceptos->setName($row[1]);
                $foo[] = $objTypeConceptos;
            }
            return $foo;
        }

        
        public function insert($idTypeConceptos){
            $sql = "INSERT INTO concepto (CONCECODIG, CONCENOMBR) VALUES (".$idTypeConceptos->getCode().",'".$idTypeConceptos->getName()."')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        

        
        public function update($objTypeConceptos, $id){   
            $sql = "UPDATE concepto 
			SET CONCECODIG = ".$objTypeConceptos->getCode().", CONCENOMBR = '".$objTypeConceptos->getName()."' 
			WHERE CONCECODIG = ".$id;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 

        
        public function delete($objTypeConceptos){
            $sql = "DELETE FROM concepto WHERE CONCECODIG = ".$objTypeConceptos->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        

        
        public function getCount() {
            $sql = "SELECT COUNT(*) FROM concepto";
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
            $sql  = "SELECT COUNT(*) FROM concepto WHERE CONCECODIG = ".$code;            
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