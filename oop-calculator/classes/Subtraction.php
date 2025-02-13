<?php
require_once "OperationStrategy.php";

class Subtraction implements OperationStrategy {
    public function execute($a, $b = null) {
        return $a - $b;
    }
}
?>
