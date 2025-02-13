<?php
require_once 'Operation.php';

class Subtraction extends Operation 
{
    public function calculate() {
        return $this->num1 - $this->num2;
    }
}
?>
