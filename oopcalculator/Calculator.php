<?php
require_once __DIR__ . '/operations/Addition.php';
require_once __DIR__ . '/operations/Subtraction.php';
require_once __DIR__ . '/operations/Multiplication.php';
require_once __DIR__ . '/operations/Division.php';

class Calculator {
    public function compute(string $operation, float $number1, float $number2): float {
        switch ($operation) {
            case '+':
                $op = new Addition($number1, $number2);
                break;
            case '-':
                $op = new Subtraction($number1, $number2);
                break;
            case '*':
                $op = new Multiplication($number1, $number2);
                break;
            case '/':
                if ($number2 == 0) {
                    throw new Exception("Cannot divide by zero.");
                }
                $op = new Division($number1, $number2);
                break;
            default:
                throw new Exception("Invalid operation.");
        }

        return $op->calculate();
    }
}
?>
