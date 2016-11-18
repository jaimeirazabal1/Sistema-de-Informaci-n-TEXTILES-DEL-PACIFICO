<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Spend
 *
 * @author JuliánAndrés
 */
class Spend {
    private $code;
    
    public function setCode($val){
        $this->code = $val;
    }
    
    public function  getCode(){
        return $this->code;
    }
    
    private $codeClient;
    
    public function setCodeClient($val){
        $this->codeClient = strtoupper($val);
    }
    
    public function  getCodeClient(){
        return $this->codeClient;
    }    
    
    private $codeConcept;
    
    public function setCodeConcept($val){
        $this->codeConcept = strtoupper($val);
    }
    
    public function  getCodeConcept(){
        return $this->codeConcept;
    }
    
    private $value;
    
    public function setValue($val){
        $this->value = strtoupper($val);
    }
    
    public function  getValue(){
        return $this->value;
    }
        
    private $generationDate;
    
    public function setGenerationDate($val){
        $this->generationDate = $val;
    }
    
    public function  getGenerationDate(){
        return $this->generationDate;
    }
    
    private $user;
    
    public function setUser($val){
        $this->user = $val;
    }
    
    public function  getUser(){
        return $this->user;
    }
}
