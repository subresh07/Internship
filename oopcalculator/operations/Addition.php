<?php
require_once __DIR__ . '/Operation.php';

class Addition extends Operation {
    public function calculate(): float {
        return $this->number1 + $this->number2;
    }
}
?>
