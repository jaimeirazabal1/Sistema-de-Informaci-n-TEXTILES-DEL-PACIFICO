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
    require_once('../models/DetailRemision.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/DetailRemision.php');
}


class DetailRemisionImpl
{
	
	public function DetailRemisionImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT dtlr.REMDECODIG, dtlr.REMDEARTIC, dtlr.REMDECANTI, dtlr.REMDEVALUN, dtlr.REMDEVALTO, dtlr.REMDEFECGE FROM REMISDETAL dtlr ORDER BY dtlr.REMDECODIG DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetailRemision = new DetailRemision();
                $objDetailRemision->setCodeRemision($row[0]);
                $objDetailRemision->setCodeArticle($row[1]);
                $objDetailRemision->setQuantity($row[2]);
                $objDetailRemision->setValueUnit($row[3]);
                $objDetailRemision->setTotal($row[4]);
                $objDetailRemision->setMoveDate($row[5]);
                $foo[] = $objDetailRemision;
            }
            return $foo;
        }
        
        public function getByCode($idRemision)
	{
            $sql = "SELECT dtlr.REMDECODIG, dtlr.REMDEARTIC, dtlr.REMDEFECGE, dtlr.REMDECANTI, dtlr.REMDEVALUN, dtlr.REMDEVALTO, dtlr.REMDECOLOR, dtlr.REMDEDEVOL  FROM REMISDETAL dtlr WHERE dtlr.REMDECODIG = ".$idRemision;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetailRemision = new DetailRemision();
                $objDetailRemision->setCodeRemision($row[0]);
                $objDetailRemision->setCodeArticle($row[1]);
                $objDetailRemision->setMoveDate($row[2]);
                $objDetailRemision->setQuantity($row[3]);
                $objDetailRemision->setValueUnit($row[4]);
                $objDetailRemision->setTotal($row[5]);
                $objDetailRemision->setColor($row[6]);
                $objDetailRemision->setDevolucion($row[7]);
                
                $foo[] = $objDetailRemision;
            }
            return $foo;
        }
        
        public function getByCodeBetweenDate($dateA, $dateB, $idArticle)
	{
            $sql = "SELECT dtlr.REMDECODIG, dtlr.REMDEARTIC, dtlr.REMDEFECGE, dtlr.REMDECANTI, dtlr.REMDEVALUN, dtlr.REMDEVALTO, dtlr.REMDECOLOR, dtlr.REMDEDEVOL  FROM REMISDETAL dtlr "
                    . " WHERE UPPER(dtlr.REMDEARTIC) = UPPER('".$idArticle."') "
                    . " AND dtlr.REMDEFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') "
                    . " AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetailRemision = new DetailRemision();
                $objDetailRemision->setCodeRemision($row[0]);
                $objDetailRemision->setCodeArticle($row[1]);
                $objDetailRemision->setMoveDate($row[2]);
                $objDetailRemision->setQuantity($row[3]);
                $objDetailRemision->setValueUnit($row[4]);
                $objDetailRemision->setTotal($row[5]);
                $objDetailRemision->setColor($row[6]);
                $objDetailRemision->setDevolucion($row[7]);
                
                $foo[] = $objDetailRemision;
            }
            return $foo;
        }
        
        public function getByCodeNoDevolucion($idRemision)
	{
            $sql = "SELECT dtlr.REMDECODIG, dtlr.REMDEARTIC, dtlr.REMDEFECGE, dtlr.REMDECANTI, dtlr.REMDEVALUN, dtlr.REMDEVALTO, dtlr.REMDECOLOR, dtlr.REMDEDEVOL  FROM REMISDETAL dtlr WHERE dtlr.REMDECODIG = ".$idRemision." AND dtlr.REMDEMOVIM IS NULL";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetailRemision = new DetailRemision();
                $objDetailRemision->setCodeRemision($row[0]);
                $objDetailRemision->setCodeArticle($row[1]);
                $objDetailRemision->setMoveDate($row[2]);
                $objDetailRemision->setQuantity($row[3]);
                $objDetailRemision->setValueUnit($row[4]);
                $objDetailRemision->setTotal($row[5]);
                $objDetailRemision->setColor($row[6]);
                $objDetailRemision->setDevolucion($row[7]);
                
                $foo[] = $objDetailRemision;
            }
            return $foo;
        }
        
        public function getCountMovimientoD(DetailRemision $objDetailRemision) {
            $sql = "select count(*) FROM REMISDETAL WHERE REMDECODIG = ".$objDetailRemision->getCodeRemision()." AND REMDEMOVIM IS NULL";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getByRemisionArticleDate($idRemision, $idArticle, $dateMove)
	{
            $sql = "SELECT dtlr.REMDECODIG, dtlr.REMDEARTIC, dtlr.REMDECANTI, dtlr.REMDEVALUN, dtlr.REMDEVALTO, dtlr.REMDEFECGE, dtlr.REMDECOLOR FROM REMISDETAL dtlr WHERE dtlr.REMDECODIG = ".$idRemision." AND dtlr.REMDEARTIC = '".$idArticle."' AND dtlr.REMDEFECGE = '".$dateMove."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetailRemision = new DetailRemision();
                $objDetailRemision->setCodeRemision($row[0]);
                $objDetailRemision->setCodeArticle($row[1]);
                $objDetailRemision->setQuantity($row[2]);
                $objDetailRemision->setValueUnit($row[3]);
                $objDetailRemision->setTotal($row[4]);
                $objDetailRemision->setMoveDate($row[5]);
                $objDetailRemision->setColor($row[6]);
                $foo[] = $objDetailRemision;
            }
            return $foo;
        }
                
        public function insert(DetailRemision $objDetailRemision){
            $sql = "INSERT INTO REMISDETAL (REMDECODIG, REMDEARTIC, REMDEFECGE, REMDECANTI, REMDEVALUN, REMDEVALTO, REMDECOLOR, REMDEDEVOL) VALUES (".$objDetailRemision->getCodeRemision().",'".$objDetailRemision->getCodeArticle()."', TO_DATE('".$objDetailRemision->getMoveDate()."', 'yyyy/mm/dd hh24:mi:ss'),".$objDetailRemision->getQuantity().",".$objDetailRemision->getValueUnit().",".$objDetailRemision->getTotal().",".$objDetailRemision->getColor().",0)";
            //$sql = "INSERT INTO REMISDETAL (REMDECODIG, REMDEARTIC, REMDECANTI, REMDEVALUN, REMDEVALTO, FACDEMOVIM) VALUES (".$objDetailRemision->getCodeRemision().",'".$objDetailRemision->getCodeArticle()."',".$objDetailRemision->getQuantity().",".$objDetailRemision->getValueUnit().",".$objDetailRemision->getTotal().",'".$objDetailRemision->getMove()."')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function updateQuantityAndTotal($objDetailRemision){   
            $sql = "UPDATE REMISDETAL dtlr SET dtlr.REMDECANTI = ".$objDetailRemision->getQuantity().", dtlr.REMDEVALTO = ".$objDetailRemision->getTotal()." WHERE dtlr.REMDECODIG = ".$objDetailRemision->getCodeRemision()." AND dtlr.REMDEARTIC = '".$objDetailRemision->getCodeArticle()."' AND dtlr.REMDEFECGE = '".$objDetailRemision->getMoveDate()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function updateMovimiento(DetailRemision $objDetailRemision){
            $sql = "UPDATE REMISDETAL dtlr SET dtlr.REMDEMOVIM = 'D' WHERE dtlr.REMDECODIG = ".$objDetailRemision->getCodeRemision()." AND dtlr.REMDEARTIC = '".$objDetailRemision->getCodeArticle()."' AND dtlr.REMDECOLOR = ".$objDetailRemision->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function updateDevolucion(DetailRemision $objDetailRemision){
            $sql = "UPDATE REMISDETAL dtlr SET dtlr.REMDEDEVOL = ".$objDetailRemision->getDevolucion()." WHERE dtlr.REMDECODIG = ".$objDetailRemision->getCodeRemision()." AND dtlr.REMDEARTIC = '".$objDetailRemision->getCodeArticle()."' AND dtlr.REMDECOLOR = ".$objDetailRemision->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }
        
        public function verificarDevolucion(DetailRemision $objDetailRemision){
            $sql = "SELECT sum(REMDECANTI - REMDEDEVOL) from remisdetal dtlr WHERE dtlr.REMDECODIG = ".$objDetailRemision->getCodeRemision()." AND dtlr.REMDEARTIC = '".$objDetailRemision->getCodeArticle()."' AND dtlr.REMDECOLOR = ".$objDetailRemision->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;          
        }
        
        public function getDevolucion(DetailRemision $objDetailRemision){
            $sql = "SELECT REMDEDEVOL from remisdetal dtlr WHERE dtlr.REMDECODIG = ".$objDetailRemision->getCodeRemision()." AND dtlr.REMDEARTIC = '".$objDetailRemision->getCodeArticle()."' AND dtlr.REMDECOLOR = ".$objDetailRemision->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;          
        }
        public function getValueUnitario($objDetailRemision) {
            $sql = "SELECT dtlr.REMDEVALUN FROM REMISDETAL dtlr WHERE dtlr.REMDECODIG = ".$objDetailRemision->getCodeRemision()." AND dtlr.REMDEARTIC = '".$objDetailRemision->getCodeArticle()."' AND dtlr.REMDECOLOR = ".$objDetailRemision->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function delete(DetailRemision $objDetailRemision){
            $sql = "DELETE FROM REMISDETAL dtlr WHERE dtlr.REMDECODIG = ".$objDetailRemision->getCodeRemision()." AND dtlr.REMDEARTIC = '".$objDetailRemision->getCodeArticle()."' AND dtlr.REMDECOLOR = ".$objDetailRemision->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }           
        
        public function getTotalDetailRemision($objDetailRemision) {
            $sql = "SELECT SUM(dtlr.REMDEVALTO) FROM REMISDETAL dtlr WHERE dtlr.REMDECODIG = ".$objDetailRemision->getCodeRemision();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getValue($objDetailRemision) {
            $sql = "SELECT dtlr.REMDEVALTO FROM REMISDETAL dtlr WHERE dtlr.REMDECODIG = ".$objDetailRemision->getCodeRemision()." AND dtlr.REMDEARTIC = '".$objDetailRemision->getCodeArticle()."' AND dtlr.REMDECOLOR = ".$objDetailRemision->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        

        public function getCantidadDetailRemision($objDetailRemision) {
            $sql = "SELECT SUM(dtlr.REMDECANTI) FROM REMISDETAL dtlr WHERE dtlr.REMDECODIG = ".$objDetailRemision->getCodeRemision();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }


        public function getCountArticleFromDetailRemision($objDetailRemision) {
            $sql = "SELECT COUNT(*) FROM REMISDETAL dtlr WHERE dtlr.REMDEARTIC = '".$objDetailRemision->getCodeArticle()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function checkDetailRemisionExistencia(DetailRemision $objDetailRemision) {
            $sql = "SELECT COUNT(*) FROM REMISDETAL dtlr WHERE dtlr.REMDEARTIC = '".$objDetailRemision->getCodeArticle()."' AND dtlr.REMDECOLOR = ".$objDetailRemision->getColor()." AND dtlr.REMDECODIG = ".$objDetailRemision->getCodeRemision();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        public function getQuantityInDetailRemisionByRemision(DetailRemision $objDetailRemision) {
            $sql = "SELECT dtlr.REMDECANTI FROM REMISDETAL dtlr WHERE dtlr.REMDECODIG = ".$objDetailRemision->getCodeRemision()." AND dtlr.REMDEARTIC = '".$objDetailRemision->getCodeArticle()."'  AND dtlr.REMDECOLOR  = ".$objDetailRemision->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function updateQuantityValUnitValTotal(DetailRemision $objDetailRemision){   
            $sql = "UPDATE REMISDETAL dtlr SET dtlr.REMDECANTI = ".$objDetailRemision->getQuantity().", dtlr.REMDEVALUN = ".$objDetailRemision->getValueUnit().", dtlr.REMDEVALTO = ".$objDetailRemision->getTotal()." WHERE dtlr.REMDECODIG = ".$objDetailRemision->getCodeRemision()." AND dtlr.REMDEARTIC = '".$objDetailRemision->getCodeArticle()."' AND dtlr.REMDECOLOR  = ".$objDetailRemision->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function updateValUnitValTotal(DetailRemision $objDetailRemision){   
            $sql = "UPDATE REMISDETAL dtlr SET dtlr.REMDEVALUN = ".$objDetailRemision->getValueUnit().", dtlr.REMDEVALTO = ".$objDetailRemision->getTotal()." WHERE dtlr.REMDECODIG = ".$objDetailRemision->getCodeRemision()." AND dtlr.REMDEARTIC = '".$objDetailRemision->getCodeArticle()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 

}