<?php
session_start();
require_once __DIR__ . '/Calculator.php';

if (!isset($_SESSION['expression'])) {
    $_SESSION['expression'] = '';
}
if (!isset($_SESSION['memory'])) {
    $_SESSION['memory'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button'])) {
    $button = $_POST['button'];

    switch ($button) {
        case 'C': // Clear all
            $_SESSION['expression'] = '';
            break;

        case 'CE': // Clear last entry
        
            $_SESSION['expression'] = substr($_SESSION['expression'], 0, -1);
            break;

        case '=': // Evaluate expression
            try {
                preg_match('/(\d+\.?\d*)([+\-*\/])(\d+\.?\d*)/', $_SESSION['expression'], $matches);
                if (count($matches) === 4) {
                    $number1 = floatval($matches[1]);
                    $operator = $matches[2];
                    $number2 = floatval($matches[3]);

                    $calculator = new Calculator();
                    $_SESSION['expression'] = $calculator->compute($operator, $number1, $number2);
                } else {
                    $_SESSION['expression'] = 'Error';
                }
            } catch (Exception $e) {
                $_SESSION['expression'] = 'Error';
            }
            break;

        case 'M+': // Add to memory
            $_SESSION['memory'] += floatval($_SESSION['expression']);
            break;

        case 'M-': // Subtract from memory
            $_SESSION['memory'] -= floatval($_SESSION['expression']);
            break;

        case 'MR': // Recall memory
            $_SESSION['expression'] = $_SESSION['memory'];
            break;

        case 'MC': // Clear memory
            $_SESSION['memory'] = 0;
            break;

        case '±': // Toggle sign
            if (!empty($_SESSION['expression']) && is_numeric($_SESSION['expression'])) {
                $_SESSION['expression'] = -1 * floatval($_SESSION['expression']);
            }
            break;

        default: // Add numbers and operators
            $_SESSION['expression'] .= $button;
            break;
    }
}

header("Location: index.php");
exit();
?>
