<?php
require_once "OperationStrategy.php";

class SquareRoot implements OperationStrategy {
    public function execute($a, $b = null) { // Only needs $a
        if ($a < 0) throw new Exception("Error: Cannot compute square root of a negative number");
        return sqrt($a);
    }
}
?>
