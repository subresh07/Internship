<?php
require_once 'Operation.php';

class Division extends Operation
 {
    public function calculate()
     {
        if ($this->num2 == 0) 
        {
            return "Error: Division by zero!";
        }
        return $this->num1 / $this->num2;
    }
}
?>
