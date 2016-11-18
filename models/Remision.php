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
class Remision {
    private $code;
    
    public function setCode($val){
        $this->code = $val;
    }
    
    public function  getCode(){
        return $this->code;
    }
    
    private $client;
    
    public function setClient($val){
        $this->client = $val;
    }
    
    public function  getClient(){
        return $this->client;
    }
    
    private $generationDate;
    
    public function setGenerationDate($val){
        $this->generationDate = $val;
    }
    
    public function  getGenerationDate(){
        return $this->generationDate;
    }
    
    private $valueSale;
    
    public function setValueSale($val){
        $this->valueSale = $val;
    }
    
    public function  getValueSale(){
        return $this->valueSale;
    }
    
    private $valueBuy;
    
    public function setValueIVA($val){
        $this->valueBuy = $val;
    }
    
    public function  getValueIVA(){
        return $this->valueBuy;
    }
    
    private $payment;
    
    public function setPayment($val){
        $this->payment = strtoupper($val);
    }
    
    public function  getPayment(){
        return $this->payment;
    }
    
    private $user;
    
    public function setUser($val){
        $this->user = $val;
    }
    
    public function  getUser(){
        return $this->user;
    }
    
    private $state;
    
    public function setState($val){
        $this->state = strtoupper($val);
    }
    
    public function  getState(){
        return $this->state;
    }
    
    private $observation;
    
    public function setObservation($val){
        $this->observation = $val;
    }
    
    public function getObservation(){
        return $this->observation;
    }
    
    
}
