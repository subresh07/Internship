<?php
$currentvalue = "";
$input = [];

// Function to handle form submission
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $input = isset($_POST['input']) ? json_decode($_POST['input'], true) : [];

    // Check for button presses
    if (isset($_POST['button'])) {
        $button = $_POST['button']; // Get the pressed button value
        
        // Handle the "=" button (calculate result)
        if ($button == "=") {
            $currentvalue = calculateResult($input);
            $input = []; // Optionally reset input after calculation
        }
        // Handle other button presses (numbers, operators)
        elseif ($button == "C") {
            $input = []; // Clear the input
            $currentvalue = "";
        } elseif ($button == "CE") {
            array_pop($input); // Remove the last entry
        } else {
            $input[] = $button; // Add button value to input array
        }
    }
}

// Function to display the input as a string
function getInputAsString($values) {
    return implode("", $values);
}

// Function to calculate the result of the expression
function calculateResult($input) {
    $expression = implode("", $input);
    return evaluateExpression($expression); // Call the function to evaluate
}

// Function to evaluate the expression without using eval()
function evaluateExpression($expression) {
    // Remove spaces from the expression
    $expression = str_replace(" ", "", $expression);

    // Step 1: Handle Parentheses - Evaluate inside parentheses first
    while (preg_match("/\([^\(\)]+\)/", $expression)) {
        $expression = preg_replace_callback("/\([^\(\)]+\)/", function($matches) {
            return evaluateExpression(substr($matches[0], 1, -1)); // Recursively evaluate inside parentheses
        }, $expression);
    }

    // Step 2: Evaluate Multiplication and Division first (left to right)
    $expression = evaluateOperation($expression, ['*', '/']);

    // Step 3: Evaluate Addition and Subtraction (left to right)
    $expression = evaluateOperation($expression, ['+', '-']);

    return $expression;
}

// Function to evaluate the expression based on the given operators
function evaluateOperation($expression, $operators) {
    foreach ($operators as $operator) {
        // Corrected the regular expression to properly match the operator and avoid the "Unknown modifier" error
        // This regex will now work for all operators correctly
        $pattern = "/(\d+(\.\d{1,2})?|\.\d+)$operator(\d+(\.\d{1,2})?|\.\d+)/"; // Match numbers with at most 2 decimal places

        preg_match_all($pattern, $expression, $matches);

        // Check if any matches were found
        if (isset($matches[0])) {
            foreach ($matches[0] as $match) {
                // Perform operation on matched numbers
                $parts = explode($operator, $match);
                $left = floatval($parts[0]);
                $right = floatval($parts[1]);

                // Perform the operation
                if ($operator == '+') {
                    $result = $left + $right;
                } elseif ($operator == '-') {
                    $result = $left - $right;
                } elseif ($operator == '*') {
                    $result = $left * $right;
                } elseif ($operator == '/') {
                    if ($right == 0) {
                        return "Error: Division by Zero"; // Prevent division by zero
                    }
                    $result = $left / $right;
                }

                // Replace the matched operation in the expression with the result
                $expression = str_replace($match, number_format($result, 2), $expression);
            }
        }
    }

    return $expression; // Return the updated expression after the operation
}
?>

<!-- HTML form for the calculator -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP Calculator</title>
</head>
<body>
    <h3>Simple Calculator</h3>
    <div style="border: 1px solid; padding: 10px; display: inline-block;">
        <form method="post">
            <input type="hidden" name="input" value='<?php echo json_encode($input); ?>' />
            <p style="padding: 3px; margin: 0; min-height: 20px;">
                <?php echo getInputAsString($input); ?>
            </p>
            <input type="text" value="<?php echo htmlspecialchars($currentvalue); ?>" readonly />

            <!-- Calculator buttons -->
            <?php
            $buttons = [
                'C' => 'C', 'CE' => 'CE', 'Back' => '←', '/' => '/', 
                '7' => '7', '8' => '8', '9' => '9', '*' => 'X', 
                '4' => '4', '5' => '5', '6' => '6', '-' => '-', 
                '1' => '1', '2' => '2', '3' => '3', '+' => '+', 
                'plusminus' => '±', '0' => '0', '.' => '.', '=' => '='
            ];
            
            // Loop through each button and create the button HTML
            foreach ($buttons as $name => $label) {
                echo "<button type='submit' name='button' value='{$name}'>{$label}</button>";
                if (in_array($name, ['/', 'X', '-', '+'])) {
                    echo "<br>"; // Add line break for operators
                }
            }
            ?>
        </form>
    </div>
</body>
</html>
