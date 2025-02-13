<?php
require_once 'Operation.php';

class Addition extends Operation
 {
    public function calculate() 
    {
        return $this->num1 + $this->num2;
    }
}
?>
