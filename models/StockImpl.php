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
    require_once('../models/Stock.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Stock.php');
}

class StockImpl
{
	
	public function StockImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT invtr.INVENCODIG, invtr.INVENNOMBR, invtr.INVENMOVIM, invtr.INVENCANTI, 
			invtr.INVENCOSTO, invtr.INVENPREVE, invtr.INVENCOLOR, invtr.INVENFECMO 
			FROM inventario invtr 
			WHERE ROWNUM <= 10 
			AND invtr.INVENMOVIM = 'E' 
			ORDER BY invtr.INVENFECMO DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setMove($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setPriceBuy($row[4]);
                $objStock->setPriceSold($row[5]);
                $objStock->setColor($row[6]);
                $objStock->setMoveDate($row[7]);
                $foo[] = $objStock;
            }
            return $foo;
        }

        
        public function getByCode($idStock)
	{
            $sql = "SELECT invtr.INVENCODIG, invtr.INVENNOMBR, invtr.INVENMOVIM, invtr.INVENCANTI, 
			invtr.INVENCOLOR, invtr.INVENFECMO 
			FROM inventario invtr 
			WHERE invtr.INVENCODIG = ".$idStock;                        
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();    
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setMove($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setPriceBuy($row[4]);
                $objStock->setPriceSold($row[5]);
                $objStock->setColor($row[6]);
                $objStock->setMoveDate($row[7]);
                $objStock->setUser($row[8]);                
                
                $foo[] = $objStock;
            }
            return $foo;
        }

        
        public function getByCodeEdit($idStock)
	{
            $sql = "SELECT invtr.INVENCODIG, invtr.INVENNOMBR FROM inventario invtr WHERE invtr.INVENCODIG = '".$idStock."'";                        
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();    
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);   
                $foo[] = $objStock;
            }
            return $foo;
        }

        
        public function getNameArticle($idArticle) {
            $sql = "SELECT invtr.INVENNOMBR FROM inventario invtr WHERE invtr.INVENCODIG = '".$idArticle."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getColor($idArticle) {
            $sql = "SELECT invtr.INVENCOLOR FROM inventario invtr WHERE invtr.INVENCODIG = '".$idArticle."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getPromPriceReport($fi, $ff, $ref, $color) {
           
            $sql = "SELECT AVG(invtr.INVENCOSTO) FROM inventario invtr "
            . "WHERE invtr.INVENMOVIM = 'E' AND invtr.INVENFECMO " 
            . "BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
            . "AND invtr.INVENCODIG = UPPER('".$ref."')"
            . " ORDER BY invtr.INVENCODIG";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getByAlmacen()
	{
            //$sql = "SELECT invtr.INVENCODIG, invtr.INVENNOMBR, invtr.INVENMOVIM, invtr.INVENCANTI, invtr.INVENCOSTO, invtr.INVENPREVE, invtr.INVENCOLOR, invtr.INVENFECMO FROM inventario invtr WHERE ROWNUM <= 5 AND invtr.INVENMOVIM = 'E' ORDER BY invtr.INVENFECMO DESC";
            $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR, invtr.INVENCOLOR 
					FROM inventario invtr "
                    . "WHERE ROWNUM <= 5 
					AND invtr.INVENMOVIM = 'E' "
                    . "ORDER BY invtr.INVENCODIG";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setColor($row[2]);
                /*$objStock->setMove($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setPriceBuy($row[4]);
                $objStock->setPriceSold($row[5]);*/
                //$objStock->setColor($row[6]);
                //$objStock->setMoveDate($row[7]);
                $foo[] = $objStock;
            }
            return $foo;
        }

        
        public function getSumStock($dateA, $dateB) {
            $sql = "SELECT SUM(invtr.INVENCOSTO * invtr.INVENCANTI) 
			FROM inventario invtr 
			WHERE invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
                
        public function getSumStockByDate($dateA, $dateB, $ref) {
            $sql = "SELECT SUM(invtr.INVENCOSTO * invtr.INVENCANTI) 
			FROM inventario invtr
                        WHERE invtr.INVENCODIG = 'XXXZZZ' 
                        AND invtr.INVENMOVIM = 'E'
                        AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        public function getSumStockCosto($dateA, $dateB) {
            $sql = "SELECT SUM(invtr.INVENCOSTO * invtr.INVENCANTI) 
			FROM inventario invtr 
			WHERE invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')
			AND invtr.INVENMOVIM in ('E', 'D')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        

        public function getByAlmacenBetweenDate($dateA, $dateB, $ref, $color)
	{
            if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR
				FROM inventario invtr "
                . "WHERE invtr.INVENMOVIM = 'E' 
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY invtr.INVENCODIG";
            }
            else
            {
                $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR
				FROM inventario invtr "
                . "WHERE invtr.INVENMOVIM = 'E' 
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND invtr.INVENCODIG = UPPER('".$ref."') "
                . "ORDER BY invtr.INVENCODIG";
            }
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setColor(isset($row[2]) ? $row[2] : 'grey');
                /*$objStock->setMove($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setPriceBuy($row[4]);
                $objStock->setPriceSold($row[5]);
                $objStock->setColor($row[6]);
                $objStock->setMoveDate($row[7]);*/
                $foo[] = $objStock;
            }
            return $foo;
        }
        
        public function getWithoutDocument($ref)
	{
             $sql = "SELECT * FROM inventario invtr WHERE invtr.INVENMOVIM = 'E' "
                     . " AND invtr.INVENFECMO BETWEEN  TO_DATE('2016/09/16 00:00:00', 'yyyy/mm/dd hh24:mi:ss')"
                     . " AND TO_DATE('2016/09/16 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                     . " AND invtr.INVENCODIG = 'CCCVVV'";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setColor($row[2]);
                $objStock->setMove($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setPriceBuy($row[4]);
                $objStock->setPriceSold($row[5]);
                $objStock->setColor($row[6]);
                $objStock->setMoveDate($row[7]);
                $foo[] = $objStock;
            }
            return $foo;
        }
        
        public function getByAlgodonBetweenDate($dateA, $dateB, $ref, $color)
	{
            if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR
				FROM inventario invtr "
                . "WHERE invtr.INVENMOVIM in ('E', 'D')
				AND invtr.INVENCODIG like '7704%'
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
                ORDER BY invtr.INVENCODIG";
            }
            else
            {
                $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR
				FROM inventario invtr "
                . "WHERE invtr.INVENMOVIM in ('E', 'D')
				AND invtr.INVENCODIG like '7704%'
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND invtr.INVENCODIG = UPPER('".$ref."') "
                . "ORDER BY invtr.INVENCODIG";
            }
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setQuantity($row[2]);
                /*$objStock->setMove($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setPriceBuy($row[4]);
                $objStock->setPriceSold($row[5]);
                $objStock->setColor($row[6]);
                $objStock->setMoveDate($row[7]);*/
                $foo[] = $objStock;
            }
            return $foo;
        }

        
        public function getByEsmeriladaBetweenDate($dateA, $dateB, $ref, $color)
	{
            if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR
				FROM inventario invtr "
                . "WHERE invtr.INVENMOVIM in ('E', 'D')
				AND invtr.INVENNOMBR like '%ESME%'
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
                ORDER BY invtr.INVENCODIG";
            }
            else
            {
                $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR
				FROM inventario invtr "
                . "WHERE invtr.INVENMOVIM in ('E', 'D')
				AND invtr.INVENNOMBR like '%ESME%'
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND invtr.INVENCODIG = UPPER('".$ref."') "
                . "ORDER BY invtr.INVENCODIG";
            }
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setQuantity($row[2]);
                /*$objStock->setMove($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setPriceBuy($row[4]);
                $objStock->setPriceSold($row[5]);
                $objStock->setColor($row[6]);
                $objStock->setMoveDate($row[7]);*/
                $foo[] = $objStock;
            }
            return $foo;
        }


        public function getByVentasAlgodonBetweenDate($dateA, $dateB, $ref, $color)
	{
            if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT remdecolor, colornombr, sum(remdecanti)
				FROM remisdetal, color "
                . "WHERE remdecolor = colorcodig
				AND remdeartic like '7704%'
				AND REMDEFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				GROUP BY remdecolor, colornombr";
            }
            else
            {
                $sql = "SELECT remdecolor, colornombr, sum(remdecanti)
				FROM remisdetal, color "
                . "WHERE remdecolor = colorcodig
				AND remdeartic like '7704%'
				AND REMDEFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND REMDEARTIC = UPPER('".$ref."') 
				GROUP BY remdecolor, colornombr";
            }
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setQuantity($row[2]);
                /*$objStock->setMove($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setPriceBuy($row[4]);
                $objStock->setPriceSold($row[5]);
                $objStock->setColor($row[6]);
                $objStock->setMoveDate($row[7]);*/
                $foo[] = $objStock;
            }
            return $foo;
        }

        
        public function getByVentasRayasBetweenDate($dateA, $dateB, $ref, $color)
	{
            if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT remdecolor, colornombr, sum(remdecanti)
				FROM remisdetal, color "
                . "WHERE remdecolor = colorcodig
				AND remdeartic in ('770502', '770503', '770504', '770505', '770506', '770507', '770508', '770509', '770511', '770514',
				'770517', '770523', '770525', '770529', '770538', '770541', '770552', '770583', '770602', '770603',
				'770604', '770605', '770606', '770607', '770609', '770611', '770614', '770617', '770623', '770624',
				'770625', '770629', '770638', '770641', '770652', '770683', '770702', '770705', '770706', '770707',
				'770708', '770709', '770711', '770714', '770723', '770724', '770729', '770741', '770752')
				AND REMDEFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				GROUP BY remdecolor, colornombr";
            }
            else
            {
                $sql = "SELECT remdecolor, colornombr, sum(remdecanti)
				FROM remisdetal, color "
                . "WHERE remdecolor = colorcodig
				AND remdeartic in ('770502', '770503', '770504', '770505', '770506', '770507', '770508', '770509', '770511', '770514',
				'770517', '770523', '770525', '770529', '770538', '770541', '770552', '770583', '770602', '770603',
				'770604', '770605', '770606', '770607', '770609', '770611', '770614', '770617', '770623', '770624',
				'770625', '770629', '770638', '770641', '770652', '770683', '770702', '770705', '770706', '770707',
				'770708', '770709', '770711', '770714', '770723', '770724', '770729', '770741', '770752')
				AND REMDEFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND REMDEARTIC = UPPER('".$ref."') 
				GROUP BY remdecolor, colornombr";
            }
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setQuantity($row[2]);
                /*$objStock->setMove($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setPriceBuy($row[4]);
                $objStock->setPriceSold($row[5]);
                $objStock->setColor($row[6]);
                $objStock->setMoveDate($row[7]);*/
                $foo[] = $objStock;
            }
            return $foo;
        }

        
        public function getByVentasViscosaBetweenDate($dateA, $dateB, $ref, $color)
	{
            if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT remdecolor, colornombr, sum(remdecanti)
				FROM remisdetal, color "
                . "WHERE remdecolor = colorcodig
				AND remdeartic like '7708%'
				AND REMDEFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				GROUP BY remdecolor, colornombr";
            }
            else
            {
                $sql = "SELECT remdecolor, colornombr, sum(remdecanti)
				FROM remisdetal, color "
                . "WHERE remdecolor = colorcodig
				AND remdeartic like '7708%'
				AND REMDEFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND REMDEARTIC = UPPER('".$ref."') 
				GROUP BY remdecolor, colornombr";
            }
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setQuantity($row[2]);
                /*$objStock->setMove($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setPriceBuy($row[4]);
                $objStock->setPriceSold($row[5]);
                $objStock->setColor($row[6]);
                $objStock->setMoveDate($row[7]);*/
                $foo[] = $objStock;
            }
            return $foo;
        }

        
        public function getByRayasBetweenDate($dateA, $dateB, $ref, $color)
	{
            if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR
				FROM inventario invtr "
                . "WHERE invtr.INVENMOVIM in ('E', 'D')
				AND invtr.INVENNOMBR like '%RAYA%'
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				ORDER BY invtr.INVENCODIG";
            }
            else
            {
                $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR
				FROM inventario invtr "
                . "WHERE invtr.INVENMOVIM in ('E', 'D')
				AND invtr.INVENNOMBR like '%RAYA%'
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND invtr.INVENCODIG = UPPER('".$ref."')
				ORDER BY invtr.INVENCODIG";
            }

            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setQuantity($row[2]);
                /*$objStock->setMove($row[2]);
                $objStock->setPriceBuy($row[4]);
                $objStock->setPriceSold($row[5]);
                $objStock->setColor($row[6]);
                $objStock->setMoveDate($row[7]);*/
                $foo[] = $objStock;
            }
            return $foo;
        }

        
        public function getByViscosaBetweenDate($dateA, $dateB, $ref, $color)
	{
            if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR
				FROM inventario invtr "
                . "WHERE invencodig like '7708%'
				AND invtr.INVENMOVIM in ('E', 'D')
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				ORDER BY invtr.INVENCODIG";
            }
            else
            {
                $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR
				FROM inventario invtr "
                . "WHERE invencodig like '7708%'
				AND invtr.INVENMOVIM in ('E', 'D')
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND invtr.INVENCODIG = UPPER('".$ref."')
				ORDER BY invtr.INVENCODIG";
            }

            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setQuantity($row[2]);
                /*$objStock->setMove($row[2]);
                $objStock->setPriceBuy($row[4]);
                $objStock->setPriceSold($row[5]);
                $objStock->setColor($row[6]);
                $objStock->setMoveDate($row[7]);*/
                $foo[] = $objStock;
            }
            return $foo;
        }


        public function getByArticleInOutBetweenDate($dateA, $dateB, $ref)
	{
//            $sql = "SELECT invtr.INVENCODIG, invtr.INVENNOMBR, invtr.INVENMOVIM, invtr.INVENCANTI, invtr.INVENFECMO FROM inventario invtr "
//                . "WHERE invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
//                . "AND invtr.INVENCODIG = UPPER('".$ref."') "
//                . "AND (invtr.INVENMOVIM = 'E' "                    
//                . "OR invtr.INVENMOVIM = 'V') "
//                . "ORDER BY invtr.INVENFECMO";
            
            $sql = "SELECT invtr.INVENCODIG, invtr.INVENNOMBR, invtr.INVENMOVIM, invtr.INVENCANTI, invtr.INVENFECMO 
			FROM inventario invtr "
            . "WHERE invtr.INVENFECMO >= TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND invtr.INVENFECMO <= TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
            . "AND invtr.INVENCODIG = UPPER('".$ref."') "
            . "AND (invtr.INVENMOVIM = 'E' "                    
            . "OR invtr.INVENMOVIM = 'S' "
			. "OR invtr.INVENMOVIM = 'D' "
			. "OR invtr.INVENMOVIM = 'A') "
            . "ORDER BY invtr.INVENFECMO";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setMove($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setMoveDate($row[4]);
                $foo[] = $objStock;
            }
            return $foo;
        }
        
        public function getByArticleMovimBetweenDate($dateA, $dateB, $ref)
	{
            
            $sql = "SELECT remdecodig, remisclien, cliennombr, remdecanti, remdevalun, remdevalto 
			FROM remision, remisdetal, cliente "
            . "WHERE REMDEFECGE >= TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND REMDEFECGE <= TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
            . "AND remdeartic = UPPER('".$ref."') "
            . "AND remiscodig = remdecodig "                    
            . "AND remisclien = cliencodig "
            . "ORDER BY remdecodig";

            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setRemision($row[0]);
                $objStock->setCliente($row[1]);
                $objStock->setName($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setValorUnit($row[4]);
                $objStock->setValorTotal($row[5]);
                $foo[] = $objStock;
            }
            return $foo;
        }


        public function getCountKilos($dateA, $dateB, $ref) {
            $sql = "SELECT SUM(remdecanti) 
			FROM remision, remisdetal, cliente 
			WHERE remdeartic = '".$ref."' 
			AND remiscodig = remdecodig
			AND remisclien = cliencodig
			AND REMDEFECGE >= TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND REMDEFECGE <= TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
			GROUP BY remdeartic";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

		
        public function getCountValorTotal($dateA, $dateB, $ref) {
            $sql = "SELECT SUM(remdevalto) 
			FROM remision, remisdetal, cliente 
			WHERE remdeartic = '".$ref."' 
			AND remiscodig = remdecodig
			AND remisclien = cliencodig
			AND REMDEFECGE >= TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND REMDEFECGE <= TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
			GROUP BY remdeartic";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

		
        public function getCountByAlmacenBetweenDate($dateA, $dateB, $ref)
	{
            if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT COUNT(*) FROM inventario invtr "
                . "WHERE invtr.INVENMOVIM = 'E' 
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY invtr.INVENCODIG";
            }
            else
            {
                $sql = "SELECT COUNT(*) FROM inventario invtr "
                . "WHERE invtr.INVENMOVIM = 'E' 
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND invtr.INVENCODIG = UPPER('".$ref."') "
                . "ORDER BY invtr.INVENCODIG";
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
        
        
        public function getCountAlgodonBetweenDate($dateA, $dateB, $ref)
	{
            if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT COUNT(*) FROM inventario invtr "
                . "WHERE invtr.invencodig like '7704%' 
				AND invtr.INVENMOVIM in ('E', 'D') 
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
//                . "ORDER BY invtr.INVENCODIG";
            }
            else
            {
                $sql = "SELECT COUNT(*) FROM inventario invtr "
                . "WHERE invtr.invencodig like '7704%' 
				AND invtr.INVENMOVIM in ('E', 'D')
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND invtr.INVENCODIG = UPPER('".$ref."') ";
//                . "ORDER BY invtr.INVENCODIG";
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

        
        public function getCountEsmeriladaBetweenDate($dateA, $dateB, $ref)
	{
            if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT COUNT(*) FROM inventario invtr "
                . "WHERE invtr.invennombr like '%ESME%' 
				AND invtr.INVENMOVIM in ('E', 'D') 
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            }
            else
            {
                $sql = "SELECT COUNT(*) FROM inventario invtr "
                . "WHERE invtr.invennombr like '%ESME%' 
				AND invtr.INVENMOVIM in ('E', 'D')
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND invtr.INVENCODIG = UPPER('".$ref."') ";
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

        
        public function getCountViscosaBetweenDate($dateA, $dateB, $ref)
	{
            if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT COUNT(*) FROM inventario invtr "
                . "WHERE invtr.invennombr like '%VISCOSA%' 
				AND invtr.INVENMOVIM in ('E', 'D') 
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            }
            else
            {
                $sql = "SELECT COUNT(*) FROM inventario invtr "
                . "WHERE invtr.invennombr like '%VISCOSA%' 
				AND invtr.INVENMOVIM in ('E', 'D')
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND invtr.INVENCODIG = UPPER('".$ref."') ";
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

        
        public function getCountRayasBetweenDate($dateA, $dateB, $ref)
	{
            if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT COUNT(*) FROM inventario invtr "
                . "WHERE invtr.invennombr not like '%ALGODON%' 
				AND invtr.INVENMOVIM in ('E', 'D') 
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
//                . "ORDER BY invtr.INVENCODIG";
            }
            else
            {
                $sql = "SELECT COUNT(*) FROM inventario invtr "
                . "WHERE invtr.invennombr not like '%ALGODON%' 
				AND invtr.INVENMOVIM in ('E', 'D')
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND invtr.INVENCODIG = UPPER('".$ref."') ";
//                . "ORDER BY invtr.INVENCODIG";
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
        
        
        public function getCountByAlmacenBetweenDateReportArticle($dateA, $dateB, $ref)
	{
            if(strcmp($ref, "") != 0)
            {
                $sql = "SELECT COUNT(*) FROM inventario invtr "
                . "WHERE invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND invtr.INVENCODIG = UPPER('".$ref."') "
                . "ORDER BY invtr.INVENCODIG";
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
        
        public function insert($objStock){
            $sql = "INSERT INTO inventario (INVENCODIG, INVENNOMBR, INVENMOVIM, INVENCANTI, INVENCOSTO, INVENPREVE, INVENCOLOR, INVENFECMO, INVENUSUAR) 
			VALUES('".$objStock->getCode()."','".$objStock->getName()."','".$objStock->getMove()."',".$objStock->getQuantity().",
			".$objStock->getPriceBuy().",".$objStock->getPriceSold().",'".$objStock->getColor()."',
			TO_DATE('".$objStock->getMoveDate()."', 'yyyy/mm/dd hh24:mi:ss'),".$objStock->getUser().")";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);      
        }        

        
        public function update(Stock $objStock, $id){   
            $sql = "UPDATE inventario invtr 
			SET invtr.INVENCODIG = '".$objStock->getCode()."', invtr.INVENNOMBR = '".$objStock->getName()."', invtr.INVENCOLOR = ".$objStock->getColor()." 
			WHERE invtr.INVENCODIG = '".$id."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 

        
        public function updatePrices(Stock $objStock){   
            $sql = "UPDATE inventario invtr 
			SET invtr.INVENCOSTO = ".$objStock->getPriceBuy().", invtr.INVENPREVE = ".$objStock->getPriceSold()." 
			WHERE invtr.INVENCODIG = '".$objStock->getCode()."' 
			AND invtr.INVENCOLOR = ".$objStock->getColor()." 
			AND invtr.INVENMOVIM = 'E' ";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }

        
        public function updateQuantity($objStock){   
            $sql = "UPDATE inventario invtr 
			SET invtr.INVENCANTI = ".$objStock->getQuantity()." 
			WHERE invtr.INVENCODIG = '".$objStock->getCode()."' 
			AND invtr.INVENMOVIM = '".$objStock->getMove()."' 
			AND invtr.INVENFECMO = '".$objStock->getMoveDate()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }

        
        public function delete($objStock){
            $sql = "DELETE FROM inventario invtr 
			WHERE invtr.INVENCODIG = '".$objStock->getCode()."' 
			AND invtr.INVENMOVIM = '".$objStock->getMove()."' 
			AND invtr.INVENFECMO = '".$objStock->getMoveDate()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        

        
        public function moveToAlmacen($objStock){   
            $sql = "UPDATE inventario invtr 
			SET invtr.INVENMOVIM = 'S', invtr.INVENCOLOR = 'A' 
			WHERE invtr.INVENCODIG = '".$objStock->getCode()."' 
			AND invtr.INVENMOVIM = '".$objStock->getMove()."' 
			AND invtr.INVENFECMO = '".$objStock->getMoveDate()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }

        
        public function getCount() {
            $sql = "SELECT  COUNT(*) FROM inventario";
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
            $sql  = "SELECT COUNT(*) FROM inventario invtr WHERE UPPER(invtr.INVENCODIG) = '".$code."'";            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getQuantityAvailable($code, $color) {
            $sql = "SELECT SUM(invtr.INVENCANTI) 
			FROM inventario invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM = 'E'
            OR invtr.INVENCODIG = '".$code."'
            AND invtr.INVENMOVIM = 'D'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getQuantityAvailable2($code, $color, $dateA, $dateB) {
            $sql = "SELECT SUM(invtr.INVENCANTI) 
			FROM inventario invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM = 'E'
            AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
			OR invtr.INVENCODIG = '".$code."'
            AND invtr.INVENMOVIM = 'D'
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        

        public function getQuantityAvailableBetweenDate($code, $dateA, $dateB, $color) {
            $sql = "SELECT SUM(invtr.INVENCANTI) 
			FROM inventario invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM = 'E'
                        AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss')
                        AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')";
                
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getFirstQuantityAvailableBetweenDate($code, $dateA, $dateB, $color) {
            $sql = "SELECT invtr.INVENCANTI, INVENCOSTO
			FROM inventario invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM = 'E'
                        AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss')
                        AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')
                        AND ROWNUM < 2";
                
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);        
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setQuantity($row[0]);
                $objStock->setPriceBuy($row[1]);
                $foo[] = $objStock;
            }
            return $foo;            
        }
        

        public function getQuantityAvailableAlgodon($code, $color) {
            $sql = "SELECT SUM(invtr.INVENCANTI) 
			FROM inventario invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM in ('E', 'D')";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        

        public function getQuantityAvailableAlgodon2($code, $color, $dateA, $dateB) {
            $sql = "SELECT SUM(invtr.INVENCANTI) 
			FROM inventario invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM in ('E', 'D')
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }


        public function getQuantityAvailableEsmerilada($code, $color, $dateA, $dateB) {
            $sql = "SELECT SUM(invtr.INVENCANTI) 
			FROM inventario invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM in ('E', 'D')
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }


        public function getQuantityAvailableViscosa($code, $color, $dateA, $dateB) {
            $sql = "SELECT SUM(invtr.INVENCANTI) 
			FROM inventario invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM in ('E', 'D')
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }


        public function getQuantityAvailableRayas($code, $color, $dateA, $dateB) {
            $sql = "SELECT SUM(invtr.INVENCANTI) 
			FROM inventario invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM in ('E', 'D')
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }


        public function getQuantitySale($code, $color) {
            $sql = "SELECT SUM(invtr.INVENCANTI) 
			FROM inventario invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM = 'S'
            OR invtr.INVENCODIG = '".$code."'
            AND invtr.INVENMOVIM = 'P'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = 0;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
//        public function getQuantityAvailable($code) {
//            $sql = "SELECT  SUM(invtr.INVENCANTI) FROM inventario invtr WHERE invtr.INVENCODIG = '".$code."' AND invtr.INVENMOVIM = 'E'";
//            $conex = Conexion::getInstancia();
//            $stid = oci_parse($conex, $sql);
//            oci_execute($stid);
//            $foo;
//
//            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
//              $foo = $row[0];
//            }        
//            return $foo;
//        }
//        
//        public function getQuantitySale($code) {
//            $sql = "SELECT  SUM(invtr.INVENCANTI) FROM inventario invtr WHERE invtr.INVENCODIG = '".$code."' AND invtr.INVENMOVIM = 'V'";
//            $conex = Conexion::getInstancia();
//            $stid = oci_parse($conex, $sql);
//            oci_execute($stid);
//            $foo;
//
//            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
//              $foo = $row[0];
//            }        
//            return $foo;
//        }

        public function getQuantitySale2($code, $color, $dateA, $dateB) {
            $sql = "SELECT SUM(invtr.INVENCANTI) 
			FROM inventario invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM in ('S', 'A')
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
            OR invtr.INVENCODIG = '".$code."'
            AND invtr.INVENMOVIM = 'P'
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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
        

        public function getQuantityEsmerilada ($code, $color, $dateA, $dateB) {
            $sql = "SELECT SUM(invtr.INVENCANTI) 
			FROM inventario invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM in ('S', 'A')
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
            OR invtr.INVENCODIG = '".$code."'
            AND invtr.INVENMOVIM = 'P'
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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
        

        public function getQuantitySaleViscosa($code, $color, $dateA, $dateB) {
            $sql = "SELECT SUM(invtr.INVENCANTI) 
			FROM inventario invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM in ('S', 'A')
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
            OR invtr.INVENCODIG = '".$code."'
            AND invtr.INVENMOVIM = 'P'
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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


        public function getQuantitySaleRayas($code, $color, $dateA, $dateB) {
            $sql = "SELECT SUM(invtr.INVENCANTI) 
			FROM inventario invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM in ('S', 'A')
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
            OR invtr.INVENCODIG = '".$code."'
            AND invtr.INVENMOVIM = 'P'
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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
        

        public function getSalesAlgodon($color, $dateA, $dateB) {
            /*$sql = "SELECT SUM(remdecanti) CANTIDAD_KGS
			FROM remisdetal, color, inventario 
			WHERE remdecolor = colorcodig
			AND remdemovim is null
            AND invennombr like '%ALGODON%'
			AND remdeartic = invencodig
			--AND remdecolor = '".$color."'
			GROUP BY remdecolor, colornombr
			ORDER BY CANTIDAD_KGS desc";*/
			
			$sql = "SELECT SUM(remdecanti) CANTIDAD_KGS 
			FROM remisdetal 
			WHERE remdecolor = ".$color." 
			AND remdefecge BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')";
			
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = 0;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        
        // Obtiene el costo promedio de un articulo en el inventario
        public function getLastPriceSold($code, $color) {
            $sql = "SELECT invtr.INVENCOSTO FROM INVENTARIO invtr WHERE invtr.INVENFECMO = 
			(SELECT MAX( invtr.INVENFECMO ) FROM INVENTARIO invtr WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM = 'E')";

            //$sql = "SELECT avg(invtr.INVENCOSTO) FROM INVENTARIO invtr WHERE invtr.INVENCODIG = '".$code."'  AND invtr.INVENCOLOR = ".$color." AND invtr.INVENMOVIM = 'E'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }


        //obtiene el ultimo valor de venta ingresado en el inventario
        public function getLastPriceVenta($code, $color) {
            //query funcional temporalmente disabled para revisión
            //$sql = "SELECT invtr.INVENPREVE FROM INVENTARIO invtr WHERE invtr.INVENFECMO = ( SELECT MAX( invtr.INVENFECMO )  FROM INVENTARIO invtr WHERE invtr.INVENCODIG = '".$code."'  AND invtr.INVENCOLOR = ".$color." AND invtr.INVENMOVIM = 'E')";
            
            //query temporal 
            $sql = "SELECT invtr.INVENPREVE FROM INVENTARIO invtr WHERE invtr.INVENFECMO = 
			(SELECT MAX( invtr.INVENFECMO ) FROM INVENTARIO invtr WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM = 'E')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getCountArticleIn($dateA, $dateB, $code) {
            $sql = "SELECT SUM(invtr.INVENCANTI) 
			FROM INVENTARIO invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM = 'E'                        
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')
            OR invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM = 'D'                        
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getCountArticleOut($dateA, $dateB, $code) {
            $sql = "SELECT SUM(invtr.INVENCANTI) 
			FROM INVENTARIO invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM = 'S' 
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getCountArticleAnul($dateA, $dateB, $code) {
            $sql = "SELECT SUM(invtr.INVENCANTI) 
			FROM INVENTARIO invtr 
			WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM = 'A'
			AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getCountColorFromStock(Stock $objStock) {
            $sql = "SELECT COUNT(*) FROM inventario invtr WHERE invtr.INVENCOLOR = ".$objStock->getColor();
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