<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SellerImpl
 *
 * @author JuliánAndrés
 */


if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/Seller.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Seller.php');
}


class SellerImpl
{
	
	public function SellerImpl()
	{
		 
	}        
        public function insert(Seller $objSeller){
            $sql = "INSERT INTO vendedor (VENDECODIG, VENDEFACTU, VENDEFECGE) VALUES (".$objSeller->getCodeSeller().",".$objSeller->getBillRemision().",TO_DATE('".$objSeller->getRegistrationDate()."', 'yyyy/mm/dd hh24:mi:ss'))";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }  
        
        public function getNameVendedor($idf) {
            $sql = "select cliennombr from cliente where cliencodig = (select VENDECODIG from vendedor where VENDEFACTU = ".$idf.")";
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