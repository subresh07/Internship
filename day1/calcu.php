<?php
// Initialize result variable
$result = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user inputs
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operation = $_POST['operation'];

    // Perform calculation based on operation
    if (is_numeric($num1) && is_numeric($num2)) {
        switch ($operation) {
            case 'add':
                $result = $num1 + $num2;
                break;
            case 'subtract':
                $result = $num1 - $num2;
                break;
            case 'multiply':
                $result = $num1 * $num2;
                break;
            case 'divide':
                if ($num2 != 0) {
                    $result = $num1 / $num2;
                } else {
                    $result = "Cannot divide by zero";
                }
                break;
            default:
                $result = "Invalid operation";
                break;
        }
    } else {
        $result = "Please enter valid numbers.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Calculator</title>
</head>
<body>

<h2>PHP Interactive Calculator</h2>

<!-- Simple HTML Form for input -->
<form method="POST">
    <label for="num1">First Number:</label>
    <input type="number" id="num1" name="num1" value="<?php echo isset($_POST['num1']) ? $_POST['num1'] : ''; ?>" required><br><br>

    <label for="num2">Second Number:</label>
    <input type="number" id="num2" name="num2" value="<?php echo isset($_POST['num2']) ? $_POST['num2'] : ''; ?>" required><br><br>

    <label for="operation">Operation:</label>
    <select id="operation" name="operation" required>
        <option value="add" <?php echo isset($_POST['operation']) && $_POST['operation'] == 'add' ? 'selected' : ''; ?>>Add</option>
        <option value="subtract" <?php echo isset($_POST['operation']) && $_POST['operation'] == 'subtract' ? 'selected' : ''; ?>>Subtract</option>
        <option value="multiply" <?php echo isset($_POST['operation']) && $_POST['operation'] == 'multiply' ? 'selected' : ''; ?>>Multiply</option>
        <option value="divide" <?php echo isset($_POST['operation']) && $_POST['operation'] == 'divide' ? 'selected' : ''; ?>>Divide</option>
    </select><br><br>

    <input type="submit" value="Calculate">
</form>

<!-- Display result after calculation -->
<div>
    <?php
    if (isset($result)) {
        echo "Result: " . $result;
    }
    ?>
</div>

</body>
</html>
