<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expenses Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(223, 218, 218);
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }
        input[type="number"], input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .results {
            background-color: #fff;
            padding: 15px;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .results p {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daily Expenses Tracker</h1>

        <?php
       
        $total_expenses = 0;
        $average_expense = 0;
        $max_expense = 0;
        $min_expense = 0;
        $day_max = 0;
        $day_min = 0;

        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $expenses = [];

          
            for ($day = 1; $day <= 7; $day++) {
                $expense_key = "expense_day_$day";
                $expenses[$day] = isset($_POST[$expense_key]) ? floatval($_POST[$expense_key]) : 0;
            }

            
            $total_expenses = array_sum($expenses);
            $average_expense = $total_expenses / 7;
            $max_expense = max($expenses);
            $min_expense = min($expenses);
            $day_max = array_search($max_expense, $expenses);
            $day_min = array_search($min_expense, $expenses);
        }
        ?>

        <!-- Form for User to Input  -->
        <form method="post">
            <?php for ($day = 1; $day <= 7; $day++): ?>
                <label for="expense_day_<?php echo $day; ?>">Enter expense for Day <?php echo $day; ?>:</label>
                <input type="number" id="expense_day_<?php echo $day; ?>" name="expense_day_<?php echo $day; ?>" step="0.01" value="<?php echo isset($_POST["expense_day_$day"]) ? $_POST["expense_day_$day"] : ''; ?>">
            <?php endfor; ?>
            <input type="submit" value="Calculate">
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <!-- Display Results -->
            <div class="results">
                <h2>Results</h2>
                <p>Total expenses for the week: <strong>Rs <?php echo number_format($total_expenses, 2); ?></strong></p>
                <p>Average daily expense: <strong>Rs <?php echo number_format($average_expense, 2); ?></strong></p>
                <p>Day with the highest expense: <strong>Day <?php echo $day_max; ?> (Expense: Rs <?php echo number_format($max_expense, 2); ?>)</strong></p>
                <p>Day with the lowest expense: <strong>Day <?php echo $day_min; ?> (Expense: Rs <?php echo number_format($min_expense, 2); ?>)</strong></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
