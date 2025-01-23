<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expenses Tracker</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:rgb(223, 218, 218); margin: 0; padding: 20px;">
<?php
    // Initialize variables
    $total_expenses = 0;
    $average_expense = 0;
    $max_expense = 0;
    $min_expense = 0;
    $day_max = 0;
    $day_min = 0;

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $expenses = [];

        // Loop through 7 days
        for ($day = 1; $day <= 7; $day++) {
            // Get the expense for the current day (day 1 to day 7)
            $expense_key = "expense_day_" . $day;
            $expenses[$day] = isset($_POST[$expense_key]) ? floatval($_POST[$expense_key]) : 0;
        }

        // Calculate total expenses
        $total_expenses = array_sum($expenses);

        // Calculate average daily expense
        $average_expense = $total_expenses / 7;

        // Find the highest and lowest expenses
        $max_expense = max($expenses);
        $min_expense = min($expenses);

        // Find the day with the highest and lowest expense
        $day_max = array_search($max_expense, $expenses) + 1; // Adding 1 to make days human-readable
        $day_min = array_search($min_expense, $expenses) + 1 ; // Adding 1 to make days human-readable
    }
?>
    <h1 style="text-align: center; color: #333;">Enter Your Daily Expenses</h1>
    
    <!-- Form for User to Input Expenses -->
    <form method="post" style="max-width: 400px; margin: 0 auto; background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <label style="font-size: 14px; margin-right: 10px;">Enter expense for Day 1:</label><input type="number" name="expense_day_1" step="0.01" value="<?php echo isset($_POST['expense_day_1']) ? $_POST['expense_day_1'] : ''; ?>" style="width: calc(100% - 20px); padding: 8px; margin: 5px 0 15px 0; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;"><br>
        
        <label style="font-size: 14px; margin-right: 10px;">Enter expense for Day 2:</label><input type="number" name="expense_day_2" step="0.01" value="<?php echo isset($_POST['expense_day_2']) ? $_POST['expense_day_2'] : ''; ?>" style="width: calc(100% - 20px); padding: 8px; margin: 5px 0 15px 0; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;"><br>
        
        <label style="font-size: 14px; margin-right: 10px;">Enter expense for Day 3:</label><input type="number" name="expense_day_3" step="0.01" value="<?php echo isset($_POST['expense_day_3']) ? $_POST['expense_day_3'] : ''; ?>" style="width: calc(100% - 20px); padding: 8px; margin: 5px 0 15px 0; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;"><br>
        
        <label style="font-size: 14px; margin-right: 10px;">Enter expense for Day 4:</label><input type="number" name="expense_day_4" step="0.01" value="<?php echo isset($_POST['expense_day_4']) ? $_POST['expense_day_4'] : ''; ?>" style="width: calc(100% - 20px); padding: 8px; margin: 5px 0 15px 0; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;"><br>
        
        <label style="font-size: 14px; margin-right: 10px;">Enter expense for Day 5:</label><input type="number" name="expense_day_5" step="0.01" value="<?php echo isset($_POST['expense_day_5']) ? $_POST['expense_day_5'] : ''; ?>" style="width: calc(100% - 20px); padding: 8px; margin: 5px 0 15px 0; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;"><br>
        
        <label style="font-size: 14px; margin-right: 10px;">Enter expense for Day 6:</label><input type="number" name="expense_day_6" step="0.01" value="<?php echo isset($_POST['expense_day_6']) ? $_POST['expense_day_6'] : ''; ?>" style="width: calc(100% - 20px); padding: 8px; margin: 5px 0 15px 0; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;"><br>
        
        <label style="font-size: 14px; margin-right: 10px;">Enter expense for Day 7:</label><input type="number" name="expense_day_7" step="0.01" value="<?php echo isset($_POST['expense_day_7']) ? $_POST['expense_day_7'] : ''; ?>" style="width: calc(100% - 20px); padding: 8px; margin: 5px 0 15px 0; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;"><br>

        <input type="submit" value="Calculate" style="background-color: #4CAF50; color: white; padding: 12px 18px; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; width: 100%;"><br>
    </form>

    <?php
    // Display results if form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<div style='background-color: #fff; padding: 15px; margin-top: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 400px; margin: 20px auto;'>";
        echo "<h2 style='font-size: 20px; margin-bottom: 10px;'>Results</h2>";
        echo "<p style='font-size: 16px; color: #555;'>Total expenses for the week: <strong>Rs " . number_format($total_expenses, 2) . "</strong></p>";
        echo "<p style='font-size: 16px; color: #555;'>Average daily expense: <strong>Rs " . number_format($average_expense, 2) . "</strong></p>";
        echo "<p style='font-size: 16px; color: #555;'>Day with the highest expense: <strong>Day $day_max (Expense: Rs " . number_format($max_expense, 2) . ")</strong></p>";
        echo "<p style='font-size: 16px; color: #555;'>Day with the lowest expense: <strong>Day $day_min (Expense: Rs " . number_format($min_expense, 2) . ")</strong></p>";
        echo "</div>";
    }
    ?>

</body>
</html>
