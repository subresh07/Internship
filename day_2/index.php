<?php declare (strict_types = 1) ?>


 <!-- Operator Precedenceence -->
<?php
#opertators
#use claer and meaning ful variables and maintain simplicity

$first = 10;
$second = 20;
$third = 30;

$result = $first +  $second * $third;
echo "Result of operator precdedence: $result";

echo "<br>";
//parentheses to override operator precedence
$adjustedResult  = ($first + $second) * $third;
echo 'Result of adjusted precedence:'. $adjustedResult;

echo "<br>";


?>


<!-- # Control Structures (if, else, elseif) -->
<?php
$age = 18;

if ($age < 18 ) {
    echo 'underage';

} elseif ($age == 18 ){
    echo 'Just an adult';

} else {
    echo 'Adult';
}
echo "<br>";

?>

<!-- Loops (for, foreach, while, do-while) -->

<?php
// for loop 
echo 'here is loop: ';
for ($i = 0; $i < 5; $i++) {
    
    echo  $i;
}
?>

<!--array  -->
<?php 
echo "<br>";
$array = [10,20,40,50,60];

echo $array[2];
echo "<br>"
?>

<!-- for each loop -->
<?php
$array = ["milan" => 34 , "subrace" => 33 , "sandip" => 50 ];
foreach ($array as $name => $marks  ){
    echo "$name :  $marks <br>" ; 
}
?>


<!-- while loop -->

<?php
$i = 0;
while ($i < 10){
    echo $i;
    $i++;
}


?>

<!-- DO- while loop -->

<?php
echo "<br>";
$a = 0;
do{
    echo $a;
    $a++;

} while ($a < 8)

?>

<!-- Switch Statement -->


<?php
echo "<br>";
$day = 7;
switch($day) {
    case 1:
        echo "Sunday\n";
        break;
    case 2:
        echo "monday\n";
        break;
    case 3:
        echo "Tuesday\n";
        break;
    case 4:
        echo "Wednesday\n";
        break;
    case 5:
        echo "Thursday\n";
        break;
    case 6:
        echo "Friday\n";
        break;
    case 7:
        echo "Saturday\n";
        break;

}



?>


<!-- Match Expression -->
 <?php

 echo "<br>";
$day = 8;

echo match ($day){
    1 => 'sunday',
    2 => 'monday',
    3 => 'tueday',
    4 => 'wedday',
    5 => 'thursday',
    6 => 'friday',
    7 => 'satday',
    default => 'Invalid day',

};

 ?>


<!-- Functions (function, fn, arrow functions) -->

<?php
echo "<br>";
function add($a, $b) {
     return $a + $b;
}

echo "Sum: ". add(5,3)


// Arrow function 

// $multiply = fn($a,$b) => $a * $b;
// echo "product: " . $multiply(5,7);


?>
<?php
echo "<br>";
$multiply = fn($a, $b) => $a * $b;
echo "Product: " . $multiply(5, 3);
?>


<?php
$subtract = function($a , $b){
    return $a - $b;

};
echo "Difference: " . $subtract(5,3);


?>


