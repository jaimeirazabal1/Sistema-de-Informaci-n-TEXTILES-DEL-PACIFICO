<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of System
 *
 * @author JuliánAndrés
 */
class System {
    private $code;
    
    public function setCode($val){
        $this->code = $val;
    }
    
    public function  getCode(){
        return $this->code;
    }
    
    private $name;
    
    public function setName($val){
        $this->name = strtoupper($val);
    }
    
    public function  getName(){
        return $this->name;
    }        
    
    private $value;
    
    public function setValue($val){
        $this->value = $val;
    }
    
    public function getValue(){
        return $this->value;
    }
    
    private $startDate;
    
    public function setStartDate($val){
        $this->startDate = $val;
    }
    
    public function getStartDate(){
        return $this->startDate;
    }
    
    private $finishDate;
    
    public function setFinishDate($val){
        $this->finishDate = $val;
    }
    
    public function getFinishDate(){
        return $this->finishDate;
    }
}
