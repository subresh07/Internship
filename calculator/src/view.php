<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button'])) {
    handleButtonPress($_POST['button']);
}

$input = $_SESSION['input'];
$result = $_SESSION['result'];
$expression = $_SESSION['expression'];
$memory = $_SESSION['memory'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP Calculator</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; padding: 20px; }
        .calculator { display: inline-block; padding: 15px; background: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .display { text-align: right; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 10px; background: #eaeaea; min-height: 50px; }
        .operation { font-size: 24px; color: #333; }
        .result { font-size: 32px; font-weight: bold; color: #000; margin-top: 5px; }
        button { font-size: 18px; padding: 15px; margin: 2px; border: none; cursor: pointer; background-color: #f1f1f1; border-radius: 5px; }
        button:hover { background-color: #ddd; }
    </style>
</head>
<body>
    <h1>Calculator</h1>
    <form method="POST">
        <div class="calculator">
            <div class="display">
                <div class="operation"><?php echo $expression !== '' ? getInputAsString($expression) : getInputAsString($input); ?></div>
                <?php if ($result !== '' && is_numeric($result)): ?>
                    <div class="result"><?php echo $result; ?></div>
                <?php endif; ?>
            </div>
            <div>
                <?php
                $buttons = [
                    ['C', 'CE', 'Back', 'MC'],
                    ['7', '8', '9', '/'],
                    ['4', '5', '6', '*'],
                    ['1', '2', '3', '-'],
                    ['±', '0', '.', '+'],
                    ['M+', 'M-', 'MR', '=']
                ];

                foreach ($buttons as $row) {
                    echo "<div>";
                    foreach ($row as $button) {
                        echo "<button type='submit' name='button' value='$button'>$button</button>";
                    }
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </form>
</body>
</html>
