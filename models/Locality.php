<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of City
 *
 * @author JuliánAndrés
 */
class Locality {
    private $code;
    
    public function setCode($val){
        $this->code = $val;
    }
    
    public function getCode(){
        return $this->code;
    } 
    
    private $codeDepartment;
    
    public function setCodeDepartment($val){
        $this->codeDepartment = $val;
    }
    
    public function getCodeDepartment(){
        return $this->codeDepartment;
    }
    
    private $name;
    
    public function setName($val){
        $this->name = $val;
    }
    
    public function getName(){
        return $this->name;
    }
}
