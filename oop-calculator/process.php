<?php
session_start();
require_once "classes/Calculator.php";

$calculator = Calculator::getInstance();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['button'])) {
    $button = $_POST['button'];

    // Ensure only valid characters are processed
    if ($button === "=") {
        $_SESSION['result'] = $calculator->evaluate();
    } elseif ($button === "C") {
        $calculator->clear();
    } elseif ($button === "CE") {
        $calculator->backspace();
    } elseif (preg_match('/^[0-9+\-\*\/\(\)\.\^√!]$/', $button)) { 
        $calculator->appendToOperation($button);
    } else {
        $_SESSION['error'] = "Invalid input!";
    }

    $calculator->saveToSession();
    
  
    header("Location: index.php");
    exit; 
}
?>
