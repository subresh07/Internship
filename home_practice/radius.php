<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="radius.php" method = "post">
        <label> radius:</label>
        <input type="text" name="radius">
        <label> height:</label>
        <input type="text" name="height">
        <input type="submit" value = "calculate">
    </form>
    
</body>
</html>
<?php
$radius = $_POST["radius"];
$h = $_POST["height"];

$circumferance = null;
$area = null;
$volume = null;
$volume = null;

$circumferance = 2 * pi() * $radius;
$circumferance = round($circumferance,1);

$area = 2 * pi()* $radius * $radius;
$area = round($area,2);

$volume = pi()* $radius * $radius * $h;
$volume = round($volume,2);



echo "circumferance = {$circumferance}cm <br>";
echo "area = {$area}cm aquare<br>";
echo "volume = {$volume}cm cube<br>";

?>