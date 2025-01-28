<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track expenses of week</title>
</head>
<body>
    <h2>Expenses of week!</h2>
    <form method = "post" >
        Expense for Day 1: <input type = "number"   name = "expense_day_1"> <br><br>
        Expense for Day 2: <input type= "number"    name = "expense_day_2"> <br><br>
        Expense for day 3: <input type = "number"   name = "expense_day_3"> <br><br>
        Expense for day 4: <input type = "number"   name = "expense_day_4"> <br><br>
        Expense for day 5: <input type = "number"   name = "expense_day_5"> <br><br>
        Expense for day 6: <input type = "number"   name = "expense_day_6"> <br><br>
        Expense for day 7: <input type = "number"   name = "expense_day_6"> <br><br>
        <input type="submit" value="Calculate">

    </form>
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Use isset() to check if the input exists, and assign 0 if not
    $expense_day_1 = isset($_POST['expense_day_1']) ? floatval($_POST['expense_day_1']) : 0;
    $expense_day_2 = isset($_POST['expense_day_2']) ? floatval($_POST['expense_day_2']) : 0;
    $expense_day_3 = isset($_POST['expense_day_3']) ? floatval($_POST['expense_day_3']) : 0;
    $expense_day_4 = isset($_POST['expense_day_4']) ? floatval($_POST['expense_day_4']) : 0;
    $expense_day_5 = isset($_POST['expense_day_5']) ? floatval($_POST['expense_day_5']) : 0;
    $expense_day_6 = isset($_POST['expense_day_6']) ? floatval($_POST['expense_day_6']) : 0;
    $expense_day_7 = isset($_POST['expense_day_7']) ? floatval($_POST['expense_day_7']) : 0;

    // Now, all variables are guaranteed to have a numeric value (0 if not set)



//store expenses in a array for calculation
$expenses = array($expense_day_1, $expense_day_2, $expense_day_3, $expense_day_4, $expense_day_5, $expense_day_6, $expense_day_7);

// total expanse
$total_expense = array_sum($expenses);



$avg_expenses = $total_expense / 7;

//Find the lowest and heightest expenses

$maixum_expenses = max($expenses);
$min_expenses = min($expenses);

// find  the day which has heighest and lowest expenses
$day_maxi = array_search($maixum_expenses, $expenses) + 1;
$day_mini = array_search($min_expenses, $expenses) + 1;

//display result 
echo "<h2> result!</h2>";
echo "Total expenses of the week: Rs" . number_format($total_expense,2) . "<br>";
echo "Average daily expenses: Rs" . number_format($avg_expenses,2) . "<br>";
echo "Day with the highest expense: Day $day_maxi (Expense: Rs" . number_format($maixum_expenses, 2) . ")<br>";
echo "Day with the lowest expense: Day $day_mini (Expense: Rs" . number_format($min_expenses, 2) . ")<br>";
}
?>
</body>
</html>








