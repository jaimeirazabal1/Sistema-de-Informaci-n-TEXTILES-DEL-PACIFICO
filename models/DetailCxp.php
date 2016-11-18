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
class DetailCxp{
    private $codeCxp;
    private $codeArticle;
    private $fechaCreacion;
    private $cantidad;
    private $valorUnitario;
    private $total;
    private $color;
    
   
    public function getCodeCxp(){
            return $this->codeCxp;
    }

    public function setCodeCxp($codeCxp){
            $this->codeCxp = $codeCxp;
    }

    public function getCodeArticle(){
            return $this->codeArticle;
    }

    public function setCodeArticle($codeArticle){
            $this->codeArticle = $codeArticle;
    }

    public function getFechaCreacion(){
            return $this->fechaCreacion;
    }

    public function setFechaCreacion($fechaCreacion){
            $this->fechaCreacion = $fechaCreacion;
    }

    public function getCantidad(){
            return $this->cantidad;
    }

    public function setCantidad($cantidad){
            $this->cantidad = $cantidad;
    }

    public function getValorUnitario(){
            return $this->valorUnitario;
    }

    public function setValorUnitario($valorUnitario){
            $this->valorUnitario = $valorUnitario;
    }

    public function getTotal(){
            return $this->total;
    }

    public function setTotal($total){
            $this->total = $total;
    }
    
    public function getColor(){
            return $this->color;
    }

    public function setColor($color){
            $this->color = $color;
    }
    
    private $devolucion;
    
    public function getDevolucion(){
        return $this->devolucion;
    }

    public function setDevolucion($devolucion){
        $this->devolucion = $devolucion;
    }
}
