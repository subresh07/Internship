<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action = "practice_1.php" method = "get">
        <label>quantity: </label><br>
        <input type = "text" name = "quantity">
        <input type = "submit" value = "total">


    </form>
</body>
</html>
<?php
$item = "pizza";
$price = 5.99;
$total = null;

if(isset($_GET["quantity"]) && !empty($_GET["quantity"])){
    $quantity = $_GET["quantity"];

    $total = $quantity * $price;

    echo "you have ordered {$quantity} X {$item}<br>";
    echo "your total is: \${$total} .";
}




?>