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
    require_once('../models/DetailCxp.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/DetailCxp.php');
}


class DetailCxpImpl
{
	
	public function DetailCxpImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT * FROM CUENTPAGDE cxp ORDER BY cxp.CUPADCODIG DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetailCxp = new DetailCxp();
                $objDetailCxp->setCodeCxp($row[0]);
                $objDetailCxp->setCodeArticle($row[1]);
                $objDetailCxp->setFechaCreacion($row[2]);
                $objDetailCxp->setCantidad($row[3]);
                $objDetailCxp->setValorUnitario($row[4]);
                $objDetailCxp->setTotal($row[5]);
                $objDetailCxp->setColor($row[6]);
                $foo[] = $objDetailCxp;
            }
            return $foo;
        }
        
        public function getByCode($idCxp)
	{
            $sql = "SELECT *  FROM CUENTPAGDE cxp WHERE cxp.CUPADCODIG = ".$idCxp;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetailCxp = new DetailCxp();
                $objDetailCxp->setCodeCxp($row[0]);
                $objDetailCxp->setCodeArticle($row[1]);
                $objDetailCxp->setFechaCreacion($row[2]);
                $objDetailCxp->setCantidad($row[3]);
                $objDetailCxp->setValorUnitario($row[4]);
                $objDetailCxp->setTotal($row[5]); 
                $objDetailCxp->setColor($row[6]);
                $objDetailCxp->setDevolucion($row[8]);
                $foo[] = $objDetailCxp;
            }
            return $foo;
        }
        
        public function getByCodeBetweenDate($dateA, $dateB, $ref)
	{
//            echo '<script>console.log("es '.$ref.'")</script>';
            $sql = "SELECT * FROM CUENTPAGDE cxp WHERE UPPER(cxp.CUPADARTIC) = UPPER('".$ref."') AND cxp.CUPADFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetailCxp = new DetailCxp();
                $objDetailCxp->setCodeCxp($row[0]);
                $objDetailCxp->setCodeArticle($row[1]);
                $objDetailCxp->setFechaCreacion($row[2]);
                $objDetailCxp->setCantidad($row[3]);
                $objDetailCxp->setValorUnitario($row[4]);
                $objDetailCxp->setTotal($row[5]); 
                $objDetailCxp->setColor($row[6]);
                $objDetailCxp->setDevolucion($row[8]);
                $foo[] = $objDetailCxp;
            }
            return $foo;
        }
 
        public function checkDetailCxpExistencia(DetailCxp $objDetailCxp) {
            $sql = "SELECT COUNT(*) FROM CUENTPAGDE cxp WHERE cxp.CUPADARTIC = '".$objDetailCxp->getCodeArticle()."' AND cxp.CUPADCOLOR = ".$objDetailCxp->getColor()." AND cxp.CUPADCODIG = ".$objDetailCxp->getCodeCxp();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getQuantityInDetailCxpByCxp(DetailCxp $objDetailCxp) {
            $sql = "SELECT cxp.CUPADCANTI FROM CUENTPAGDE cxp WHERE cxp.CUPADCODIG = ".$objDetailCxp->getCodeCxp()." AND cxp.CUPADARTIC = '".$objDetailCxp->getCodeArticle()."'  AND cxp.CUPADCOLOR  = ".$objDetailCxp->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function updateQuantityValUnitValTotal(DetailCxp $objDetailCxp){   
            $sql = "UPDATE CUENTPAGDE cxp SET cxp.CUPADCANTI = ".$objDetailCxp->getCantidad().", cxp.CUPADVALUN = ".$objDetailCxp->getValorUnitario().", cxp.CUPADVALTO = ".$objDetailCxp->getTotal()." WHERE cxp.CUPADCODIG = ".$objDetailCxp->getCodeCxp()." AND cxp.CUPADARTIC = '".$objDetailCxp->getCodeArticle()."' AND cxp.CUPADCOLOR  = ".$objDetailCxp->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function insert(DetailCxp $objDetailCxp){
            $sql = "INSERT INTO CUENTPAGDE (CUPADCODIG, CUPADARTIC, CUPADFECGE, CUPADCANTI, CUPADVALUN, CUPADVALTO, CUPADCOLOR, CUPADDEVOL) VALUES (".$objDetailCxp->getCodeCxp().",'".$objDetailCxp->getCodeArticle()."', TO_DATE('".$objDetailCxp->getFechaCreacion()."', 'yyyy/mm/dd hh24:mi:ss'),".$objDetailCxp->getCantidad().",".$objDetailCxp->getValorUnitario().",".$objDetailCxp->getTotal().",".$objDetailCxp->getColor().", 0)";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }  
        
        public function getTotalDetailCxp(DetailCxp $objDetailCxp) {
            $sql = "SELECT SUM(cxp.CUPADVALTO) FROM CUENTPAGDE cxp WHERE cxp.CUPADCODIG = ".$objDetailCxp->getCodeCxp();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        public function updateDevolucion(DetailCxp $objDetailCxp){
            $sql = "UPDATE CUENTPAGDE cxp SET cxp.CUPADDEVOL = ".$objDetailCxp->getDevolucion()." WHERE cxp.CUPADCODIG = ".$objDetailCxp->getCodeCxp()." AND cxp.CUPADARTIC = '".$objDetailCxp->getCodeArticle()."' AND cxp.CUPADCOLOR = ".$objDetailCxp->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }
        
        public function verificarDevolucion(DetailCxp $objDetailCxp){
            $sql = "SELECT sum(CUPADCANTI - CUPADDEVOL) from CUENTPAGDE cxp WHERE cxp.CUPADCODIG = ".$objDetailCxp->getCodeCxp()." AND cxp.CUPADARTIC = '".$objDetailCxp->getCodeArticle()."' AND cxp.CUPADCOLOR = ".$objDetailCxp->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;          
        }
        public function getDevolucion(DetailCxp $objDetailCxp){
            $sql = "SELECT CUPADDEVOL from CUENTPAGDE cxp WHERE cxp.CUPADCODIG = ".$objDetailCxp->getCodeCxp()." AND cxp.CUPADARTIC = '".$objDetailCxp->getCodeArticle()."' AND cxp.CUPADCOLOR = ".$objDetailCxp->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;          
        }
        public function getValueUnitario($objDetailCxp) {
            $sql = "SELECT cxp.CUPADVALUN FROM CUENTPAGDE cxp WHERE cxp.CUPADCODIG = ".$objDetailCxp->getCodeCxp()." AND cxp.CUPADARTIC = '".$objDetailCxp->getCodeArticle()."' AND cxp.CUPADCOLOR = ".$objDetailCxp->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        public function delete(DetailCxp $objDetailCxp){
            $sql = "DELETE FROM CUENTPAGDE cxp WHERE cxp.CUPADCODIG = ".$objDetailCxp->getCodeCxp()." AND cxp.CUPADARTIC = '".$objDetailCxp->getCodeArticle()."' AND cxp.CUPADCOLOR = ".$objDetailCxp->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }
        
         public function getCountMovimientoD(DetailCxp $objDetailCxp) {
            $sql = "select count(*) FROM CUENTPAGDE WHERE CUPADCODIG = ".$objDetailCxp->getCodeCxp()." AND CUPADMOVIM IS NULL";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getByCodeNoDevolucion($idn)
	{
            $sql = "SELECT *  FROM CUENTPAGDE cxp WHERE cxp.CUPADCODIG = ".$idn." AND cxp.CUPADMOVIM IS NULL";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetailCxp = new DetailCxp();
                $objDetailCxp->setCodeCxp($row[0]);
                $objDetailCxp->setCodeArticle($row[1]);
                $objDetailCxp->setFechaCreacion($row[2]);
                $objDetailCxp->setCantidad($row[3]);
                $objDetailCxp->setValorUnitario($row[4]);
                $objDetailCxp->setTotal($row[5]);
                $objDetailCxp->setColor($row[6]);
                $objDetailCxp->setDevolucion($row[8]);
                
                $foo[] = $objDetailCxp;
            }
            return $foo;
        }
        
        public function updateMovimiento(DetailCxp $objDetailCxp){
            $sql = "UPDATE CUENTPAGDE cxp SET cxp.CUPADMOVIM = 'D' WHERE cxp.CUPADCODIG = ".$objDetailCxp->getCodeCxp()." AND cxp.CUPADARTIC = '".$objDetailCxp->getCodeArticle()."' AND cxp.CUPADCOLOR = ".$objDetailCxp->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function getByCxpArticleDate($idcxp, $idArticle, $dateMove)
	{
            $sql = "SELECT * FROM CUENTPAGDE cxp WHERE cxp.CUPADCODIG = ".$idcxp." AND cxp.CUPADARTIC = '".$idArticle."' AND cxp.CUPADFECGE = '".$dateMove."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetailCxp = new DetailCxp();
                $objDetailCxp->setCodeCxp($row[0]);
                $objDetailCxp->setCodeArticle($row[1]);
                $objDetailCxp->setFechaCreacion($row[2]);
                $objDetailCxp->setCantidad($row[3]);
                $objDetailCxp->setValorUnitario($row[4]);
                $objDetailCxp->setTotal($row[5]);                
                $objDetailCxp->setColor($row[6]);
                $foo[] = $objDetailCxp;
            }
            return $foo;
        }
        
        public function getByCxpArticleColor($idcxp, $idArticle, $color)
	{
            $sql = "SELECT * FROM CUENTPAGDE cxp WHERE cxp.CUPADCODIG = ".$idcxp." AND cxp.CUPADARTIC = '".$idArticle."' AND cxp.CUPADCOLOR = '".$color."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetailCxp = new DetailCxp();
                $objDetailCxp->setCodeCxp($row[0]);
                $objDetailCxp->setCodeArticle($row[1]);
                $objDetailCxp->setFechaCreacion($row[2]);
                $objDetailCxp->setCantidad($row[3]);
                $objDetailCxp->setValorUnitario($row[4]);
                $objDetailCxp->setTotal($row[5]);                
                $objDetailCxp->setColor($row[6]);
                $foo[] = $objDetailCxp;
            }
            return $foo;
        }
        
        public function getValue(DetailCxp $objDetailCxp) {
            $sql = "SELECT cxp.CUPADVALTO FROM CUENTPAGDE cxp WHERE cxp.CUPADCODIG = ".$objDetailCxp->getCodeCxp()." AND cxp.CUPADARTIC = '".$objDetailCxp->getCodeArticle()."' AND cxp.CUPADCOLOR = ".$objDetailCxp->getColor();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
         public function getCantidadDetailCxp(DetailCxp $objDetailCxp) {
            $sql = "SELECT SUM(cxp.CUPADCANTI) FROM CUENTPAGDE cxp WHERE cxp.CUPADCODIG = ".$objDetailCxp->getCodeCxp();
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