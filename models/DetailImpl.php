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
    require_once('../models/Detail.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Detail.php');
}


class DetailImpl
{
	
	public function DetailImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT dtl.FACDECODIG, dtl.FACDEARTIC, dtl.FACDECANTI, dtl.FACDEVALUN, dtl.FACDEVALTO, dtl.FACDEFECMO FROM factudetal dtl ORDER BY dtl.FACDECODIG DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetail = new Detail();
                $objDetail->setCodeBill($row[0]);
                $objDetail->setCodeArticle($row[1]);
                $objDetail->setQuantity($row[2]);
                $objDetail->setValueUnit($row[3]);
                $objDetail->setTotal($row[4]);
                $objDetail->setMoveDate($row[5]);
                $foo[] = $objDetail;
            }
            return $foo;
        }
        
        public function getByCode($idBill)
	{
            $sql = "SELECT dtl.FACDECODIG, dtl.FACDEARTIC, dtl.FACDEFECGE, dtl.FACDECANTI, dtl.FACDEVALUN, dtl.FACDEVALTO, dtl.FACDECOLOR  FROM factudetal dtl WHERE dtl.FACDECODIG = ".$idBill;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetail = new Detail();
                $objDetail->setCodeBill($row[0]);
                $objDetail->setCodeArticle($row[1]);
                $objDetail->setMoveDate($row[2]);
                $objDetail->setQuantity($row[3]);
                $objDetail->setValueUnit($row[4]);
                $objDetail->setTotal($row[5]);
                $objDetail->setColor($row[6]);
                
                $foo[] = $objDetail;
            }
            return $foo;
        }
        
        public function getByBillArticleDate($idBill, $idArticle, $dateMove)
	{
            $sql = "SELECT dtl.FACDECODIG, dtl.FACDEARTIC, dtl.FACDECANTI, dtl.FACDEVALUN, dtl.FACDEVALTO, dtl.FACDEFECMO FROM factudetal dtl WHERE dtl.FACDECODIG = ".$idBill." AND dtl.FACDEARTIC = '".$idArticle."' AND dtl.FACDEFECMO = '".$dateMove."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetail = new Detail();
                $objDetail->setCodeBill($row[0]);
                $objDetail->setCodeArticle($row[1]);
                $objDetail->setQuantity($row[2]);
                $objDetail->setValueUnit($row[3]);
                $objDetail->setTotal($row[4]);
                $objDetail->setMoveDate($row[5]);
                $foo[] = $objDetail;
            }
            return $foo;
        }
                
        public function insert(Detail $objDetail){
            $sql = "INSERT INTO factudetal (FACDECODIG, FACDEARTIC, FACDEFECGE, FACDECANTI, FACDEVALUN, FACDEVALTO, FACDECOLOR) VALUES (".$objDetail->getCodeBill().",'".$objDetail->getCodeArticle()."', TO_DATE('".$objDetail->getMoveDate()."', 'yyyy/mm/dd hh24:mi:ss'),".$objDetail->getQuantity().",".$objDetail->getValueUnit().",".$objDetail->getTotal().",".$objDetail->getColor().")";
            //$sql = "INSERT INTO factudetal (FACDECODIG, FACDEARTIC, FACDECANTI, FACDEVALUN, FACDEVALTO, FACDEMOVIM) VALUES (".$objDetail->getCodeBill().",'".$objDetail->getCodeArticle()."',".$objDetail->getQuantity().",".$objDetail->getValueUnit().",".$objDetail->getTotal().",'".$objDetail->getMove()."')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function updateQuantityAndTotal($objDetail){   
            $sql = "UPDATE factudetal dtl SET dtl.FACDECANTI = ".$objDetail->getQuantity().", dtl.FACDEVALTO = ".$objDetail->getTotal()." WHERE dtl.FACDECODIG = ".$objDetail->getCodeBill()." AND dtl.FACDEARTIC = '".$objDetail->getCodeArticle()."' AND dtl.FACDEFECMO = '".$objDetail->getMoveDate()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function delete(Detail $objDetail){
            $sql = "DELETE FROM factudetal dtl WHERE dtl.FACDECODIG = ".$objDetail->getCodeBill()." AND dtl.FACDEARTIC = '".$objDetail->getCodeArticle()."' AND dtl.FACDECOLOR = ".$objDetail->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }           
        
        public function getTotalDetailBill($objDetail) {
            $sql = "SELECT SUM(dtl.FACDEVALTO) FROM FACTUDETAL dtl WHERE dtl.FACDECODIG = ".$objDetail->getCodeBill();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getCountArticleFromDetail($objDetail) {
            $sql = "SELECT COUNT(*) FROM FACTUDETAL dtl WHERE dtl.FACDEARTIC = '".$objDetail->getCodeArticle()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function checkDetailExistencia(Detail $objDetail) {
            $sql = "SELECT COUNT(*) FROM FACTUDETAL dtl WHERE dtl.FACDEARTIC = '".$objDetail->getCodeArticle()."' AND dtl.FACDECOLOR = ".$objDetail->getColor()." AND dtl.FACDECODIG = ".$objDetail->getCodeBill();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        public function getQuantityInDetailByBill(Detail $objDetail) {
            $sql = "SELECT dtl.FACDECANTI FROM FACTUDETAL dtl WHERE dtl.FACDECODIG = ".$objDetail->getCodeBill()." AND dtl.FACDEARTIC = '".$objDetail->getCodeArticle()."'  AND dtl.FACDECOLOR  = ".$objDetail->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function updateQuantityValUnitValTotal(Detail $objDetail){   
            $sql = "UPDATE factudetal dtl SET dtl.FACDECANTI = ".$objDetail->getQuantity().", dtl.FACDEVALUN = ".$objDetail->getValueUnit().", dtl.FACDEVALTO = ".$objDetail->getTotal()." WHERE dtl.FACDECODIG = ".$objDetail->getCodeBill()." AND dtl.FACDEARTIC = '".$objDetail->getCodeArticle()."' AND dtl.FACDECOLOR  = ".$objDetail->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function updateValUnitValTotal(Detail $objDetail){   
            $sql = "UPDATE factudetal dtl SET dtl.FACDEVALUN = ".$objDetail->getValueUnit().", dtl.FACDEVALTO = ".$objDetail->getTotal()." WHERE dtl.FACDECODIG = ".$objDetail->getCodeBill()." AND dtl.FACDEARTIC = '".$objDetail->getCodeArticle()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 

}