<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="aasciative,php" method ="post">
        <label >Enter a country name:</label>
        <input type = "text" name = "country">
        <input type = "submit" >
    </form>
    
</body>
</html>


<?php

$capitals = ["america" => "Washington_dc",
          "japan"=> "tokiyo",
          "nepal"=> "kathmandu",
          "malesiya"=> "kolalampur" ];

// $array["japan"]  = "bejing"  ; 
// array_pop($array);    
// array_shift($array);  
// $keys = array_keys($array); 
//     $valus = array_values($array); 
// foreach($array as $valus ){
//     echo "{$valus}<br>";

// }

$capital = $_POST["country"];

echo $capital;


?>