<?php
require_once "OperationStrategy.php";

class Exponentiation implements OperationStrategy {
    public function execute($a, $b = null) {
        return pow($a, $b);
    }
}
?>
