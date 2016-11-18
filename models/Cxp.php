<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cxp
 *
 * @author JuliánAndrés
 */
class Cxp {
    private $code;
    private $proveedor;
    private $fechaCreacion;
    private $fechaVencimiento;
    private $estado;
    private $origen;
    private $totalCuenta;
    private $saldoCuenta;
    private $iva;
    private $saldoIva;
    private $valorReteICA;
    private $SaldoReteICA;
    private $valorReteTimbre;
    private $saldoReteTimbre;
    private $usuario;
    private $typePay;
    
    
    
    public function getCode(){
            return $this->code;
    }

    public function setCode($code){
            $this->code = $code;
    }

    public function getProveedor(){
            return $this->proveedor;
    }

    public function setProveedor($proveedor){
            $this->proveedor = $proveedor;
    }

    public function getFechaCreacion(){
            return $this->fechaCreacion;
    }

    public function setFechaCreacion($fechaCreacion){
            $this->fechaCreacion = $fechaCreacion;
    }

    public function getFechaVencimiento(){
            return $this->fechaVencimiento;
    }

    public function setFechaVencimiento($fechaVencimiento){
            $this->fechaVencimiento = $fechaVencimiento;
    }

    public function getEstado(){
            return $this->estado;
    }

    public function setEstado($estado){
            $this->estado = $estado;
    }

    public function getOrigen(){
            return $this->origen;
    }

    public function setOrigen($origen){
            $this->origen = $origen;
    }

    public function getTotalCuenta(){
            return $this->totalCuenta;
    }

    public function setTotalCuenta($totalCuenta){
            $this->totalCuenta = $totalCuenta;
    }

    public function getSaldoCuenta(){
            return $this->saldoCuenta;
    }

    public function setSaldoCuenta($saldoCuenta){
            $this->saldoCuenta = $saldoCuenta;
    }

    public function getIva(){
            return $this->iva;
    }

    public function setIva($iva){
            $this->iva = $iva;
    }

    public function getSaldoIva(){
            return $this->saldoIva;
    }

    public function setSaldoIva($saldoIva){
            $this->saldoIva = $saldoIva;
    }

    public function getValorReteICA(){
            return $this->valorReteICA;
    }

    public function setValorReteICA($valorReteICA){
            $this->valorReteICA = $valorReteICA;
    }

    public function getSaldoReteICA(){
            return $this->SaldoReteICA;
    }

    public function setSaldoReteICA($SaldoReteICA){
            $this->SaldoReteICA = $SaldoReteICA;
    }

    public function getValorReteTimbre(){
            return $this->valorReteTimbre;
    }

    public function setValorReteTimbre($valorReteTimbre){
            $this->valorReteTimbre = $valorReteTimbre;
    }

    public function getSaldoReteTimbre(){
            return $this->saldoReteTimbre;
    }

    public function setSaldoReteTimbre($saldoReteTimbre){
            $this->saldoReteTimbre = $saldoReteTimbre;
    }

    public function getUsuario(){
            return $this->usuario;
    }

    public function setUsuario($usuario){
            $this->usuario = $usuario;
    }
        
    public function setTypePay($val){
        $this->typePay = $val;
    }
    
    public function getTypePay()
    {
        return $this->typePay;
    }
    
}
