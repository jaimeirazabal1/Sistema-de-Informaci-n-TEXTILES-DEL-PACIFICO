<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Client
 *
 * @author JuliánAndrés
 */
class DetailRemision {
    private $codeRemision;
    
    public function setCodeRemision($val){
        $this->codeRemision = $val;
    }
    
    public function  getCodeRemision(){
        return $this->codeRemision;
    }
    
    private $codeArticle;
    
    public function setCodeArticle($val){
        $this->codeArticle = strtoupper($val);
    }
    
    public function  getCodeArticle(){
        return $this->codeArticle;
    }
    
    private $quantity;
    
    public function setQuantity($val){
        $this->quantity = $val;
    }
    
    public function  getQuantity(){
        return $this->quantity;
    }
    
     private $valueUnit;
    
    public function setValueUnit($val){
        $this->valueUnit = $val;
    }
    
    public function  getValueUnit(){
        return $this->valueUnit;
    }
    
     private $total;
    
    public function setTotal($val){
        $this->total = $val;
    }
    
    public function  getTotal(){
        return $this->total;
    }
    
    private $moveDate;
    
    public function setMoveDate($val){
        $this->moveDate = $val;
    }
    
    public function  getMoveDate(){
        return $this->moveDate;
    }
    
    private $color;
    
    public function setColor($val){
        $this->color = $val;
    }
    
    public function  getColor(){
        return $this->color;
    }
    
    
    private $devolucion;
    
    public function getDevolucion(){
        return $this->devolucion;
    }

    public function setDevolucion($devolucion){
        $this->devolucion = $devolucion;
    }
    
    
}
