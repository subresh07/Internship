<?php
abstract class Operation {
    protected float $number1;
    protected float $number2;

    public function __construct(float $number1, float $number2) {
        $this->number1 = $number1;
        $this->number2 = $number2;
    }

    abstract public function calculate(): float;
}
?>
