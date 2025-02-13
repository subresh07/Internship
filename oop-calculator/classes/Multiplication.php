<?php
require_once "OperationStrategy.php";

class Multiplication implements OperationStrategy {
    public function execute($a, $b = null) {
        return $a * $b;
    }
}
?>
