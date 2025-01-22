<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expenses Tracker</title>
</head>
<body>
    <h1>Enter Your Daily Expenses</h1>
    
    <!-- Form for User to Input Expenses -->
    <form method="post">
        Enter expense for Day 1: <input type="number" name="expense_day_1" step="0.01"><br><br>
        Enter expense for Day 2: <input type="number" name="expense_day_2" step="0.01"><br><br>
        Enter expense for Day 3: <input type="number" name="expense_day_3" step="0.01"><br><br>
        Enter expense for Day 4: <input type="number" name="expense_day_4" step="0.01"><br><br>
        Enter expense for Day 5: <input type="number" name="expense_day_5" step="0.01"><br><br>
        Enter expense for Day 6: <input type="number" name="expense_day_6" step="0.01"><br><br>
        Enter expense for Day 7: <input type="number" name="expense_day_7" step="0.01"><br><br>
        <input type="submit" value="Calculate">
    </form>

    <?php
    // PHP code to calculate total, average, highest, and lowest expenses
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get expenses for each day
        $expense_day_1 = isset($_POST['expense_day_1']) ? floatval($_POST['expense_day_1']) : 0;
        $expense_day_2 = isset($_POST['expense_day_2']) ? floatval($_POST['expense_day_2']) : 0;
        $expense_day_3 = isset($_POST['expense_day_3']) ? floatval($_POST['expense_day_3']) : 0;
        $expense_day_4 = isset($_POST['expense_day_4']) ? floatval($_POST['expense_day_4']) : 0;
        $expense_day_5 = isset($_POST['expense_day_5']) ? floatval($_POST['expense_day_5']) : 0;
        $expense_day_6 = isset($_POST['expense_day_6']) ? floatval($_POST['expense_day_6']) : 0;
        $expense_day_7 = isset($_POST['expense_day_7']) ? floatval($_POST['expense_day_7']) : 0;

        // Store expenses in an array for calculation
        $expenses = array($expense_day_1, $expense_day_2, $expense_day_3, $expense_day_4, $expense_day_5, $expense_day_6, $expense_day_7);

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

        // Display results
        echo "<h2>Results</h2>";
        echo "Total expenses for the week: Rs" . number_format($total_expenses, 2) . "<br>";
        echo "Average daily expense: Rs " . number_format($average_expense, 2) . "<br>";
        echo "Day with the highest expense: Day $day_max (Expense: Rs " . number_format($max_expense, 2) . ")<br>";
        echo "Day with the lowest expense: Day $day_min (Expense: Rs " . number_format($min_expense, 2) . ")<br>";
    }
    ?>
</body>
</html>
