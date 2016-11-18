<?php

class NoteDetail {
    private $code;
    
    public function setCode($val){
        $this->code = strtoupper($val);
    }
    
    public function getCode(){
        return $this->code;
    }
    
    private $article;
    
    public function setArticle($val){
        $this->article = ($val);
    }
    
    public function getArticle(){
        return $this->article;
    }

    private $date;
    
    public function setDate($val){
        $this->date = $val;
    }
    
    public function getDate(){
        return $this->date;
    }
    
    private $quantity;
    
    public function setQuantity($val){
        $this->quantity = $val;
    }
    
    public function getQuantity(){
        return $this->quantity;
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
    
    private $color;
    
    public function setColor($val){
        $this->color = $val;
    }
    
    public function getColor(){
        return $this->color;
    }

    private $move;
    
    public function setMove($val){
        $this->move = strtoupper($val);
    }
    
    public function getMove(){
        return $this->move;
    }
    
    private $devolucion;
    
    public function setDevolucion($val){
        $this->devolucion = $val;
    }
    
    public function getDevolucion(){
        return $this->devolucion;
    }
}
