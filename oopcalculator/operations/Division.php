<?php
require_once __DIR__ . '/Operation.php';

class Division extends Operation {
    public function calculate(): float {
        if ($this->number2 == 0) {
            throw new Exception("Cannot divide by zero.");
        }
        return $this->number1 / $this->number2;
    }
}
?>
