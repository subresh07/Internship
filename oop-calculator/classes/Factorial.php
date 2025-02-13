<?php
require_once "OperationStrategy.php";

class Factorial implements OperationStrategy {
    public function execute($a, $b = null) { // Only needs $a
        if ($a < 0 || floor($a) != $a) throw new Exception("Error: Factorial requires a non-negative integer");
        return gmp_intval(gmp_fact($a));
    }
}
?>
