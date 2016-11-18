<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Note
 *
 * @author JuliánAndrés
 */
class Note {
    private $code;
    
    public function setCode($val){
        $this->code = $val;
    }
    
    public function  getCode(){
        return $this->code;
    }
    
    private $codeBill;
    
    public function setCodeBill($val){
        $this->codeBill = $val;
    }
    
    public function  getCodeBill(){
        return $this->codeBill;
    }
    
    private $registrationDate;
    
    public function setRegistrationDate($val){
        $this->registrationDate = $val;
    }
    
    public function  getRegistrationDate(){
        return $this->registrationDate;
    }
    
    private $typeNote;
    
    public function setTypeNote($val){
        $this->typeNote = $val;
    }
    
    public function getTypeNote(){
        return $this->typeNote;
    }
    
    private $value;
    
    public function setValue($val){
        $this->value = $val;
    }
    
    public function  getValue(){
        return $this->value;
    }
    
    private $valueIva;
    
    public function setValueIva($val){
        $this->valueIva = $val;
    }
    
    public function getValueIva(){
        return $this->valueIva;
    }
    
    private $observation;
    
    public function setObservation($val){
        $this->observation = strtoupper($val);
    }
    
    public function getObservation()
    {
        return $this->observation;
    }
    
    private $user;

    public function setUser($val){
        $this->user = $val;
    }
    
    public function  getUser(){
        return $this->user;
    }
    
}
    
    
    
    
    
