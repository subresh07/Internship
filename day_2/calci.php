<?php
session_start();

// Initialize the input if not already set
if (!isset($_SESSION['input'])) {
    $_SESSION['input'] = "";
}

if (isset($_POST['button'])) {
    $button = $_POST['button'];

    // Handle the button clicks
    if ($button == "=") {
        // Safe evaluation of the expression
        $expression = $_SESSION['input'];

        // Check if the expression contains only valid characters
        if (preg_match("/^[0-9+\-*\/\.\(\) ]+$/", $expression)) {
            // Evaluate the expression using a safe method
            try {
                $result = calculateExpression($expression);
                $_SESSION['input'] = $result; // Store the result
            } catch (Exception $e) {
                $_SESSION['input'] = "Error"; // Error handling
            }
        } else {
            $_SESSION['input'] = "Error"; // Invalid expression
        }
    } elseif ($button == "C") {
        // Clear the screen
        $_SESSION['input'] = "";
    } elseif ($button == "←") {
        // Backspace: remove the last character
        $_SESSION['input'] = substr($_SESSION['input'], 0, -1);
    } else {
        // Append the clicked button to the input string
        $_SESSION['input'] .= $button;
    }
}

// Get the current input or result to display
$display = $_SESSION['input'];

// Function to evaluate the expression safely
function calculateExpression($expression) {
    // Replace spaces to ensure consistent formatting
    $expression = str_replace(' ', '', $expression);

    // Check for any invalid characters in the expression
    if (preg_match('/[^0-9+\-*\/()\.]/', $expression)) {
        throw new Exception("Invalid characters in the expression.");
    }

    // Parse and evaluate the expression
    return evaluateMathExpression($expression);
}

// Function to parse and evaluate a mathematical expression
function evaluateMathExpression($expression) {
    // Convert infix to postfix using Shunting-yard algorithm
    $postfix = infixToPostfix($expression);

    // Evaluate the postfix expression
    return evaluatePostfix($postfix);
}

// Convert infix to postfix notation using the Shunting-yard algorithm
function infixToPostfix($expression) {
    $output = [];
    $operators = [];
    $precedence = [
        '+' => 1, '-' => 1,
        '*' => 2, '/' => 2,
        '(' => 0, ')' => 0
    ];

    // Tokenize the expression (handle multi-digit numbers)
    $tokens = [];
    $numberBuffer = '';
    for ($i = 0; $i < strlen($expression); $i++) {
        $char = $expression[$i];
        if (is_numeric($char) || $char == '.') {
            $numberBuffer .= $char; // Build multi-digit number
        } else {
            if ($numberBuffer !== '') {
                $tokens[] = $numberBuffer; // Add the complete number to tokens
                $numberBuffer = ''; // Reset buffer
            }
            $tokens[] = $char; // Add operator or parenthesis
        }
    }
    // Add the last number if buffer is not empty
    if ($numberBuffer !== '') {
        $tokens[] = $numberBuffer;
    }

    // Process tokens
    foreach ($tokens as $token) {
        if (is_numeric($token) || $token == '.') {
            $output[] = $token;
        } elseif (isset($precedence[$token])) {
            if ($token == '(') {
                $operators[] = $token;
            } elseif ($token == ')') {
                while (!empty($operators) && end($operators) != '(') {
                    $output[] = array_pop($operators);
                }
                array_pop($operators); // Remove '('
            } else {
                while (
                    !empty($operators) &&
                    $precedence[end($operators)] >= $precedence[$token]
                ) {
                    $output[] = array_pop($operators);
                }
                $operators[] = $token;
            }
        }
    }

    // Add remaining operators to the output
    while (!empty($operators)) {
        $output[] = array_pop($operators);
    }

    return $output;
}

// Evaluate postfix notation
function evaluatePostfix($postfix) {
    $stack = [];
    foreach ($postfix as $token) {
        if (is_numeric($token)) {
            $stack[] = $token;
        } else {
            $b = array_pop($stack);
            $a = array_pop($stack);
            switch ($token) {
                case '+':
                    $stack[] = $a + $b;
                    break;
                case '-':
                    $stack[] = $a - $b;
                    break;
                case '*':
                    $stack[] = $a * $b;
                    break;
                case '/':
                    if ($b == 0) {
                        throw new Exception("Division by zero.");
                    }
                    $stack[] = $a / $b;
                    break;
            }
        }
    }
    return array_pop($stack);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Calculator</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Calculator container */
        .calculator {
            background-color: #333;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);
            width: 300px;
        }

        /* Display input field */
        .calculator input[type="text"] {
            width: 100%;
            height: 50px;
            background-color: #222;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 24px;
            text-align: right;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        /* Button styling */
        .calculator button {
            width: 60px;
            height: 60px;
            background-color: #444;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 20px;
            margin: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Hover effect for buttons */
        .calculator button:hover {
            background-color: #555;
        }

        /* Special styling for operator buttons */
        .calculator button[value="/"],
        .calculator button[value="*"],
        .calculator button[value="-"],
        .calculator button[value="+"] {
            background-color: #ff9500;
        }

        .calculator button[value="/"]:hover,
        .calculator button[value="*"]:hover,
        .calculator button[value="-"]:hover,
        .calculator button[value="+"]:hover {
            background-color: #ffaa33;
        }

        /* Styling for the clear and backspace buttons */
        .calculator button[value="C"],
        .calculator button[value="←"] {
            background-color: #ff3b30;
        }

        .calculator button[value="C"]:hover,
        .calculator button[value="←"]:hover {
            background-color: #ff5e52;
        }

        /* Styling for the equals button */
        .calculator button[value="="] {
            background-color: #4cd964;
            width: 130px;
        }

        .calculator button[value="="]:hover {
            background-color: #5de576;
        }

        /* Styling for the zero button */
        .calculator button[value="0"] {
            width: 130px;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <form method="post">
            <!-- Display input field -->
            <input type="text" name="display" value="<?php echo htmlspecialchars($display); ?>" readonly>
            <br>
            <!-- Calculator buttons -->
            <button type="submit" name="button" value="7">7</button>
            <button type="submit" name="button" value="8">8</button>
            <button type="submit" name="button" value="9">9</button>
            <button type="submit" name="button" value="/">/</button>
            <br>
            <button type="submit" name="button" value="4">4</button>
            <button type="submit" name="button" value="5">5</button>
            <button type="submit" name="button" value="6">6</button>
            <button type="submit" name="button" value="*">*</button>
            <br>
            <button type="submit" name="button" value="1">1</button>
            <button type="submit" name="button" value="2">2</button>
            <button type="submit" name="button" value="3">3</button>
            <button type="submit" name="button" value="-">-</button>
            <br>
            <button type="submit" name="button" value="0">0</button>
            <button type="submit" name="button" value=".">.</button>
            <button type="submit" name="button" value="C">C</button>
            <button type="submit" name="button" value="+">+</button>
            <br>
            <button type="submit" name="button" value="←">←</button>
            <button type="submit" name="button" value="=">=</button>
        </form>
    </div>
</body>
</html>