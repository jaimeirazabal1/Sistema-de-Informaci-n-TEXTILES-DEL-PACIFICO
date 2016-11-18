<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ColorImpl
 *
 * @author JuliánAndrés
 */


if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/Color.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Color.php');
}


class ColorImpl
{
	
	public function ColorImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT clr.COLORCODIG, clr.COLORNOMBR FROM color clr ORDER BY clr.COLORCODIG ASC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objColor = new Color();
                $objColor->setCode($row[0]);
                $objColor->setName($row[1]);                
                $foo[] = $objColor;
            }
            return $foo;
        }
        
        public function getAllOrderName()
	{
            $sql = "SELECT clr.COLORCODIG, clr.COLORNOMBR FROM color clr ORDER BY clr.COLORNOMBR ASC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objColor = new Color();
                $objColor->setCode($row[0]);
                $objColor->setName($row[1]);                
                $foo[] = $objColor;
            }
            return $foo;
        }
        
        public function getNameColor($idColor) {
            $sql = "SELECT clr.COLORNOMBR FROM color clr WHERE clr.COLORCODIG = ".$idColor;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getByCode($idColor)
	{
            $sql = "SELECT clr.COLORCODIG, clr.COLORNOMBR FROM color clr WHERE clr.COLORCODIG = ".$idColor;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objColor = new Color();
                $objColor->setCode($row[0]);
                $objColor->setName($row[1]);
                $foo[] = $objColor;
            }
            return $foo;
        }
        
        public function insert($objColor){
            $sql = "INSERT INTO color (COLORCODIG, COLORNOMBR) VALUES (".$objColor->getCode().",'".$objColor->getName()."')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function update($objColor, $id){   
            $sql = "UPDATE color clr SET clr.COLORCODIG = ".$objColor->getCode().", clr.COLORNOMBR = '".$objColor->getName()."' WHERE clr.COLORCODIG = ".$id;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function delete($objColor){
            $sql = "DELETE FROM color clr WHERE clr.COLORCODIG = ".$objColor->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function getCount() {
            $sql = "SELECT  COUNT(*) FROM color";
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
            $sql  = "SELECT COUNT(*) FROM color clr WHERE clr.COLORCODIG = ".$code;            
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