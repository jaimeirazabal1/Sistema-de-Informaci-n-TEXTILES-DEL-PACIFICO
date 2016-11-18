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
    require_once('../models/Cxp.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Cxp.php');
}


class CxpImpl
{	
	public function CxpImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT * FROM cuentpagar cxp
			ORDER BY cxp.CUEPACODIG DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCxp = new Cxp();
                $objCxp->setCode($row[0]);
                $objCxp->setProveedor($row[1]);
                $objCxp->setFechaCreacion($row[2]);
                $objCxp->setFechaVencimiento($row[3]);
                $objCxp->setEstado($row[4]);                
                $objCxp->setOrigen($row[5]);
                $objCxp->setTotalCuenta($row[6]);
                $objCxp->setSaldoCuenta($row[7]);
                $objCxp->setIva($row[8]);
                $objCxp->setSaldoIva($row[9]);
                $objCxp->setValorReteICA($row[10]);
                $objCxp->setSaldoReteICA($row[11]);
                $objCxp->setValorReteTimbre($row[12]);
                $objCxp->setSaldoReteTimbre($row[13]);
                $objCxp->setUsuario($row[14]);
                $foo[] = $objCxp;
            }
            return $foo;
        }
        
        public function insert(Cxp $objCxp){
            $sql = "INSERT INTO cuentpagar (CUEPACODIG, CUEPAPROVE, CUEPAFECGE, CUEPAFECVE, CUEPAESTAD, CUEPAORIGE, CUEPAVALTO,CUEPASALDO,CUEPAVALIV,CUEPASALIV,CUEPAVALIC,CUEPASALIC,CUEPAVALTI,CUEPASALTI,CUEPAUSUAR,CUEPATIPO) 
                    VALUES (SEQ_CXP.NextVal,".$objCxp->getProveedor()." ,TO_DATE('".$objCxp->getFechaCreacion()."', 'yyyy/mm/dd hh24:mi:ss'),TO_DATE('".$objCxp->getFechaVencimiento()."', 'yyyy/mm/dd hh24:mi:ss'),'".$objCxp->getEstado()."','".$objCxp->getOrigen()."',".$objCxp->getTotalCuenta().",".$objCxp->getSaldoCuenta().",".$objCxp->getIva().",".$objCxp->getSaldoIva().",".$objCxp->getValorReteICA().",".$objCxp->getSaldoReteICA().",".$objCxp->getValorReteTimbre().",".$objCxp->getSaldoReteTimbre().",".$objCxp->getUsuario().",'".$objCxp->getTypePay()."')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }
        
        public function getId(Cxp $objCxp) {
            $sql = "SELECT cxp.CUEPACODIG FROM cuentpagar cxp WHERE cxp.CUEPAPROVE = ".$objCxp->getProveedor()." AND cxp.CUEPAFECGE = TO_DATE('".$objCxp->getFechaCreacion()."', 'dd-MM-yy hh24:mi:ss')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
         public function getByCode($idCxp)
	{
            $sql = "SELECT * FROM cuentpagar cxp WHERE cxp.CUEPACODIG = ".$idCxp;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCxp = new Cxp();
                $objCxp->setCode($row[0]);
                $objCxp->setProveedor($row[1]);
                $objCxp->setFechaCreacion($row[2]);
                $objCxp->setFechaVencimiento($row[3]);
                $objCxp->setEstado($row[4]);   
                $objCxp->setOrigen($row[5]);
                $objCxp->setTotalCuenta($row[6]);
                $objCxp->setSaldoCuenta($row[7]);
                $objCxp->setIva($row[8]);
                $objCxp->setSaldoIva($row[9]);
                $objCxp->setValorReteICA($row[10]);
                $objCxp->setSaldoReteICA($row[11]);
                $objCxp->setValorReteTimbre($row[12]);
                $objCxp->setSaldoReteTimbre($row[13]);
                $objCxp->setUsuario($row[14]);  
                $objCxp->setTypePay($row[15]);
                $foo[] = $objCxp;
            }
            return $foo;
        }
        
        public function updateTotal(Cxp $objCxp){   
            $sql = "UPDATE cuentpagar cxp 
			SET cxp.CUEPAVALTO = ".$objCxp->getTotalCuenta().", cxp.CUEPAVALIV = ".$objCxp->getIva()." WHERE cxp.CUEPACODIG = ".$objCxp->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }
        public function updateValuesNumeric(Cxp $objCxp){   
            $sql = "UPDATE cuentpagar cxp 
                    SET cxp.CUEPASALDO = ".$objCxp->getSaldoCuenta().", "
                    . "cxp.CUEPASALIV = ".$objCxp->getSaldoIva().", "
                    . "cxp.CUEPAVALIC = ".$objCxp->getValorReteICA().", "
                    . "cxp.CUEPASALIC = ".$objCxp->getSaldoReteICA().", "
                    . "cxp.CUEPAVALTI = ".$objCxp->getValorReteTimbre().", "
                    . "cxp.CUEPASALTI = ".$objCxp->getSaldoReteTimbre().", "
                    . "cxp.CUEPATIPO = '".$objCxp->getTypePay()."' "
                    . "WHERE cxp.CUEPACODIG = ".$objCxp->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }
        
        
        public function getAllLimit()
	{
            $sql = "SELECT * FROM cuentpagar cxp WHERE ROWNUM <= 5 ORDER BY cxp.CUEPACODIG DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCxp = new Cxp();
                $objCxp->setCode($row[0]);
                $objCxp->setProveedor($row[1]);
                $objCxp->setFechaCreacion($row[2]);
                $objCxp->setTotalCuenta($row[6]);
                $objCxp->setIva($row[8]);                
                $objCxp->setUsuario($row[14]);
                $foo[] = $objCxp;
            }
            return $foo;
        }
        
        public function updateSaldo(Cxp $objCxp){   
            $sql = "UPDATE cuentpagar cxp SET cxp.CUEPASALDO = '".$objCxp->getSaldoCuenta()."' WHERE cxp.CUEPACODIG = ".$objCxp->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }
        
        public function updateStateByID(Cxp $objCxp){   
            $sql = "UPDATE cuentpagar cxp SET cxp.CUEPAESTAD = '".$objCxp->getEstado()."' WHERE cxp.CUEPACODIG = ".$objCxp->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function getValue($codeCxp)
	{
            $sql = "SELECT cxp.CUEPAVALTO FROM cuentpagar cxp WHERE cxp.CUEPACODIG = ".$codeCxp;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getSaldo($codeCxp)
	{
            $sql = "SELECT cxp.CUEPASALDO FROM cuentpagar cxp WHERE cxp.CUEPACODIG = ".$codeCxp;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getByStateGE()
	{
            $sql = "SELECT cxp.* FROM cuentpagar cxp WHERE ROWNUM <= 50 AND cxp.CUEPAESTAD = 'GE' ORDER BY cxp.CUEPACODIG DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCxp = new Cxp();
                $objCxp->setCode($row[0]);
                $objCxp->setProveedor($row[1]);
                $objCxp->setFechaCreacion($row[2]);
                $objCxp->setFechaVencimiento($row[3]);
                $objCxp->setEstado($row[4]);                
                $objCxp->setOrigen($row[5]);
                $objCxp->setTotalCuenta($row[6]);
                $objCxp->setSaldoCuenta($row[7]);
                $objCxp->setIva($row[8]);
                $objCxp->setSaldoIva($row[9]);
                $objCxp->setValorReteICA($row[10]);
                $objCxp->setSaldoReteICA($row[11]);
                $objCxp->setValorReteTimbre($row[12]);
                $objCxp->setSaldoReteTimbre($row[13]);
                $objCxp->setUsuario($row[14]);
                $foo[] = $objCxp;
            }
            return $foo;
        }

}