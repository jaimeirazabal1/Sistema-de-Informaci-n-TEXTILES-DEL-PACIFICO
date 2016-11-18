<?php
 
class Department
{
    private $code;
    
    public function setCode($val){
        $this->code = $val; 
    }
    
    public function getCode(){
        return $this->code;
    }
    
    private $name;
    
    public function setName($val){
        $this->name = $val;
    }
    
    public function getName(){
        return $this->name;
    }
}
?>