<?php
class OperationFactory {
    public static function create($operator) {
        switch ($operator) {
            case '+':
                return new Addition();
            case '-':
                return new Subtraction();
            case '*':
                return new Multiplication();
            case '/':
                return new Division();
            case '^':
                return new Power();
            case '√':
                return new SquareRoot();
            case '!':
                return new Factorial();
            default:
                throw new Exception("Unknown operation: " . $operator);
        }
    }
}
?>
