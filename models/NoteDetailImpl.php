<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Desnteiption of NoteImpl
 *
 * @author JuliánAndrés
 */


if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/NoteDetail.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/NoteDetail.php');
}


class NoteDetailImpl
{	
    public function NoteDetailImpl()
    {

    }       

    public function insert(NoteDetail $objNoteDetail){
        $sql = "INSERT INTO notadetal VALUES (".$objNoteDetail->getCode ().",'".$objNoteDetail->getArticle()."',TO_DATE('".$objNoteDetail->getDate()."', 'yyyy/mm/dd hh24:mi:ss'),".$objNoteDetail->getQuantity().",".$objNoteDetail->getValorUnit().",".$objNoteDetail->getValorTotal().",".$objNoteDetail->getColor().",'".$objNoteDetail->getMove()."',".$objNoteDetail->getDevolucion().")";                                                
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);            
    }   
    
    public function getByCode($idNote)
    {
        $sql = "SELECT  ntd.*  FROM NOTADETAL ntd WHERE ntd.NOTACODIG = ".$idNote;
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo = array();
        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
            $objNoteDetail = new NoteDetail();
            $objNoteDetail->setCode($row[0]);
            $objNoteDetail->setArticle($row[1]);
            $objNoteDetail->setDate($row[2]);
            $objNoteDetail->setQuantity($row[3]);
            $objNoteDetail->setValorUnit($row[4]);
            $objNoteDetail->setValorTotal($row[5]);
            $objNoteDetail->setColor($row[6]);
            $objNoteDetail->setMove($row[7]);
            $objNoteDetail->setDevolucion($row[8]);

            $foo[] = $objNoteDetail;
        }
        return $foo;
    }
    
    public function getByCodeBetweenDate($dateA, $dateB, $ref, $typeNote)
    {
        $sql = "SELECT  ntd.*  FROM NOTADETAL ntd, NOTA nt WHERE UPPER(ntd.NOTAARTIC) = UPPER('".$ref."') AND ntd.NOTAFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND ntd.NOTACODIG = nt.NOTACODIG and nt.NOTATIPNO = '".$typeNote."'";
//        $sql = "SELECT * FROM CUENTPAGDE cxp WHERE UPPER(cxp.CUPADARTIC) = UPPER('".$ref."') AND cxp.CUPADFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')";
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo = array();
        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
            $objNoteDetail = new NoteDetail();
            $objNoteDetail->setCode($row[0]);
            $objNoteDetail->setArticle($row[1]);
            $objNoteDetail->setDate($row[2]);
            $objNoteDetail->setQuantity($row[3]);
            $objNoteDetail->setValorUnit($row[4]);
            $objNoteDetail->setValorTotal($row[5]);
            $objNoteDetail->setColor($row[6]);
            $objNoteDetail->setMove($row[7]);
            $objNoteDetail->setDevolucion($row[8]);

            $foo[] = $objNoteDetail;
        }
        return $foo;
    }
    
   
    
}