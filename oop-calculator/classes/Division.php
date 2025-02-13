<?php
require_once "OperationStrategy.php";

class Division implements OperationStrategy {
    public function execute($a, $b = null) {
        if ($b == 0) throw new Exception("Error: Division by zero");
        return $a / $b;
    }
}
?>
