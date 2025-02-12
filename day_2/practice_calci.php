<?php
session_start();

// Initialize memory if not already set
if (!isset($_SESSION['memory'])) {
    $_SESSION['memory'] = 0;
}

// Initialize input field if not set
if (!isset($_SESSION['currentInput'])) {
    $_SESSION['currentInput'] = '';
}

// Handle button presses
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Append value for number or operator buttons
    if (isset($_POST['append'])) {
        $_SESSION['currentInput'] .= $_POST['append'];
    }

    // Perform calculation when '=' is pressed
    if (isset($_POST['calculate'])) {
        $result = evaluateExpression($_SESSION['currentInput']);
        if ($result !== 'Error') {
            $_SESSION['currentInput'] = $result;
        } else {
            $_SESSION['currentInput'] = 'Error';
        }
    }

    // Handle memory operations
    if (isset($_POST['memoryClear'])) {
        $_SESSION['memory'] = 0;
        $_SESSION['currentInput'] = ''; // Clear input after memory clear
    }

    if (isset($_POST['memoryRecall'])) {
        $_SESSION['currentInput'] = $_SESSION['memory']; // Display memory in the input
    }

    if (isset($_POST['memoryStore'])) {
        $_SESSION['memory'] = $_SESSION['currentInput'];
        $_SESSION['currentInput'] = ''; // Clear the input field after storing in memory
    }

    if (isset($_POST['memoryAdd'])) {
        $_SESSION['memory'] += $_SESSION['currentInput'];
        $_SESSION['currentInput'] = $_SESSION['memory']; // Update input with new memory value
    }

    if (isset($_POST['memorySubtract'])) {
        $_SESSION['memory'] -= $_SESSION['currentInput'];
        $_SESSION['currentInput'] = $_SESSION['memory']; // Update input with new memory value
    }

    // Clear the input field
    if (isset($_POST['clear'])) {
        $_SESSION['currentInput'] = '';
    }

    // Allow decimal point (.) only once per number
    if (isset($_POST['decimal'])) {
        // Check if the current number already has a decimal point
        if (strpos($_SESSION['currentInput'], '.') === false) {
            $_SESSION['currentInput'] .= '.';
        }
    }
}

// Default value for input field
$currentInput = $_SESSION['currentInput'];

// Function to evaluate mathematical expression without using eval
function evaluateExpression($expression) {
    // Strip spaces from the expression
    $expression = str_replace(' ', '', $expression);

    // Match numbers and operators
    preg_match_all('/(\d+\.\d+|\d+|[+\-*\/()])/i', $expression, $matches);
    $tokens = $matches[0];

    $operands = [];
    $operators = [];

    // Define the precedence of operators
    $precedence = [
        '+' => 1,
        '-' => 1,
        '*' => 2,
        '/' => 2
    ];

    // Function to apply an operator to the operands
    function applyOperator(&$operators, &$operands) {
        $operator = array_pop($operators);
        $right = array_pop($operands);
        $left = array_pop($operands);

        switch ($operator) {
            case '+':
                $operands[] = $left + $right;
                break;
            case '-':
                $operands[] = $left - $right;
                break;
            case '*':
                $operands[] = $left * $right;
                break;
            case '/':
                if ($right == 0) {
                    return 'Error'; // Avoid division by zero
                }
                $operands[] = $left / $right;
                break;
        }
    }

    // Function to evaluate the expression using a simple Shunting Yard Algorithm
    foreach ($tokens as $token) {
        if (is_numeric($token)) {
            $operands[] = (float)$token;
        } elseif (in_array($token, ['+', '-', '*', '/'])) {
            while (!empty($operators) && $precedence[end($operators)] >= $precedence[$token]) {
                applyOperator($operators, $operands);
            }
            $operators[] = $token;
        } elseif ($token == '(') {
            $operators[] = $token;
        } elseif ($token == ')') {
            while (end($operators) != '(') {
                applyOperator($operators, $operands);
            }
            array_pop($operators); // Pop the '('
        }
    }

    // Apply remaining operators
    while (!empty($operators)) {
        applyOperator($operators, $operands);
    }

    // Return the result of the evaluation
    return isset($operands[0]) ? $operands[0] : 'Error';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Calculator with Memory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        .calculator {
            max-width: 200px;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .calculator input, .calculator button {
            font-size: 20px;
            padding: 10px;
            text-align: center;
            border: none;
            background-color: #f1f1f1;
            border-radius: 5px;
        }
        .calculator input {
            grid-column: span 4;
            background-color: #fff;
            border: 1px solid #ccc;
        }
        .calculator button {
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .calculator button:hover {
            background-color: #ddd;
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <h1>Calculator</h1>

    <form method="POST">
        <div class="calculator">
            <input type="text" name="currentInput" value="<?= htmlspecialchars($currentInput) ?>" readonly />
            
            <!-- Number and operator buttons -->
            <button type="submit" name="append" value="1">1</button>
            <button type="submit" name="append" value="2">2</button>
            <button type="submit" name="append" value="3">3</button>
            <button type="submit" name="append" value="+">+</button>

            <button type="submit" name="append" value="4">4</button>
            <button type="submit" name="append" value="5">5</button>
            <button type="submit" name="append" value="6">6</button>
            <button type="submit" name="append" value="-">-</button>

            <button type="submit" name="append" value="7">7</button>
            <button type="submit" name="append" value="8">8</button>
            <button type="submit" name="append" value="9">9</button>
            <button type="submit" name="append" value="*">*</button>

            <button type="submit" name="append" value="0">0</button>
            <button type="submit" name="append" value="/">/</button>
            
            <!-- Decimal button for floating-point numbers -->
            <button type="submit" name="decimal">.</button>

            <button type="submit" name="clear">C</button>

            <!-- Memory Buttons -->
            <button type="submit" name="memoryStore">MS</button>
            <button type="submit" name="memoryRecall">MR</button>
            <button type="submit" name="memoryClear">MC</button>
            <button type="submit" name="memoryAdd">M+</button>
            <button type="submit" name="memorySubtract">M-</button>
            <button type="submit" name="calculate">=</button>
        </div>
    </form>
</body>
</html>

