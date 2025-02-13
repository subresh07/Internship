<?php
require_once "OperationStrategy.php";

class Addition implements OperationStrategy {
    public function execute($a, $b = null) { 
        return $a + $b;
    }
}
?>
