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
class Stock {
    private $code;
    
    public function setCode($val){
        $this->code = strtoupper($val);
    }
    
    public function getCode(){
        return $this->code;
    }
    
    private $Remision;
    
    public function setRemision($val){
        $this->Remision = ($val);
    }
    
    public function getRemision(){
        return $this->Remision;
    }

	
    private $Cliente;
    
    public function setCliente($val){
        $this->Cliente = ($val);
    }
    
    public function getCliente(){
        return $this->Cliente;
    }


    private $ValorUnit;
    
    public function setValorUnit($val){
        $this->ValorUnit = ($val);
    }
    
    public function getValorUnit(){
        return $this->ValorUnit;
    }

	
    private $ValorTotal;
    
    public function setValorTotal($val){
        $this->ValorTotal = ($val);
    }
    
    public function getValorTotal(){
        return $this->ValorTotal;
    }


    private $name;
    
    public function setName($val){
        $this->name = strtoupper($val);
    }
    
    public function getName(){
        return $this->name;
    }

    
    private $detalle;
    
    public function setDetalle($val){
        $this->detalle = strtoupper($val);
    }
    
    public function getDetalle(){
        return $this->detalle;
    }
    

    private $move;
    
    public function setMove($val){
        $this->move = strtoupper($val);
    }
    
    public function getMove(){
        return $this->move;
    }
    
    private $quantity;
    
    public function setQuantity($val){
        $this->quantity = $val;
    }
    
    public function getQuantity(){
        return $this->quantity;
    }
    
    private $priceBuy;
    
    public function setPriceBuy($val){
        $this->priceBuy = $val;
    }
    
    public function getPriceBuy(){
        return $this->priceBuy;
    }
    
    private $priceSold;
    
    public function setPriceSold($val){
        $this->priceSold = $val;
    }
    
    public function getPriceSold(){
        return $this->priceSold;
    }
    
    private $color;
    
    public function setColor($val){
        $this->color = $val;
    }
    
    public function getColor(){
        return $this->color;
    }
    
    private $moveDate;
    
    public function setMoveDate($val){
        $this->moveDate = $val;
    }
    
    public function getMoveDate(){
        return $this->moveDate;
    }
    
    private $user;
    
    public function setUser($val){
        $this->user = $val;
    }
    
    public function getUser(){
        return $this->user;
    }
}
