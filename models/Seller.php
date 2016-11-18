<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Seller
 *
 * @author JuliánAndrés
 */
class Seller {
    private $codeSeller;
    
    public function setCodeSeller($val){
        $this->codeSeller = $val;
    }
    
    public function  getCodeSeller(){
        return $this->codeSeller;
    }
    
    private $billRemision;
    
    public function setBillRemision($val){
        $this->billRemision = strtoupper($val);
    }
    
    public function  getBillRemision(){
        return $this->billRemision;
    }
    
    private $registrationDate;
    
    public function setRegistrationDate($val){
        $this->registrationDate = $val;
    }
    
    public function  getRegistrationDate(){
        return $this->registrationDate;
    }    
}
