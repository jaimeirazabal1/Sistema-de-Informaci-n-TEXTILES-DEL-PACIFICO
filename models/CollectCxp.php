<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CollectCxp
 *
 * @author JuliánAndrés
 */
class CollectCxp {
    private $code;
    
    public function setCode($val){
        $this->code = $val;
    }
    
    public function  getCode(){
        return $this->code;
    }
    
    private $codeCxp;
    
    public function setCodeCxp($val){
        $this->codeCxp = $val;
    }
    
    public function  getCodeCxp(){
        return $this->codeCxp;
    }
    
    private $codeConcept;
    
    public function setCodeConcept($val){
        $this->codeConcept = $val;
    }
    
    public function  getCodeConcept(){
        return $this->codeConcept;
    }
    
    private $value;
    
    public function setValue($val){
        $this->value = $val;
    }
    
    public function  getValue(){
        return $this->value;
    }
    
    private $observation;
    
    public function setObservation($val){
        $this->observation = strtoupper($val);
    }
    
    public function getObservation()
    {
        return $this->observation;
    }
    
    
    private $registrationDate;
    
    public function setRegistrationDate($val){
        $this->registrationDate = $val;
    }
    
    public function  getRegistrationDate(){
        return $this->registrationDate;
    }
        
    public function setUser($val){
        $this->user = $val;
    }
    
    public function  getUser(){
        return $this->user;
    }
    
    private $typePay;
    
    public function setTypePay($val){
        $this->typePay = $val;
    }
    
    public function getTypePay()
    {
        return $this->typePay;
    }
    
}
    
    
    
    
    
