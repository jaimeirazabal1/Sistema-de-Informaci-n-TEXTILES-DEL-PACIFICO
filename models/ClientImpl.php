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
    require_once('../models/Client.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Client.php');
}
function sortFunction( $a, $b ) {
    return strtotime($a["FECHA"]) - strtotime($b["FECHA"]);
}

class ClientImpl
{
	
	public function ClientImpl()
	{
		 
	}
    public function movimiento_cartera_por_cliente(){
        if (isset($_POST['txbFechaFin'])) {
            if (isset($_POST['codigo_cliente']) and !empty($_POST['codigo_cliente'])) {
                $sql = "select 
                            remiscodig, 
                            remisfecge as fecha, 
                            remisvalor 
                            DEBITO 
                                from 
                            remision where remisfecge between to_date('".date('d/m/Y',strtotime($_POST['txbFechaInicio']))." 00:00:00', 'dd/mm/yyyy hh24:mi:ss') and 
                            to_date('".date('d/m/Y',strtotime($_POST['txbFechaFin']))." 23:59:59', 'dd/mm/yyyy hh24:mi:ss') 
                            and remisclien = '".$_POST['codigo_cliente']."' order by remiscodig";

                $sql2 = "select 
                            recaucodig, 
                            recaufecha as fecha, 
                            recauvalor 
                            CREDITO
                                from 
                            recaudo, credito where 
                            recaucredi = credicodig and recaufecha between to_date('".date('d/m/Y',strtotime($_POST['txbFechaInicio']))." 00:00:00', 'dd/mm/yyyy hh24:mi:ss')and to_date('".date('d/m/Y',strtotime($_POST['txbFechaFin']))." 23:59:59', 'dd/mm/yyyy hh24:mi:ss') and
                             crediclien = '".$_POST['codigo_cliente']."' order by recaucodig";
                /*echo "<pre>";
                echo $sql;
                echo $sql2;
                echo "</pre>";*/
                $conex = Conexion::getInstancia();
                $stid = oci_parse($conex, $sql);
               
              /*
      (
            [0] => -28
            [REMISCODIG] => -28
            [1] => 05-MAR-2016 00:00:00
            [FECHA] => 05-MAR-2016 00:00:00
            [2] => 7838450
            [DEBITO] => 7838450
        )
               [0] => 76
            [RECAUCODIG] => 76
            [1] => 23-MAY-2016 15:09:11
            [FECHA] => 23-MAY-2016 15:09:11
            [2] => 3000000
            [CREDITO] => 3000000
              */
                oci_execute($stid);
                
          
                $foo = array();
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                    $foo[]=$row;
                }
                 $stid2 = oci_parse($conex, $sql2);
                oci_execute($stid2);
               $foo2 = array();
                while (($row = oci_fetch_array($stid2, OCI_BOTH)) != false) {            
                    $foo2[]=$row;
                }
                $foo3 = array_merge($foo,$foo2);
                /*echo "<pre>";
                //print_r($foo);
                print_r($foo3);
                usort($foo3, "sortFunction");
                echo "</pre>";*/
                return $foo3;
            }
        }
    }
    public function get_gastos(){
        if (isset($_POST['codigo_vendedor']) and !empty($_POST['codigo_vendedor'])) {
            $sql = "select gastorecib, gastoclien, cliennombr, gastoconce, concenombr, gastofecha, gastovalor
                from gasto, cliente, concepto
                where gastoclien = cliencodig
                and gastoconce = concecodig
                and gastofecha between to_date('".date('d/m/Y',strtotime($_POST['txbFechaInicio']))." 00:00:00', 'dd/mm/yyyy hh24:mi:ss')
                and to_date('".date('d/m/Y',strtotime($_POST['txbFechaFin']))."', 'dd/mm/yyyy hh24:mi:ss')
                and gastoclien = '".$_POST['codigo_vendedor']."'
                order by gastofecha desc";
        }else{
            $sql = "select gastorecib, gastoclien, cliennombr, gastoconce, concenombr, gastofecha, gastovalor
                from gasto, cliente, concepto
                where gastoclien = cliencodig
                and gastoconce = concecodig
                and gastofecha between to_date('".date('d/m/Y',strtotime($_POST['txbFechaInicio']))." 00:00:00', 'dd/mm/yyyy hh24:mi:ss')
                and to_date('".date('d/m/Y',strtotime($_POST['txbFechaFin']))." 00:00:00', 'dd/mm/yyyy hh24:mi:ss')
                order by gastofecha desc";
        }

            //echo "<pre>".$sql."</pre>";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo[]=$row;
            }
            //var_dump(count($foo));
            return $foo;        
    }
    public function get_clientes(){
        $sql = "select * from cliente order by CLIENCODIG asc";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo[]=$row;
            }
            return $foo;        
    }
    public function get_vededores(){
        $sql = "select * from VENDETIPCL order by VENTCCODIG asc";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo[]=$row;
            }
            return $foo;
    }
    public function get_comisiones_vendedores(){
            if (isset($_POST['codigo_vendedor']) and !empty($_POST['codigo_vendedor'])) {
                $sql = "select * from vw_credito
                where vendefecge between to_date('".date('d/m/Y',strtotime($_POST['txbFechaInicio']))." 00:00:00', 'dd/mm/yyyy hh24:mi:ss')
                and to_date('".date('d/m/Y',strtotime($_POST['txbFechaFin']))." 23:59:59', 'dd/mm/yyyy hh24:mi:ss')
                and vendecodig = '".$_POST['codigo_vendedor']."'
                order by vendefecge";                
            }else{

                $sql = "select * from vw_credito
                where vendefecge between to_date('".date('d/m/Y',strtotime($_POST['txbFechaInicio']))." 00:00:00', 'dd/mm/yyyy hh24:mi:ss')
                and to_date('".date('d/m/Y',strtotime($_POST['txbFechaFin']))." 23:59:59', 'dd/mm/yyyy hh24:mi:ss')
                order by vendefecge";
            }
            //$sql = "select * from vw_credito";
            //echo $sql;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo[]=$row;
            }
            /*echo "<pre>";
            var_dump($foo[0]);
            echo "</pre>";*/

            return $foo;
    }
        
        public function getAll()
	{
            $sql = "SELECT clnt.CLIENCODIG, clnt.CLIENNOMBR, clnt.CLIENFECCR, clnt.CLIENDEPAR, clnt.CLIENLOCAL, 
			clnt.CLIENDIREC, clnt.CLIENDESPA, clnt.CLIENCELUL 
			FROM cliente clnt 
			WHERE ROWNUM <= 10 
			ORDER BY clnt.CLIENCODIG ASC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objClient = new Client();
                $objClient->setCode($row[0]);
                $objClient->setName($row[1]);
                $objClient->setRegistrationDate($row[2]);
                $objClient->setCodeDepartment($row[3]);
                $objClient->setCodeLocality($row[4]);
                $objClient->setDirection($row[5]);
                $objClient->setDespacho($row[6]);
                $objClient->setMobile($row[7]);
                $foo[] = $objClient;
            }
            return $foo;
        }

        
        public function getEmployees()
	{
            $sql = "SELECT clnt.CLIENCODIG, clnt.CLIENNOMBR FROM cliente clnt WHERE clnt.CLIENTIPO = 2 ORDER BY clnt.CLIENCODIG ASC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objClient = new Client();
                $objClient->setCode($row[0]);
                $objClient->setName($row[1]);
                $foo[] = $objClient;
            }
            return $foo;
        }

        
        public function getNameClient($idClient) {
            $sql = "SELECT clnt.CLIENNOMBR FROM cliente clnt WHERE clnt.CLIENCODIG = ".$idClient;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getTypeClient($idClient) {
            $sql = "select CLIENTIPO from CLIENTE clnt WHERE clnt.CLIENCODIG = ".$idClient;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getAddressClient($idClient) {
            $sql = "SELECT clnt.CLIENDIREC FROM cliente clnt WHERE clnt.CLIENCODIG = ".$idClient;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getMobileClient($idClient) {
            $sql = "SELECT clnt.CLIENCELUL FROM cliente clnt WHERE clnt.CLIENCODIG = ".$idClient;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getDepartment($idClient) {
            $sql = "SELECT clnt.CLIENDEPAR FROM cliente clnt WHERE clnt.CLIENCODIG = ".$idClient;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getLocality($idClient) {
            $sql = "SELECT clnt.CLIENLOCAL FROM cliente clnt WHERE clnt.CLIENCODIG = ".$idClient;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getByCode($idClient)
	{
            $sql = "SELECT clnt.CLIENCODIG, clnt.CLIENNOMBR, clnt.CLIENFECCR, clnt.CLIENDEPAR, clnt.CLIENLOCAL, clnt.CLIENDIREC, 
			clnt.CLIENDESPA, clnt.CLIENCELUL, clnt.CLIENUSURE, clnt.CLIENTIPO, clnt.CLIENESTAD, clnt.CLIENOBSER 
			FROM cliente clnt WHERE clnt.CLIENCODIG = ".$idClient;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objClient = new Client();
                $objClient->setCode($row[0]);
                $objClient->setName($row[1]);
                $objClient->setRegistrationDate($row[2]);
                $objClient->setCodeDepartment($row[3]);
                $objClient->setCodeLocality($row[4]);
                $objClient->setDirection($row[5]);
                $objClient->setDespacho($row[6]);
                $objClient->setMobile($row[7]);
                $objClient->setUser($row[8]);
                $objClient->setTipo($row[9]);
                $objClient->setState($row[10]);
                $objClient->setObservation($row[11]);
                $foo[] = $objClient;
            }
            return $foo;
        }

        
        public function getCountTypeClientFromClient(Client $objClient) {
            $sql = "SELECT COUNT(*) FROM cliente clnt WHERE clnt.CLIENTIPO = ".$objClient->getTipo();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function insert(Client $objClient){
            $sql = "INSERT INTO cliente (CLIENCODIG, CLIENNOMBR, CLIENFECCR, CLIENDEPAR, CLIENLOCAL, 
			CLIENDIREC, CLIENCELUL, CLIENUSURE, CLIENTIPO, CLIENESTAD, CLIENDESPA, CLIENOBSER) 
			VALUES (".$objClient->getCode().",'".$objClient->getName()."',
			TO_DATE('".$objClient->getRegistrationDate()."', 'yyyy/mm/dd hh24:mi:ss'),".$objClient->getCodeDepartment().",
			".$objClient->getCodeLocality().",'".$objClient->getDirection()."',".$objClient->getMobile().",".$objClient->getUser().",
			".$objClient->getTipo().",'".$objClient->getState()."','".$objClient->getDespacho()."','".$objClient->getObservation()."')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        

        
        public function update(Client $objClient, $id){   
            $sql = "UPDATE cliente clnt 
			SET clnt.CLIENCODIG = ".$objClient->getCode().", 
			clnt.CLIENNOMBR = '".$objClient->getName()."', 
			clnt.CLIENDEPAR = ".$objClient->getCodeDepartment().", 
			clnt.CLIENLOCAL = ".$objClient->getCodeLocality().", 
			clnt.CLIENDIREC = '".$objClient->getDirection()."', 
			clnt.CLIENCELUL = ".$objClient->getMobile().", 
			clnt.CLIENTIPO = ".$objClient->getTipo().", 
			clnt.CLIENESTAD = '".$objClient->getState()."', 
			clnt.CLIENDESPA = '".$objClient->getDespacho()."',
                        clnt.CLIENOBSER = '".$objClient->getObservation()."'
			WHERE clnt.CLIENCODIG = ".$id;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 

        
        public function delete($objClient){
            $sql = "DELETE FROM cliente clnt WHERE clnt.CLIENCODIG = ".$objClient->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        

        
        public function getCount() {
            $sql = "SELECT COUNT(*) FROM cliente";
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
            $sql  = "SELECT COUNT(*) FROM cliente clnt WHERE clnt.CLIENCODIG = ".$code;            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getReportSeller($fi, $ff)
	{
            $sql = "select count(1) CANTIDAD, vendecodig, cliennombr 
			from vendedor, cliente 
			where cliencodig = vendecodig 
			and vendefecge BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') 
			AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') group by vendecodig, cliennombr 
			order by CANTIDAD DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objClient = new Client();
                $objClient->setCodeDepartment($row[0]); //es usado para mostrar la cantidad. es solo por ayuda
                $objClient->setCode($row[1]);
                $objClient->setName($row[2]);
                $foo[] = $objClient;
            }
            return $foo;
        }

        
        public function getCountReportSeller($dateA, $dateB)
	{
            $sql = "SELECT COUNT(*) FROM vendedor vdr "
                . "WHERE vdr.vendefecge BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = 0;
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo = $row[0];
            }
            return $foo;
        } 
}